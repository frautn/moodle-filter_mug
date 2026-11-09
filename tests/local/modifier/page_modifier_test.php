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

namespace filter_mug\local\modifier;

/**
 * Tests for the mod_page content modifier.
 *
 * @package    filter_mug
 * @copyright  2026 Your Name <you@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \filter_mug\local\modifier\page_modifier
 */
final class page_modifier_test extends \advanced_testcase {

    public function test_supports_page_context_only(): void {
        $this->resetAfterTest(true);

        $course = $this->getDataGenerator()->create_course();
        $page = $this->getDataGenerator()->create_module('page', ['course' => $course->id]);
        $label = $this->getDataGenerator()->create_module('label', ['course' => $course->id]);

        $modifier = new page_modifier();

        $this->assertTrue($modifier->supports(\context_module::instance($page->cmid), []));
        $this->assertFalse($modifier->supports(\context_module::instance($label->cmid), []));
        $this->assertFalse($modifier->supports(\context_course::instance($course->id), []));
    }

    public function test_supports_respects_enabled_setting(): void {
        $this->resetAfterTest(true);

        $course = $this->getDataGenerator()->create_course();
        $page = $this->getDataGenerator()->create_module('page', ['course' => $course->id]);
        $context = \context_module::instance($page->cmid);

        $modifier = new page_modifier();

        set_config('page_enabled', 0, 'filter_mug');
        $this->assertFalse($modifier->supports($context, []));

        set_config('page_enabled', 1, 'filter_mug');
        $this->assertTrue($modifier->supports($context, []));
    }

    public function test_modify_appends_configured_text(): void {
        $this->resetAfterTest(true);

        $course = $this->getDataGenerator()->create_course();
        $page = $this->getDataGenerator()->create_module('page', ['course' => $course->id]);
        $context = \context_module::instance($page->cmid);

        set_config('page_text', '<p>Injected</p>', 'filter_mug');

        $modifier = new page_modifier();
        $result = $modifier->modify('<p>Original</p>', $context, []);

        $this->assertStringContainsString('Original', $result);
        $this->assertStringContainsString('Injected', $result);
    }

    public function test_modify_is_noop_when_no_text_configured(): void {
        $this->resetAfterTest(true);

        set_config('page_text', '', 'filter_mug');

        $modifier = new page_modifier();
        $this->assertSame('<p>Original</p>', $modifier->modify('<p>Original</p>', \context_system::instance(), []));
    }
}
