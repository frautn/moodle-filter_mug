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

use filter_mug\local\modifier\page_modifier;
use filter_mug\local\modifier\question_modifier;

/**
 * Tests for the modifier auto-discovery registry.
 *
 * @package    filter_mug
 * @copyright  2026 Your Name <you@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \filter_mug\modifier_registry
 */
final class modifier_registry_test extends \advanced_testcase {

    public function test_get_modifiers_discovers_shipped_modifiers(): void {
        $classnames = array_map(get_class(...), modifier_registry::get_modifiers());

        $this->assertContains(page_modifier::class, $classnames);
        $this->assertContains(question_modifier::class, $classnames);
    }

    public function test_find_for_returns_null_when_nothing_matches(): void {
        $this->resetAfterTest(true);

        $context = \context_system::instance();
        $this->assertNull(modifier_registry::find_for($context, []));
    }
}
