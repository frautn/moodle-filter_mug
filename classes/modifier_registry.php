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

use core\context;
use core_component;
use filter_mug\local\modifier_interface;

/**
 * Discovers and runs the {@see modifier_interface} implementations.
 *
 * Modifiers are auto-discovered from the filter_mug\local\modifier namespace,
 * the same mechanism Moodle core uses for e.g. privacy providers and task
 * schedulers. Adding support for a new activity never requires touching this
 * file: just add a new class under classes/local/modifier/.
 *
 * @package    filter_mug
 * @copyright  2026 Your Name <you@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class modifier_registry {

    /** @var modifier_interface[]|null cached modifier instances. */
    private static ?array $modifiers = null;

    /**
     * Get all registered modifier instances.
     *
     * @return modifier_interface[]
     */
    public static function get_modifiers(): array {
        if (self::$modifiers === null) {
            self::$modifiers = [];
            $classes = core_component::get_component_classes_in_namespace('filter_mug', 'local\\modifier');
            foreach (array_keys($classes) as $classname) {
                if (is_subclass_of($classname, modifier_interface::class)) {
                    self::$modifiers[] = new $classname();
                }
            }
        }

        return self::$modifiers;
    }

    /**
     * Find the first modifier that supports the given context.
     *
     * @param context $context the context the text being filtered belongs to.
     * @param array $options the options passed to the filter.
     * @return modifier_interface|null
     */
    public static function find_for(context $context, array $options): ?modifier_interface {
        foreach (self::get_modifiers() as $modifier) {
            if ($modifier->supports($context, $options)) {
                return $modifier;
            }
        }

        return null;
    }

    /**
     * Reset the cached modifier list. Intended for use in unit tests only.
     */
    public static function reset_cache(): void {
        self::$modifiers = null;
    }
}
