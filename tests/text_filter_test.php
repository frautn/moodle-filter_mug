<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace filter_mug;

/**
 * End-to-end tests for filter_mug, exercising the real format_text() pipeline.
 *
 * @package    filter_mug
 * @copyright  2026 Your Name <you@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \filter_mug\text_filter
 */
final class text_filter_test extends \advanced_testcase {

    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest(true);
        $this->setAdminUser();

        \filter_manager::reset_caches();
        filter_set_global_state('mug', TEXTFILTER_ON);

        set_config('page_text', '<p>Injected page text</p>', 'filter_mug');
        set_config('page_enabled', 1, 'filter_mug');
        set_config('question_text', '<p>Injected question text</p>', 'filter_mug');
        set_config('question_enabled', 1, 'filter_mug');
    }

    public function test_page_content_is_augmented(): void {
        $course = $this->getDataGenerator()->create_course();
        $page = $this->getDataGenerator()->create_module('page', ['course' => $course->id]);
        $context = \context_module::instance($page->cmid);

        $result = format_text('<p>Original page content</p>', FORMAT_HTML, ['context' => $context]);

        $this->assertStringContainsString('Original page content', $result);
        $this->assertStringContainsString('Injected page text', $result);
    }

    public function test_quiz_content_is_augmented(): void {
        $course = $this->getDataGenerator()->create_course();
        $quiz = $this->getDataGenerator()->create_module('quiz', ['course' => $course->id]);
        $context = \context_module::instance($quiz->cmid);

        $result = format_text('<p>What is 2+2?</p>', FORMAT_HTML, ['context' => $context]);

        $this->assertStringContainsString('What is 2+2?', $result);
        $this->assertStringContainsString('Injected question text', $result);
    }

    public function test_unrelated_context_is_left_untouched(): void {
        $course = $this->getDataGenerator()->create_course();
        $context = \context_course::instance($course->id);

        $result = format_text('<p>Some course summary</p>', FORMAT_HTML, ['context' => $context]);

        $this->assertStringContainsString('Some course summary', $result);
        $this->assertStringNotContainsString('Injected', $result);
    }

    public function test_disabled_modifier_is_a_noop(): void {
        set_config('page_enabled', 0, 'filter_mug');

        $course = $this->getDataGenerator()->create_course();
        $page = $this->getDataGenerator()->create_module('page', ['course' => $course->id]);
        $context = \context_module::instance($page->cmid);

        $result = format_text('<p>Original page content</p>', FORMAT_HTML, ['context' => $context]);

        $this->assertStringContainsString('Original page content', $result);
        $this->assertStringNotContainsString('Injected', $result);
    }
}
