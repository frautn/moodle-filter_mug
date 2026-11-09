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

namespace filter_mug\local;

use core\context;

/**
 * Shared helper for modifiers that need to know which activity module a
 * CONTEXT_MODULE context belongs to.
 *
 * @package    filter_mug
 * @copyright  2026 Your Name <you@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
trait cm_context_trait {

    /**
     * Get the modname (e.g. 'page', 'quiz', 'qbank') of the course module a context belongs to.
     *
     * Uses cached course modinfo, as recommended by {@see get_coursemodule_from_id()}.
     *
     * @param context $context any context.
     * @return string|null the modname, or null if $context is not a module context
     *                      or the course module cannot be resolved.
     */
    protected function get_modname(context $context): ?string {
        if ($context->contextlevel != CONTEXT_MODULE) {
            return null;
        }

        try {
            $coursecontext = $context->get_course_context();
            $cm = get_fast_modinfo($coursecontext->instanceid)->get_cm($context->instanceid);
            return $cm->modname;
        } catch (\moodle_exception $e) {
            return null;
        }
    }
}
