<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Here control returned after uploading the content.
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
require_once($CFG->dirroot.'/mod/forum/lib.php');
require_once ($CFG->dirroot.'/lib/blocklib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');
require_once("wiziqconf.php");
require_once("cryptastic.php");
$view = optional_param('view', 'upcoming', PARAM_ALPHA);
$action = optional_param('action', 'new', PARAM_ALPHA);
$id = optional_param('id', 0, PARAM_INT);
$courseid = optional_param('courseid', 0, PARAM_INT);
$instance = optional_param('instance', 0, PARAM_INT);
	
$cal_y = optional_param('cal_y', 0, PARAM_INT);
$cal_m = optional_param('cal_m', 0, PARAM_INT);
$cal_d = optional_param('cal_d', 0, PARAM_INT);

$courseid = optional_param('course', 0, PARAM_INT);
$titlecourse=urldecode($_REQUEST["t"]);
$arrayTC=explode("|",$titlecourse);
$title=$arrayTC[0];
$courseid=$arrayTC[1];
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
	$pagetitle="Upload File";
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
$PAGE->navbar->add('Upload File');
echo $OUTPUT->header();

//echo $renderer->start_layout();

echo '<p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="3"><strong><img src="pix/icon.gif" hspace="10" height="16" width="16" border="0" alt="" />We are uploading your content..... </strong></font></p>';	



if(!empty($_COOKIE['query']))
{
 $cookiequery=$_COOKIE['query'];
 parse_str(urldecode(decrypt($cookiequery)),$_request); //decrypting the encrypted url

}

 $id=$_request['id'];
 $s=$_request['s'];
 if(!empty($s))
 {
$subfolder=$_request['s'];
 $arrayfolder=explode(",",$subfolder);
 $sublevel=sizeof($arrayfolder)-1;
for($i=1;$i<sizeof($arrayfolder);$i++)
 {
	$arraystring=explode("|",$arrayfolder[$i]); 
	if($i<sizeof($arrayfolder)-1)
{
	$a=$arraystring[1];
$alink.=$a.'\\';
}
else
$alink.=$arraystring[1];

 }
 
 }
	  $title=$title;
	  if(!empty($_REQUEST['cid']))
	  $contentid=$_REQUEST['cid'];
	
	  if(empty($alink))
	  {
		$alink="Content";  
	  }
	  if(!empty($_REQUEST['file_name']))
	  $fileName=$_REQUEST['file_name'];
	  
	   $fileExtension=strtolower(substr($fileName,strrpos($fileName,".")+1));
	  if($fileExtension=="ppt" || $fileExtension=="pptx" || $fileExtension=="pps" || $fileExtension=="ppsx")
	  $image="ppt.gif";
	  else if($fileExtension=="pdf" )
	   $image="pdf.gif";
	   else if($fileExtension=="swf" || $fileExtension=="flv" )
	   $image="flash.gif";
	   else if($fileExtension=="doc" || $fileExtension=="docx" || $fileExtension=="rtf" || $fileExtension=="jnt" )
	   $image="word.gif";
	   else if($fileExtension=="mp3" || $fileExtension=="wav" || $fileExtension=="wma" )
	   $image="audio.gif";
	   else if($fileExtension=="wmv" || $fileExtension=="mov" || $fileExtension=="mpeg" || $fileExtension=="avi")
	   $image="video.gif";
	   else if($fileExtension=="xls" || $fileExtension=="xlsx")
	   $image="excel.gif";
	   else
	   $image="other.gif";
		  $wiziq->name=$fileName;
	  
	  $wiziq->title=$title;
	  //$wiziq->description=$_COOKIE['Desc'];
	  $wiziq->type="2";
	  $wiziq->uploaddatetime=time();
	  $wiziq->userid=$USER->id;	
	  $wiziq->icon=$image;
	  $wiziq->filepath=$alink;
	  $wiziq->parentid=$id;
	  $wiziq->contentid=$contentid;

	 //-------------------------inserting the record in content table------------------
	  $returnid=$DB->insert_record("wiziq_content", $wiziq,$returnid=true);	

	  if(!empty($returnid))
	  redirect("managecontent.php?q=".urlencode($cookiequery)."&course=".$urlcourse);
     
  
echo $OUTPUT->footer();
?>   	
	</body>
    </html>
