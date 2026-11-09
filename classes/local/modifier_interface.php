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
 * Contract for a single activity-type content modifier.
 *
 * To add support for a new activity in the future, create a new class
 * implementing this interface under classes/local/modifier/ and it will
 * be picked up automatically by {@see \filter_mug\modifier_registry} -
 * no other file needs to change.
 *
 * @package    filter_mug
 * @copyright  2026 Your Name <you@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
interface modifier_interface {

    /**
     * Whether this modifier knows how to handle text displayed in the given context.
     *
     * @param context $context the context the text being filtered belongs to.
     * @param array $options the options passed to the filter.
     * @return bool
     */
    public function supports(context $context, array $options): bool;

    /**
     * Modify the text before it is displayed.
     *
     * @param string $text the HTML content to process.
     * @param context $context the context the text being filtered belongs to.
     * @param array $options the options passed to the filter.
     * @return string the (possibly) modified HTML content.
     */
    public function modify(string $text, context $context, array $options): string;
}
