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
 * Strings for filter_mug.
 *
 * @package    filter_mug
 * @copyright  2026 Your Name <you@example.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Mug';
$string['filtername'] = 'Mug content injector';
$string['privacy:metadata'] = 'The Mug filter only appends admin-configured static text to existing content; it does not store or process any personal data.';

$string['settings:pageheading'] = 'Page activities';
$string['settings:page_enabled'] = 'Enable for Page activities';
$string['settings:page_enabled_desc'] = 'When enabled, the text below is appended to the content of every mod_page activity.';
$string['settings:page_text'] = 'Text to append';
$string['settings:page_text_desc'] = 'HTML content appended after a Page activity\'s content.';
$string['settings:page_text_default'] = '<p>Added by the Mug filter.</p>';

$string['settings:questionheading'] = 'Questions';
$string['settings:question_enabled'] = 'Enable for questions';
$string['settings:question_enabled_desc'] = 'When enabled, the text below is appended to question content shown inside quizzes and the question bank (mod_quiz / mod_qbank).';
$string['settings:question_text'] = 'Text to append';
$string['settings:question_text_desc'] = 'HTML content appended after a question\'s text.';
$string['settings:question_text_default'] = '<p>Added by the Mug filter.</p>';
