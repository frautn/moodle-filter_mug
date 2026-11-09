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

use core\context;
use core\output\html_writer;
use filter_mug\local\cm_context_trait;
use filter_mug\local\modifier_interface;

/**
 * Appends configured text to the content of mod_page activities.
 *
 * @package    filter_mug
 * @copyright  2026 Your Name <you@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class page_modifier implements modifier_interface {
    use cm_context_trait;

    #[\Override]
    public function supports(context $context, array $options): bool {
        if (!get_config('filter_mug', 'page_enabled')) {
            return false;
        }

        return $this->get_modname($context) === 'page';
    }

    #[\Override]
    public function modify(string $text, context $context, array $options): string {
        $extra = get_config('filter_mug', 'page_text');
        if (trim((string) $extra) === '') {
            return $text;
        }

        return $text . html_writer::div($extra, 'filter-mug-page-text');
    }
}
