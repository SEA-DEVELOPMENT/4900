
<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Here Attendance report is generated about attendees in a session
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
 require_once($CFG->dirroot .'/course/lib.php');
 require_once($CFG->dirroot .'/lib/blocklib.php');
require_once($CFG->dirroot.'/calendar/lib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');
require_once($CFG->dirroot.'/calendar/event_form.php');
require_once("wiziqconf.php");
$courseid=$_REQUEST['courseid'];
$SessionCode=$_REQUEST['SessionCode'];
$course = $courseid;
    
    $urlcourse = $course;
	$cal_y = optional_param('cal_y', 0, PARAM_INT);
$cal_m = optional_param('cal_m', 0, PARAM_INT);
$cal_d = optional_param('cal_d', 0, PARAM_INT);

$url = new moodle_url('/calendar/event.php', array());
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
    //$strcalendar = get_string('calendar', 'calendar');
	$strwiziqs = get_string("modulenameplural", "wiziq");
	$strwiziq  = get_string("WiZiQ", "wiziq");
	$pagetitle="Attendance Report";
    //$prefsbutton = calendar_preferences_button();
// Print title and header


 $PAGE->set_title("$site->shortname: $strwiziqs: $pagetitle");
$PAGE->set_heading($COURSE->fullname);
//$PAGE->set_button($prefsbutton);
$PAGE->set_pagelayout('admin');
//$renderer = $PAGE->get_renderer('core_calendar');
//$calendar->add_sidecalendar_blocks($renderer, true, $view);
$PAGE->navbar->add($COURSE->fullname, new moodle_url('../../course/view.php?id='.$courseid));
$PAGE->navbar->add($strwiziqs, new moodle_url('../../mod/wiziq/index.php?course='.$courseid));
$PAGE->navbar->add('Attendance Report');
echo $OUTPUT->header();

//echo $renderer->start_layout();
// getting the info about attendess and class
function do_post_request($url, $data, $optional_headers = null)
  {
	  
$params = array('http' => array(
                  'method' => 'POST',
                  'content' => $data
               ));
     if ($optional_headers !== null) {
        $params['http']['header'] = $optional_headers;
     }
     $ctx = stream_context_create($params);
     $fp = @fopen($url, 'rb', false, $ctx);
     if (!$fp) {
        throw new Exception("Problem with $url, $php_errormsg");
     }
     $response = @stream_get_contents($fp);
     if ($response === false) {
        throw new Exception("Problem reading data from $url, $php_errormsg");
     }
	 //print_r($response);
     return $response;
  }
	$person = array(
				'CustomerKey'=>$customer_key,
				'lnSesCod'=>$SessionCode//'25161',
				   );
	 $result=do_post_request($WebServiceUrl.'moodle/class/attendancereport',http_build_query($person, '', '&'));

try
{
  $objDOM = new DOMDocument();
  $objDOM->loadXML($result); 
  //make sure path is correct
}
catch(Exception $e)
{
	echo $e->getMessage();
}

