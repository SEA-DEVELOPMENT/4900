<?php 
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Index page for WiZiQ showing clsses scheduled
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");
require_once("lib.php");
include("paging.php");
require_once($CFG->dirroot."/course/lib.php");
require_once($CFG->dirroot.'/calendar/lib.php');
require_once($CFG->dirroot.'/mod/forum/lib.php');
require_once ($CFG->dirroot.'/lib/blocklib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');
   
$view = optional_param('view', 'upcoming', PARAM_ALPHA);
$action = optional_param('action', 'new', PARAM_ALPHA);
$id = optional_param('id', 0, PARAM_INT);

$instance = optional_param('instance', 0, PARAM_INT);
$courseid = optional_param('course', 0, PARAM_INT);
if(empty($courseid))
$courseid=$id;
 if (! $courseRecord = $DB->get_record("course", array("id"=>$courseid))) {
        error("Course ID is incorrect");
    }
    add_to_log($courseRecord->id, "wiziq", "view all", "index.php?id=$courseRecord->id", "");

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
	$pagetitle="WiZiQ Classes";
    //$prefsbutton = calendar_preferences_button();
// Print title and header
$PAGE->set_pagelayout('admin');

 $PAGE->set_title("$site->shortname: $strwiziqs: $pagetitle");
$PAGE->set_heading($COURSE->fullname);
//$PAGE->set_button($prefsbutton);

//$renderer = $PAGE->get_renderer('core_calendar');
//$calendar->add_sidecalendar_blocks($renderer, true, $view);
$PAGE->navbar->add($COURSE->fullname, new moodle_url('../../course/view.php?id='.$courseid));
$PAGE->navbar->add($strwiziqs, new moodle_url('../../mod/wiziq/index.php?course='.$courseid));
$PAGE->navbar->add('WiZiQ Classes');
echo $OUTPUT->header();

//echo $renderer->start_layout();
//------------------------------------for having role of user---------------------------------
$params=array($USER->id,$courseid);	
$query="select ra.roleid from {context} c,{role_assignments} ra where c.id=ra.contextid and ra.userid=? and (c.instanceid=? or c.instanceid=0 )";
$query1=$DB->get_record_sql($query, $params);
$i=0;
foreach($query1 as $rows)
{
$resultant[$i]= $rows['roleid'];
$i++;
}

sort($resultant);
$role=$resultant[0];
?>
<table width="100%" style="border:solid 1px #dedede"><?php if($role==1 || $role==2 || $role==3 ){ ?><tr><td colspan="2"><table width="100%"><tr><th colspan="2" class="header" style="text-align:left;"><span style="float:left; width:80px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px;font-family:Arial, Helvetica, sans-serif;"><img src="pix/icon.gif" align="absbottom"/>&nbsp;WiZiQ</span> <span style="float:left; width:120px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px "><a href="event.php?course=<?php echo $courseid;?>&section=0&add=wiziq">Schedule a Class</a></span><span style="float:left; width:120px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px "> <a href="wiziq_list.php?course=<?php echo $courseid;?>">Manage Classes</a></span><span style="float:left; width:120px;margin-left:20px; font-size:12px" > <a href="managecontent.php?course=<?php echo $courseid;?>">Manage Content</a></span></th></tr></table></td></tr><?php } ?>

<tr><td align="left" valign="top" colspan="2">
<?php

/// ----------------------------------Get all the appropriate data--------------------------

  $limit=10;  //setting limit of records shown per page
$todaydate=usergetdate(time());

$timestamp= make_timestamp($todaydate['year'], $todaydate['mon'], $todaydate['wday'], $todaydate['hours'], $todaydate['minutes']);
/// Print the list of instances (your module will probably extend this)
$params=array('courseid'=>$courseid);
 $query="SELECT * FROM {wiziq} where course=? order by insescod DESC" ;
$query=paging_1($query,"","0%",$id,$params);
$result=$DB->get_records_sql($query,$params);
echo '<table border="0" cellpadding="5px" cellspacing="5px" width="770px" bordercolor="#efefef" align="left" style="margin-left:2px">
<th align="left" height="30px" style="background-color:#efefef;text-align:left;" class="header">WiZiQ Classes</th>';
foreach($result as $rn)
{
 $udate=usergetdate($rn->wdate);
 $m=$udate['mon'];
 $y=$udate['year'];
 $d=$udate['mday'];
$wdate=$m."/".$d."/".$y;
echo '<tr style="border-bottom:solid 1px #efefef"><td style="font-size:12px; "><a href="view.php?instance='.$rn->id.'" class="ulink" ><strong>'.$rn->name.'</strong></a><br>'.$wdate.'-'.$rn->wtime.'  ('.$rn->timezone.')</td></tr>';
}
 echo '<tr><td>';
$str="";// printing the footer of paging
paging_2($str,"0%",$courseid);

echo '</td></tr>';   
echo '</table>';

?>
</td></tr></table>
<?php

  echo $OUTPUT->footer();

?>
