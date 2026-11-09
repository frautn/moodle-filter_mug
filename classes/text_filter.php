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
 * Text filter for filter_mug.
 *
 * This is the single, stable hook point into Moodle's text-rendering
 * pipeline (format_text()/format_string()). It stays a thin orchestrator:
 * all activity-specific logic lives in {@see modifier_registry} and the
 * individual modifier classes, so this file should rarely need changes.
 *
 * @package    filter_mug
 * @copyright  2026 Your Name <you@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class text_filter extends \core_filters\text_filter {

    #[\Override]
    public function filter($text, array $options = []) {
        if (trim($text) === '') {
            return $text;
        }

        $modifier = modifier_registry::find_for($this->context, $options);
        if ($modifier === null) {
            return $text;
        }

        return $modifier->modify($text, $this->context, $options);
    }
}
