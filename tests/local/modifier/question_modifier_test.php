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
 * Tests for the question content modifier.
 *
 * @package    filter_mug
 * @copyright  2026 Your Name <you@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \filter_mug\local\modifier\question_modifier
 */
final class question_modifier_test extends \advanced_testcase {

    public function test_supports_quiz_and_qbank_contexts_only(): void {
        $this->resetAfterTest(true);

        $course = $this->getDataGenerator()->create_course();
        $quiz = $this->getDataGenerator()->create_module('quiz', ['course' => $course->id]);
        $qbank = $this->getDataGenerator()->create_module('qbank', ['course' => $course->id]);
        $page = $this->getDataGenerator()->create_module('page', ['course' => $course->id]);

        $modifier = new question_modifier();

        $this->assertTrue($modifier->supports(\context_module::instance($quiz->cmid), []));
        $this->assertTrue($modifier->supports(\context_module::instance($qbank->cmid), []));
        $this->assertFalse($modifier->supports(\context_module::instance($page->cmid), []));
        $this->assertFalse($modifier->supports(\context_course::instance($course->id), []));
    }

    public function test_modify_appends_configured_text(): void {
        $this->resetAfterTest(true);

        $course = $this->getDataGenerator()->create_course();
        $quiz = $this->getDataGenerator()->create_module('quiz', ['course' => $course->id]);
        $context = \context_module::instance($quiz->cmid);

        set_config('question_text', '<p>Injected</p>', 'filter_mug');

        $modifier = new question_modifier();
        $result = $modifier->modify('<p>What is 2+2?</p>', $context, []);

        $this->assertStringContainsString('What is 2+2?', $result);
        $this->assertStringContainsString('Injected', $result);
    }
}
