
<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Here request is send to api for cancellation of class
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$timestamp=strtotime(now);
	require_once("wiziqconf.php");
	//-------------------reading the users xml------------------
	$content = file_get_contents($ConfigFile."?".$timestamp);
	if ($content !== false) {
	   // do something with the content
	   //echo "file is read",$content;
	} else {
	   // an error happened
	   echo "XML file is not read";
	   exit;
	}


	//exit;
	try
	{
	  $objDOM = new DOMDocument();
	  $objDOM->loadXML($content); 
	  
	}
	catch(Exception $e)
	{
			
		echo $e->getMessage();
	}
	$UserName=$objDOM->getElementsByTagName("UserName");
	$Password=$objDOM->getElementsByTagName("Password");
	$MaxDurationPerSession = $objDOM->getElementsByTagName("MaxDurationPerSession");
	$MaxUsersPerSession = $objDOM->getElementsByTagName("MaxUsersPerSession");
	$PresenterEntryBeforeTime = $objDOM->getElementsByTagName("PresenterEntryBeforeTime");
	$PrivateChat = $objDOM->getElementsByTagName("PrivateChat");
	$RecordingCreditLimit = $objDOM->getElementsByTagName("RecordingCreditLimit");
	$ConcurrentSessions = $objDOM->getElementsByTagName("ConcurrentSessions");	
	$RecordingCreditPending=$objDOM->getElementsByTagName("RecordingCreditPending");
	$subscription_url=$objDOM->getElementsByTagName("subscription_url");
    $buynow_url=$objDOM->getElementsByTagName("buynow_url");
    $Package_info_message=$objDOM->getElementsByTagName("Package_info_message");
    $pricing_url=$objDOM->getElementsByTagName("pricing_url");
	
	
	
	$maxdur=$MaxDurationPerSession->item(0)->nodeValue;
	$maxuser=$MaxUsersPerSession->item(0)->nodeValue;
	$presenterentry=$PresenterEntryBeforeTime->item(0)->nodeValue;
	$privatechat=$PrivateChat->item(0)->nodeValue;
	$recordingcredit=$RecordingCreditLimit->item(0)->nodeValue;
	$concurrsession=$ConcurrentSessions->item(0)->nodeValue;
	$creditpending=$RecordingCreditPending->item(0)->nodeValue;
	$username=$UserName->item(0)->nodeValue;
	$password=$Password->item(0)->nodeValue;
	$subscription_url=$subscription_url->item(0)->nodeValue;
    $buynow_url=$buynow_url->item(0)->nodeValue;
    $Package_info_message=$Package_info_message->item(0)->nodeValue;
    $pricing_url=$pricing_url->item(0)->nodeValue;

require_once("../../config.php");
require_once("lib.php");
require_once($CFG->dirroot."/course/lib.php");
require_once($CFG->dirroot.'/calendar/lib.php');
require_once($CFG->dirroot.'/mod/forum/lib.php');
require_once ($CFG->dirroot.'/lib/blocklib.php');
require_once('wiziqconf.php');
 $view = optional_param('view', 'upcoming', PARAM_ALPHA);
$action = optional_param('action', 'new', PARAM_ALPHA);
$id = optional_param('id', 0, PARAM_INT);
$courseid = optional_param('courseid', 0, PARAM_INT);
$instance = optional_param('instance', 0, PARAM_INT);
	
$cal_y = optional_param('cal_y', 0, PARAM_INT);
$cal_m = optional_param('cal_m', 0, PARAM_INT);
$cal_d = optional_param('cal_d', 0, PARAM_INT);

$courseid = optional_param('course', 0, PARAM_INT);


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

//echo $renderer->start_layout();


$aid=$_REQUEST['aid'];
$insid=$_REQUEST['insid'];
$eid=$_REQUEST['eid'];
$courseid=$_REQUEST['id'];
$type=$_REQUEST['type'];
$sessionkey=$USER->sesskey;


$param=array('id'=>$aid);
$q="select *  from {wiziq} where id=:id";
$r=$DB->get_record_sql($q,$param);

 $pinsescod=$r->insescod;
 $peventname=$r->name;
 $purl=$r->url;
 $pattendeeurl=$r->attendeeurl;
 $precordingurl=$r->recordingurl;
 $previewurl=$r->reviewurl;
 $times=$r->wdate;
 $wtime=$r->wtime;
 
if($_REQUEST['flag']!=1) //first time post to delete the content
{
include_once("confirm_delete.php");
}
$wdate=calendar_day_representation($times, $now = false, $usecommonwords = true);
//$wtime=calendar_time_representation($times);
//$date=date('d-m-Y', $date);
$date=str_replace("-","/",$wdate);
$dattime= $date." ".$wtime;
$dattime=strtoupper($dattime);
$courseid=$_REQUEST['courseid'];
if($_REQUEST['flag']==1) //second time post after confirmation
{
	// sending request to api to delete class
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
				'lnSesCod' => $pinsescod
	        	 );	

 $result=do_post_request($WebServiceUrl.'moodle/class/delete',http_build_query($person, '', '&'));
try
	  {
	    $objDOM = new DOMDocument();
	    $objDOM->loadXML($result); 
	  }
	catch(Exception $e)
	  {
		echo $e->getMessage();
	  }
   
 	
	 $Deleted=$objDOM->getElementsByTagName("Status");
	 $Deleted=$Deleted->item(0)->nodeValue;
	 $message=$objDOM->getElementsByTagName("message");
	 $message=$message->item(0)->nodeValue;


if($Deleted=="true")
{

}

if( $type=='0' && $Deleted=="True") // if deleted
{
	$DB->delete_records('wiziq', array('id'=>$aid));

	$DB->delete_records('event', array('id'=>$eid));
	
	$DB->delete_records('course_modules', array('id'=>$insid));
echo '<p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="3"><strong><img src="pix/icon.gif" hspace="10" height="16" width="16" border="0" alt="" />We Are Processing Your Request. Please Wait............</strong></font></p>';
	redirect("welcome_delete.php?id=".$courseid);
	
}
else //if error occured
{

				
?>

<table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" style="float:left; margin-left:140px">
  <tr>
    <td align="center" > <br /><br /><br />
    <p align="center" ><font face="Arial, Helvetica, sans-serif" color="#0066CC" size="5"><strong>The Class can not be deleted....</strong></font></p> </td>
  </tr>
  <tr>
  <td align="center"><?php echo '<strong>Message:</strong> ' .$message?></td>
  </tr>
  <tr>
    <td align="center"> <input type="button" class="txtbox" name="Cancel" value="Go to class list" onClick="javascript:location.href='wiziq_list.php?course=<?php echo $courseid;?>'"> </td>
  </tr>
</table>
<?php
}
}
echo $OUTPUT->footer();
?>








