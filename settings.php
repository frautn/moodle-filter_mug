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

/**
 * Admin settings for filter_mug.
 *
 * One enable toggle + one injected text setting per supported modifier.
 * When a new modifier is added, add its matching settings block here.
 *
 * @package    filter_mug
 * @copyright  2026 Your Name <you@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_heading(
        'filter_mug/pageheading',
        get_string('settings:pageheading', 'filter_mug'),
        ''
    ));

    $settings->add(new admin_setting_configcheckbox(
        'filter_mug/page_enabled',
        get_string('settings:page_enabled', 'filter_mug'),
        get_string('settings:page_enabled_desc', 'filter_mug'),
        1
    ));

    $settings->add(new admin_setting_configtextarea(
        'filter_mug/page_text',
        get_string('settings:page_text', 'filter_mug'),
        get_string('settings:page_text_desc', 'filter_mug'),
        get_string('settings:page_text_default', 'filter_mug'),
        PARAM_RAW
    ));

    $settings->add(new admin_setting_heading(
        'filter_mug/questionheading',
        get_string('settings:questionheading', 'filter_mug'),
        ''
    ));

    $settings->add(new admin_setting_configcheckbox(
        'filter_mug/question_enabled',
        get_string('settings:question_enabled', 'filter_mug'),
        get_string('settings:question_enabled_desc', 'filter_mug'),
        1
    ));

    $settings->add(new admin_setting_configtextarea(
        'filter_mug/question_text',
        get_string('settings:question_text', 'filter_mug'),
        get_string('settings:question_text_desc', 'filter_mug'),
        get_string('settings:question_text_default', 'filter_mug'),
        PARAM_RAW
    ));
}
