<?php

/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * After deleting the class control comes here.
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once("../../config.php");
require_once("lib.php");
require_once($CFG->dirroot."/course/lib.php");
require_once($CFG->dirroot.'/calendar/lib.php');
$view = optional_param('view', 'upcoming', PARAM_ALPHA);
$action = optional_param('action', 'new', PARAM_ALPHA);
$id = optional_param('id', 0, PARAM_INT);
$courseid = optional_param('id', 0, PARAM_INT);
$instance = optional_param('instance', 0, PARAM_INT);
	
$cal_y = optional_param('cal_y', 0, PARAM_INT);
$cal_m = optional_param('cal_m', 0, PARAM_INT);
$cal_d = optional_param('cal_d', 0, PARAM_INT);


  $urlcourse= $courseid;
  $url = new moodle_url('/calendar/event.php', array('instance'=>''));
  
  if ($courseid !== 0) $url->param('course', $courseid);
if ($cal_y !== 0) $url->param('cal_y', $cal_y);
if ($cal_m !== 0) $url->param('cal_m', $cal_m);
if ($cal_d !== 0) $url->param('cal_d', $cal_d);
$PAGE->set_url($url);
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

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
   // If a course has been supplied in the URL, change the filters to show that one
   
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

    require_login($courseid,false);
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
    //$strcalendar = get_string('calendar', 'calendar');
	$strwiziqs = get_string("modulenameplural", "wiziq");
	$strwiziq  = get_string("WiZiQ", "wiziq");
	$pagetitle="Delete WiZiQ Class";
    //$prefsbutton = calendar_preferences_button();
// Print title and header


 $PAGE->set_title("$site->shortname: $strwiziqs: $pagetitle");
$PAGE->set_heading($COURSE->fullname);
//$PAGE->set_button($prefsbutton);
//$PAGE->set_pagelayout('course');
//$renderer = $PAGE->get_renderer('core_calendar');
//$calendar->add_sidecalendar_blocks($renderer, true, $view);
$PAGE->navbar->add($COURSE->fullname, new moodle_url('../../course/view.php?id='.$courseid));
$PAGE->navbar->add($strwiziqs, new moodle_url('../../mod/wiziq/index.php?course='.$courseid));
$PAGE->navbar->add('Delete Class');
echo $OUTPUT->header();

//echo $renderer->start_layout();		$courseid= $_REQUEST['id'];
		
		
		
?>
<br /><br /><br />
<table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" style="float:left; margin-left:140px">
  <tr>
    <td align="center"><font face="Arial, Helvetica, sans-serif" color="#0066CC" size="5" ><strong> The Class has been deleted....</strong></font></td>
  </tr><tr></tr>
  <tr>
    <td align="center">
    <a href="event.php?course=<?php echo $courseid;?>&section=0&add=wiziq"><strong> Click to add new class </strong></a></td>
  </tr>
  <tr>
    <td align="center"> <input type="button" class="txtbox" name="Cancel" value="Go to class list" onClick="javascript:location.href='wiziq_list.php?course=<?php  echo $courseid;?>'"> </td>
  </tr>
</table>
<?php
echo $OUTPUT->footer();
?>