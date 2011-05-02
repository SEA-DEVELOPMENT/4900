<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Basic page for having WiZiQ plugin in moodle. WiZiQ starts from here.
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->dirroot.'/config.php');
require_once($CFG->dirroot.'/calendar/lib.php');
require_once($CFG->dirroot.'/calendar/event_form.php');
require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->dirroot.'/mod/forum/lib.php');
require_once("lib.php");
require_once("wiziqconf.php");
require_once ($CFG->dirroot.'/course/moodleform_mod.php');
$add      = optional_param('add','', PARAM_ALPHA);
$course   = optional_param('course', 0, PARAM_INT);
$section  = required_param('section', PARAM_INT);
$return   = optional_param('return', 0, PARAM_BOOL);
$courseid = optional_param('course', 0, PARAM_INT);
$cal_y    = optional_param('cal_y', 0, PARAM_INT);
$cal_m    = optional_param('cal_m', 0, PARAM_INT);
$cal_d    = optional_param('cal_d', 0, PARAM_INT);
global $CFG,$COURSE, $OUTPUT;	
$url = new moodle_url('/calendar/event.php');
    
$PAGE->set_url($url);
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$section = required_param('section', PARAM_INT);
$course  = required_param('course', PARAM_INT);
$course  = $DB->get_record('course', array('id'=>$course), '*', MUST_EXIST);
$module  = $DB->get_record('modules', array('name'=>$add), '*', MUST_EXIST);
$viewcalendarurl = new moodle_url(CALENDAR_URL.'view.php');
$viewcalendarurl->params($PAGE->url->params());
$viewcalendarurl->remove_params(array('id','action'));

if (isguestuser()) {
    // Guests cannot do anything with events
    redirect(new moodle_url(CALENDAR_URL.'view.php', array('view'=>'upcoming', 'course'=>$courseid)));
}
 $focus = '';

$site = get_site();

calendar_session_vars();     
   // If a course has been supplied in the URL, change the filters to show that one// iam taking from table wiziq
   
$courseexists = false;
if ($courseid > 0) {
    if ($courseid == SITEID) {
        // If coming from the site page, show all courses
        $SESSION->cal_courses_shown = calendar_get_default_courses(true);
        calendar_set_referring_course(0);
    } else if ($DB->record_exists('course', array('id'=>$courseid))) {
        $courseexists = true;
        // Otherwise show just this one
        $SESSION->cal_courses_shown = $courseid;
        calendar_set_referring_course($SESSION->cal_courses_shown);
    }
}

if (!empty($SESSION->cal_course_referer)) {
    // TODO: This is part of the Great $course Hack in Moodle. Replace it at some point.
    $course = $DB->get_record('course', array('id'=>$SESSION->cal_course_referer));
} else {
    $course = $site;
}

 require_login($course,false);
$calendar = new calendar_information($cal_d, $cal_m, $cal_y);
$calendar->courseid = $courseid;

     $now = usergetdate(time());
    
    if (!isloggedin() or isguestuser()) {
    $defaultcourses = calendar_get_default_courses();
    calendar_set_filters($calendar->courses, $calendar->groups, $calendar->users, $defaultcourses, $defaultcourses);
} else {
    calendar_set_filters($calendar->courses, $calendar->groups, $calendar->users);
}
if ($SESSION->cal_course_referer != SITEID &&
   ($shortname = $DB->get_field('course', 'shortname', array('id'=>$SESSION->cal_course_referer))) !== false) {
    require_login();
    if (empty($course)) {
        $course = $DB->get_record('course', array('id'=>$SESSION->cal_course_referer)); // Useful to have around
    }
}
	$strwiziqs = get_string("modulenameplural", "wiziq");
	$strwiziq  = get_string("WiZiQ", "wiziq");
	$pagetitle="Schedule Class"; 
    //$prefsbutton = calendar_preferences_button();

 $data = new object();
    $data->section          = $section;  // The section number itself - relative!!! (section column in course_sections)
    $data->visible          = $cw->visible;
    $data->course           = $course->id;
    $data->module           = $module->id;
    $data->modulename       = $module->name;
    $data->groupmode        = $course->groupmode;
    $data->groupingid       = $course->defaultgroupingid;
    $data->groupmembersonly = 0;
    $data->id               = '';
    $data->instance         = '';
    $data->coursemodule     = '';
    $data->add              = $add;
    $data->return           = 0; //must be false if this is an add, go back to course view on cancel
	 $sectionname = get_section_name($course, $cw);
    $fullmodulename = get_string('modulename', $module->name);

    if ($data->section && $course->format != 'site') {
        $heading = new object();
        $heading->what = $fullmodulename;
        $heading->to   = $sectionname;
        $pageheading = get_string('addinganewto', 'moodle', $heading);
    } else {
        $pageheading = get_string('addinganew', 'moodle', $fullmodulename);
    }
	
//print title and header
 $PAGE->set_title("$site->shortname: $strwiziqs: $pagetitle");
$PAGE->set_heading($COURSE->fullname);
//$PAGE->set_button($prefsbutton);
$PAGE->set_pagelayout('standard');
$renderer = $PAGE->get_renderer('core_calendar');
$calendar->add_sidecalendar_blocks($renderer, true);
$PAGE->navbar->add($COURSE->fullname, new moodle_url('../../course/view.php?id='.$courseid));
$PAGE->navbar->add($strwiziqs, new moodle_url('../../mod/wiziq/index.php?course='.$courseid));
$PAGE->navbar->add('Schedule Class');
echo $OUTPUT->header();

echo $renderer->start_layout();

class mod_wiziq_mod_form extends moodleform_mod {
 //when this function overrides it will rediret to scheduling page. 
    function definition() {

    $add           = optional_param('add','', PARAM_ALPHA);
	$course        = optional_param('course', 0, PARAM_INT);
	$section       = required_param('section', PARAM_INT);
	$return        = optional_param('return', 0, PARAM_BOOL);  
echo '<p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="3"><strong><img src="../mod/wiziq/pix/icon.gif" hspace="10" height="16" width="16" border="0" alt="" /> Adding new WiZiQ Class. Please Wait............</strong></font></p>';
  		redirect("../mod/wiziq/event.php?add=$add&course=$course&section=$section&return=$return");

       
    }                          
}          

 

?>