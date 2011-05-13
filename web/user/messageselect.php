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
 * This file is part of the User section Moodle
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package user
 */

require_once('../config.php');
require_once($CFG->dirroot.'/message/lib.php');

$id = required_param('id',PARAM_INT);

$messagebody = optional_param('messagebody','',PARAM_CLEANHTML);
$send = optional_param('send','',PARAM_BOOL);
$preview = optional_param('preview','',PARAM_BOOL);
$edit = optional_param('edit','',PARAM_BOOL);
$returnto = optional_param('returnto','',PARAM_LOCALURL);
$format = optional_param('format',FORMAT_MOODLE,PARAM_INT);
$deluser = optional_param('deluser',0,PARAM_INT);

$url = new moodle_url('/user/messageselect.php', array('id'=>$id));
if ($messagebody !== '') {
    $url->param('messagebody', $messagebody);
}
if ($send !== '') {
    $url->param('send', $send);
}
if ($preview !== '') {
    $url->param('preview', $preview);
}
if ($edit !== '') {
    $url->param('edit', $edit);
}
if ($returnto !== '') {
    $url->param('returnto', $returnto);
}
if ($format !== FORMAT_MOODLE) {
    $url->param('format', $format);
}
if ($deluser !== 0) {
    $url->param('deluser', $deluser);
}
$PAGE->set_url($url);
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

//Sean Hall - allows bulk messaging across courses
if($id!="bulk"){
    if (!$course = $DB->get_record('course', array('id'=>$id))) {
        print_error('invalidcourseid');
    }
}
//
//if (!$course = $DB->get_record('course', array('id'=>$id))) {
//        print_error('invalidcourseid');
//    }
require_login();

$coursecontext = get_context_instance(CONTEXT_COURSE, $id);   // Course context
$systemcontext = get_context_instance(CONTEXT_SYSTEM);   // SYSTEM context

//Sean Hall - allows bulk messaging across courses
if($id!="bulk"){
require_capability('moodle/course:bulkmessaging', $coursecontext);
}
if (empty($SESSION->emailto)) {
    $SESSION->emailto = array();
}
if (!array_key_exists($id,$SESSION->emailto)) {
    $SESSION->emailto[$id] = array();
}

if ($deluser) {
    if (array_key_exists($id,$SESSION->emailto) && array_key_exists($deluser,$SESSION->emailto[$id])) {
        unset($SESSION->emailto[$id][$deluser]);
    }
}

if (empty($SESSION->emailselect[$id]) || $messagebody) {
    $SESSION->emailselect[$id] = array('messagebody' => $messagebody);
}

$messagebody = $SESSION->emailselect[$id]['messagebody'];

$count = 0;

foreach ($_POST as $k => $v) {
    if (preg_match('/^(user|teacher)(\d+)$/',$k,$m)) {
        if (!array_key_exists($m[2],$SESSION->emailto[$id])) {
            if ($user = $DB->get_record_select('user', "id = ?", array($m[2]), 'id,firstname,lastname,idnumber,email,mailformat,lastaccess, lang')) {
                $SESSION->emailto[$id][$m[2]] = $user;
                $count++;
            }
        }
    }
}

$strtitle = get_string('coursemessage');

$link = null;
if (has_capability('moodle/course:viewparticipants', $coursecontext) || has_capability('moodle/site:viewparticipants', $systemcontext)) {
    $link = new moodle_url("/user/index.php", array('id'=>$course->id));
}
$PAGE->navbar->add(get_string('participants'), $link);
$PAGE->navbar->add($strtitle);
$PAGE->set_title($strtitle);
$PAGE->set_heading($strtitle);
echo $OUTPUT->header();
// if messaging is disabled on site, we can still allow users with capabilities to send emails instead
if (empty($CFG->messaging)) {
    echo $OUTPUT->notification(get_string('messagingdisabled','message'));
}

if ($count) {
    if ($count == 1) {
        $heading = get_string('addedrecip','moodle',$count);
    } else {
        $heading = get_string('addedrecips','moodle',$count);
    }
    echo $OUTPUT->heading($heading);
}

if (!empty($messagebody) && !$edit && !$deluser && ($preview || $send)) {
    if (count($SESSION->emailto[$id])) {
        if (!empty($preview)) {
            echo '<form method="post" action="messageselect.php" style="margin: 0 20px;">
<input type="hidden" name="returnto" value="'.s($returnto).'" />
<input type="hidden" name="id" value="'.$id.'" />
<input type="hidden" name="format" value="'.$format.'" />
';
            echo "<h3>".get_string('previewhtml')."</h3><div class=\"messagepreview\">\n".format_text($messagebody,$format)."\n</div>\n";
            echo '<p align="center"><input type="submit" name="send" value="'.get_string('sendmessage', 'message').'" />'."\n";
            echo '<input type="submit" name="edit" value="'.get_string('update').'" /></p>';
            echo "\n</form>";
        } else if (!empty($send)) {
            $good = 1;
            foreach ($SESSION->emailto[$id] as $user) {
                $good = $good && message_post_message($USER,$user,$messagebody,$format);
            }
            if (!empty($good)) {
                echo $OUTPUT->heading(get_string('messagedselectedusers'));
                unset($SESSION->emailto[$id]);
                unset($SESSION->emailselect[$id]);
            } else {
                echo $OUTPUT->heading(get_string('messagedselectedusersfailed'));
            }
            echo '<p align="center"><a href="index.php?id='.$id.'">'.get_string('backtoparticipants').'</a></p>';
        }
        echo $OUTPUT->footer();
        exit;
    } else {
        echo $OUTPUT->notification(get_string('nousersyet'));
    }
}

echo '<p align="center"><a href="'.$returnto.'">'.get_string("keepsearching").'</a>'.((count($SESSION->emailto[$id])) ? ', '.get_string('usemessageform') : '').'</p>';

if ((!empty($send) || !empty($preview) || !empty($edit)) && (empty($messagebody))) {
    echo $OUTPUT->notification(get_string('allfieldsrequired'));
}

if (count($SESSION->emailto[$id])) {
    $usehtmleditor = can_use_html_editor();
    require("message.html");
}

echo $OUTPUT->footer();


