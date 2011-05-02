<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Here request send to api for deletion of content uploaded
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
require_once('wiziqconf.php');
$view = optional_param('view', 'upcoming', PARAM_ALPHA);
$action = optional_param('action', 'new', PARAM_ALPHA);
$id = optional_param('id', 0, PARAM_INT);
$courseid = optional_param('courseid', 0, PARAM_INT);
$instance = optional_param('instance', 0, PARAM_INT);

global $contentid,$folderid,$flag,$offset,$currenttotal;
$cal_y = optional_param('cal_y', 0, PARAM_INT);
$cal_m = optional_param('cal_m', 0, PARAM_INT);
$cal_d = optional_param('cal_d', 0, PARAM_INT);

$courseid = optional_param('course', 0, PARAM_INT);


  $urlcourse= $courseid;
  $url = new moodle_url('/mod/wiziq/deleteobject.php',array());
 $PAGE->set_url($url);
  if ($courseid !== 0) $url->param('course', $courseid);
if ($cal_y !== 0) $url->param('cal_y', $cal_y);
if ($cal_m !== 0) $url->param('cal_m', $cal_m);
if ($cal_d !== 0) $url->param('cal_d', $cal_d);

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
	$pagetitle="Delete Content";
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
$PAGE->navbar->add('Delete Content');
echo $OUTPUT->header();

//echo $renderer->start_layout();

if(!empty($_REQUEST['contentid']))	
$contentid=$_REQUEST['contentid'];

if(!empty($_REQUEST['folderid']))
$folderid=$_REQUEST['folderid'];

if(!empty($_REQUEST['flag']))
$flag=$_REQUEST['flag'];

if(!empty($_REQUEST['offset']))
$offset=$_REQUEST['offset'];

if(!empty($_REQUEST['currenttotal']))
$currenttotal=$_REQUEST['currenttotal'];

$q=urlencode($_REQUEST['q']);

if($_REQUEST['flag']!=1) //confirmation before deleting content
{
?><div align="center" style="margin-top:20px; margin-bottom:20px; width:550px; height:100px; margin-left:230px; background-color:#FAA; padding-top:20px; padding-left:5px; padding-right:5px; border-color:#DDD; border-width:thin; border-style:solid" ><font face="Arial, Helvetica, sans-serif" color="#020202" size="3"><strong>Are you sure you want to delete the selected content?</strong></font><br />
<div align="center"><font face="Arial, Helvetica, sans-serif" color="#0066CC" size="5"><strong><input type="submit" value="Yes" name="yes" onclick="javascript:location.href='deleteobject.php?flag=1&contentid=<?php echo $contentid; ?>&folderid=<?php echo $folderid; ?>&offset=<?php echo $offset; ?>&currenttotal=<?php echo $currenttotal; ?>&q=<?php echo $q; ?>&course=<?php echo $urlcourse; ?>&id=<?php echo $_REQUEST['id']; ?>'" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="No" name="no" onclick="javascript:history.go(-1)"/></strong></font></div>


</div>
<?php
}
if($flag==1 && !empty($folderid)) //if folder
{
$params=array('parentid'=>$folderid,'isdeleted'=>'0');	
$result=$DB->count_records('wiziq_content',$params);
if($result==0)
{
	//-------------------------- DELETE CODE for folder--------------------------------------
	
$paramUpdate=array('id'=>$folderid,'isdeleted'=>'1');	
$DB->update_record('wiziq_content', $paramUpdate, $bulk=false);
echo '<p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="3"><strong><img src="pix/icon.gif" hspace="10" height="16" width="16" border="0" alt="" />We Are Processing Your Request. Please Wait............</strong></font></p>';
redirect($CFG->wwwroot ."/mod/wiziq/managecontent.php?offset=$offset&currenttotal=$currenttotal&q=$q&course=$urlcourse");

}
else
{

?>

<table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" > <br /><br /><br />
    <p align="center" ><font face="Arial, Helvetica, sans-serif" color="#0066CC" size="5"><strong>The Folder can not be deleted. Please delete the files from the respective folder. </strong></font></p> </td>
  </tr>
  <tr>
    <td align="center"> <input type="button" class="txtbox" name="Cancel" value="Go to content list" onClick='javascript:location.href="managecontent.php?offset=<?php echo $offset; ?>&currenttotal=<?php echo $currenttotal; ?>&q=<?php echo $q; ?>&course=<?php echo $urlcourse; ?>"'> </td>
  </tr>
</table>
<?php
}
}
else if($flag==1 && !empty($contentid)) // if file
{
	try
	{
	//---------------------DELETE CODE for file------------------------
	$content = file_get_contents($contentUpload.'?method=deletecontent&key='.$customer_key.'&contentid='.$contentid);
 

	 $objDOM = new DOMDocument();
 	 $objDOM->loadXML($content); 
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}
$contentDelete= $objDOM->getElementsByTagName("rsp")->item(0);	
$isDeleted = $contentDelete->getAttributeNode('stat')->value;


if($isDeleted=="ok")
{
	//$query1="update ".$CFG->prefix."wiziq_content set isDeleted=1 where contentid=".$contentid;
	$paramUpdate=array('id'=>$_REQUEST['id'],'isdeleted'=>'1','contentid'=>$contentid);
	$DB->update_record('wiziq_content', $paramUpdate, $bulk=false);
	echo '<p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="3"><strong><img src="pix/icon.gif" hspace="10" height="16" width="16" border="0" alt="" />We Are Processing Your Request. Please Wait............</strong></font></p>';
	redirect("managecontent.php?offset=$offset&currenttotal=$currenttotal&q=$q&course=$urlcourse");
}

}
echo $OUTPUT->footer();
?>