$AttendanceReport = $objDOM->getElementsByTagName("AttendanceReport");	
$SessionCode=$AttendanceReport->item(0)->getAttribute('SessionCode');
$status = $objDOM->getElementsByTagName("status");
$status = $status->item(0)->nodeValue;
if($status=="true")
{
	//--------------------for having role of user------------------
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
<table width="100%" style=" border:solid 1px #dedede"><?php if($role==1 || $role==2 || $role==3 ){ ?><tr><td colspan="2"><table width="100%"><tr><th colspan="2" class="header" style="text-align:left;"><span style="float:left; width:80px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px;font-family:Arial, Helvetica, sans-serif;"><img src="pix/icon.gif" align="absbottom"/>&nbsp;WiZiQ</span> <span style="float:left; width:120px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px "><a href="event.php?course=<?php echo $courseid;?>&section=0&add=wiziq">Schedule a Class</a></span><span style="float:left; width:120px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px "> <a href="wiziq_list.php?course=<?php echo $courseid;?>">Manage Classes</a></span><span style="float:left; width:120px;margin-left:20px; font-size:12px" > <a href="managecontent.php?course=<?php echo $courseid;?>">Manage Content</a></span></th></tr></table></td></tr><?php } ?><tr><td colspan="2">
<br/>
<p style="font-size:14px; font-weight:bold; padding:0px; margin:0px; margin-bottom:20px">Attendance Report</p>
<table cellpadding="5px" cellspacing="5px" align="center" border="1" width="100%" bordercolor="#efefef" style="border:solid 1px #efefef">
<tr style="background-color:#efefef;">
<td align="left" style="font-size:12px; font-weight:bold" class="header">Attendee Name</td>
<td align="left" style="font-size:12px; font-weight:bold" class="header">Class Entry Time</td>
<td align="left" style="font-size:12px; font-weight:bold" class="header">Class Exit Time</td>
<td align="left" style="font-size:12px; font-weight:bold" class="header">Attended Class Duration</td>
<td align="left" style="font-size:12px; font-weight:bold" class="header">Actual Class Duration (in mins)</td>
</tr>
<?php
		
$SessionMinutesConsumed = $objDOM->getElementsByTagName("SessionMinutesConsumed");
$SessionMinutesConsumed = $SessionMinutesConsumed->item(0)->nodeValue;
$Attendance = $objDOM->getElementsByTagName("Attendance");
foreach( $Attendance as $value )
  {
$ScreenName = $value->getElementsByTagName("ScreenName");
$ScreenName = $ScreenName->item(0)->nodeValue;
$IsPresenter = $value->getElementsByTagName("IsPresenter");
$IsPresenter = $IsPresenter->item(0)->nodeValue;
$StartPingTime = $value->getElementsByTagName("StartPingTime");
$StartPingTime = $StartPingTime->item(0)->nodeValue;
$EndPingTime = $value->getElementsByTagName("EndPingTime");
$EndPingTime = $EndPingTime->item(0)->nodeValue;
$AttendeeMinutesConsumed = $value->getElementsByTagName("AttendeeMinutesConsumed");
$AttendeeMinutesConsumed = $AttendeeMinutesConsumed->item(0)->nodeValue;
?>
<tr>
<td align="left" style="font-size:12px;border:solid 1px #efefef"><?php echo $ScreenName; ?></td>

<td align="left" style="font-size:12px;border:solid 1px #efefef"><?php echo $StartPingTime; ?></td>
<td align="left" style="font-size:12px;border:solid 1px #efefef"><?php echo $EndPingTime; ?></td>
<td align="left" style="font-size:12px;border:solid 1px #efefef"><?php echo $AttendeeMinutesConsumed; ?></td>
<td align="left" style="font-size:12px;border:solid 1px #efefef"><?php echo $SessionMinutesConsumed; ?></td>
</tr>	   
  <?php 
  }
?>
<tr>
    <td align="right" colspan="6"> <input type="button" class="txtbox" name="Cancel" value="Go Back to WiZiQ Classes" onClick="javascript:location.href='wiziq_list.php?course=<?php  echo $courseid;?>'"> </td>
  </tr>
</table></td></tr></table>
<?php
}
else // if error occured
{
	
?>
    <br /><br /><br />
    <p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="5"><strong><img src="pix/icon.gif" hspace="10" height="16" width="16" border="0" alt="" />Error In Attendance Report of WiZiQ Live Class</strong></font></p>
    <?php
	//echo '<strong>Message:</strong> ' .$ErrorMessage;
	$ErrorMessage="Attendance Report can not generated.";
	    
    echo '<strong><center><font color="red">'.$ErrorMessage.'</font></center></strong><br><br>';
echo'<a href="javascript:history.go(-1)"><p align="center">Click Here To Go Back</p></a>';
    
   	
}
?>

<?php
  echo $OUTPUT->footer();
?>