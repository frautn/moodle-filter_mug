# filter_mug

A Moodle 5.3 **filter** plugin that injects extra content into existing
activities before they are displayed — without modifying the activities
themselves.

It works by hooking into Moodle's text-rendering pipeline
(`format_text()`), which is already called by every activity that shows
rich content (Page resources, question text in quizzes/the question bank,
and in principle anything else that goes through `format_text()`).

## Why a filter plugin?

Moodle doesn't have a single generic "before displaying this module's
content" hook that works across all activity types. What it does have is
the filter system: virtually all user-facing rich text passes through
`format_text()`/`format_string()`, which invokes every enabled text filter
and tells it which `context` the text belongs to. That's enough to
identify, for example, "this text belongs to a Page activity" or "this
text belongs to a quiz/question bank module" and act accordingly.

## Architecture

```
classes/
├── text_filter.php           Single, stable hook point (core_filters\text_filter).
│                              Delegates to modifier_registry - should rarely change.
├── modifier_registry.php     Auto-discovers modifier_interface implementations under
│                              classes/local/modifier/ via core_component (no manual
│                              registration list to maintain).
└── local/
    ├── modifier_interface.php   Contract: supports(context, options) / modify(text, context, options).
    ├── cm_context_trait.php     Shared helper to resolve a context's course-module modname.
    └── modifier/
        ├── page_modifier.php     Appends configured text to mod_page content.
        └── question_modifier.php Appends configured text to question content
                                   (mod_quiz / mod_qbank contexts).
```

## Adding support for a new activity

1. Create a new class under `classes/local/modifier/`, implementing
   `\filter_mug\local\modifier_interface`.
2. Implement `supports()` to recognise the relevant context (see
   `cm_context_trait::get_modname()` for the common case of "this
   context belongs to course-module type X").
3. Implement `modify()` to change the text.

No other file needs to change — `modifier_registry` picks up the new
class automatically.

## Settings

*Site administration → Plugins → Filters → Mug content injector* exposes
one enable/disable toggle and one HTML text setting per shipped modifier.

## Known limitations

`format_text()` only tells filters the *context* a piece of text belongs
to, not which specific field it came from. So `question_modifier`
currently matches any text rendered inside a quiz/qbank module context
(e.g. it would also affect that quiz's own intro text), not only
question text. Narrowing this further would require extra signals (e.g.
recognisable markers in the text, or capturing filearea/component
information at the call site).

## Tests

- `tests/local/modifier/*_test.php` — unit tests for each modifier.
- `tests/modifier_registry_test.php` — discovery behaviour.
- `tests/text_filter_test.php` — end-to-end tests through the real
  `format_text()` pipeline.
- `tests/behat/mug_filter.feature` — browser-level smoke test.

Run with:

```
vendor/bin/phpunit --filter filter_mug
```
