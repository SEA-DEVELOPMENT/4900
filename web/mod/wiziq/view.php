
<?php

/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Here class details view is created
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 if(!empty($_REQUEST['str']))
 $str=$_REQUEST['str'];
 else
 $str="";
 if(!empty($_REQUEST['date']))
$date=$_REQUEST['date'];

	require_once("../../config.php");
    	require_once("lib.php");
      	require_once($CFG->dirroot.'/course/lib.php');
    	require_once($CFG->dirroot.'/calendar/lib.php');
		require_once($CFG->dirroot.'/calendar/event_form.php');
		require_once("wiziqconf.php");
		require_once("RoleView.php");
		//require_once($CFG->dirroot.'/lib/outputrenderers.php');
 //------------------------- reading the xml file of user---------------------
	
		$content = file_get_contents($ConfigFile);
	if ($content !== false) {
	   // do something with the content
	 // echo "file is read",$content;
	} else {
	   // an error happened
	   echo "XML file is not read";
	   exit;
	}

	try
	{
	  $objDOM = new DOMDocument();
	  $objDOM->loadXML($content); 
	  
	}
	catch(Exception $e)
	{
			
		echo $e->getMessage();
	}
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
	$prsenterentry=$PresenterEntryBeforeTime->item(0)->nodeValue;
	$privatechat=$PrivateChat->item(0)->nodeValue;
	$recordingcredit=$RecordingCreditLimit->item(0)->nodeValue;
	$concurrsession=$ConcurrentSessions->item(0)->nodeValue;
	$creditpending=$RecordingCreditPending->item(0)->nodeValue;
	$subscription_url=$subscription_url->item(0)->nodeValue;
    $buynow_url=$buynow_url->item(0)->nodeValue;
    $Package_info_message=$Package_info_message->item(0)->nodeValue;
    $pricing_url=$pricing_url->item(0)->nodeValue;
//-----------------------------------------------------------------------
$view = optional_param('view', 'upcoming', PARAM_ALPHA);

$action = optional_param('action', 'new', PARAM_ALPHA);
$id = optional_param('id', 0, PARAM_INT);
$courseid = optional_param('courseid', 0, PARAM_INT);
$instance = optional_param('instance', 0, PARAM_INT);

$cal_y = optional_param('cal_y', 0, PARAM_INT);
$cal_m = optional_param('cal_m', 0, PARAM_INT);
$cal_d = optional_param('cal_d', 0, PARAM_INT);

if ($courseid === 0) {
    $courseid = optional_param('course', 0, PARAM_INT);
}
if($instance!=0)
	{
		$modquery="SELECT id FROM {modules} where name='wiziq'";
		$modresult=$DB->get_record_sql($modquery);
		$moduleid=$modresult->id;
		$params=array('module'=>$moduleid,'id'=>$instance);
   	    $query="select id from {course_modules} where module=:module and instance=:id";
	    $r=$DB->get_record_sql($query,$params);
	    $id=$r->id;
		
	}
		
	if ($id) {
				if (! $cm = $DB->get_record("course_modules", array("id"=>$id))) {
					error("Course Module ID was incorrect");
				}
			
				if (! $course = $DB->get_record("course", array("id"=>$cm->course))) {
					error("Course is misconfigured");
				}
			
				if (! $wiziq = $DB->get_record("wiziq", array("id"=>$cm->instance))) {
					error("Course module is incorrect");
				}

    } else {
				if (! $wiziq = $DB->get_record("wiziq", array("id"=>$instance))) {
					print_error("Course module is incorrect");
				}
				if (! $course = $DB->get_record("course", array("id"=>$wiziq->course))) {
					print_error("Course is misconfigured");
				}
	}
		if($courseid==0)
  $courseid= $wiziq->course;
$url = new moodle_url('/calendar/event.php', array('instance'=>$instance));
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

    require_login($wiziq->course,false);
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
	$pagetitle="Class View";
    //$prefsbutton = calendar_preferences_button();
// Print title and header


 $PAGE->set_title("$site->shortname: $strwiziqs: $pagetitle");
$PAGE->set_heading($COURSE->fullname);
//$PAGE->set_button($prefsbutton);
$PAGE->set_pagelayout('admin');
$renderer = $PAGE->get_renderer('core_calendar');
//$calendar->add_sidecalendar_blocks($renderer, true, $view);
$PAGE->navbar->add($COURSE->fullname, new moodle_url('../../course/view.php?id='.$wiziq->course));
$PAGE->navbar->add($strwiziqs, new moodle_url('../../mod/wiziq/index.php?course='.$wiziq->course));
$PAGE->navbar->add($wiziq->name, new moodle_url('../../mod/wiziq/view.php?instance='.$wiziq->id));
echo $OUTPUT->header();

echo $renderer->start_layout();

echo'<style type="text/css">
.m_12b585858{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
text-decoration:none;
font-weight:bold;
color:#585858;
padding-right:10px;
}
.button{
       font-family:Arial;
	   font-size:11px;
	   color:#333333;
	   background-color:#999999;
	   font-weight:bold;
	   border:#FFFFFF 1px solid;
	   cursor:pointer;
	   height:40px;
}
.perror{
    border:1px solid #FF0000; 
	font-family:Arial, Helvetica, sans-serif;
	
	font-weight:normal; 
	color:#FF0000;
}
.error{
      border:#FF0000 1px; 
	font-family:Arial, Helvetica, sans-serif;
	
	font-weight:normal;
	color:#FF0000;
}
.ulink{text-decoration:underline; font-weight:bold; font-size:12px}
.ulink:hover{text-decoration:none;font-weight:bold;font-size:12px}
.dv100{width:100%; float:left; margin-bottom:0px}
.dur_txt{ border-right:solid 1px #ddd;float:left; width:100px;padding-right:35px;font-size:12px }
.type_txt{float:left; width:100px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px }
.rec_txt{float:left; width:200px;margin-left:20px;font-size:12px   }
.b_txt{font-weight:bold;}
.formdv{float:left; margin-top:40px; width:530px; padding-bottom:20px; font-size:12px}
.form_left{width:90px; float:left; font-weight:bold;margin-top:7px }
.form_right{width:430px; float:right; color:#666666}
.m_textinput{
font-family:Arial, Helvetica, sans-serif;
font-size:13px;
text-decoration: none;
font-weight:normal;
color:#666666;
border-style:solid;
border-width:1px;
border-color:#CCCCCC;
width:270px;
padding:5px;
}
.uploadingdiv{border:solid 10px #ccc; background-color:#fff; padding:10px;}

</style>
<script type="text/javascript">window.onerror = handleError; function handleError(){return true;}</script>
<script type="text/javascript" language="javascript" src="http://org.wiziq.com/Common/JS/ModalPopup.js"></script>
<script language="javascript" src="http://org.wiziq.com/Common/JS/jquery.js" type="text/javascript"></script>

 <link href="http://org.wiziq.com/Common/CSS/ModalPopup.css" rel="stylesheet" type="text/css" />
  <link href="http://org.wiziq.com/Common/CSS/thickbox.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" language="javascript">
function PopUp(code)
{ 
	document.getElementById("divmodal").style.display="block";
	document.getElementById("divmodal").style.visibility="visible";
	document.getElementById("ifrmDownload").src = "downloadrec.php?SessionCode="+code+"&amp;keepThis=true&TB_iframe=true&height=250&width=400";
PopupShow("divmodal","modalBackground"); 
return true;
}
function openDetails(Url)
    {   
	
        var scheight=screen.height;
        var scwidth=screen.width;
        var w=window.open(Url, null, "left=0,top=0,resize=0, height="+scheight+", width="+scwidth);
		w.opener=window;
		w.focus();
		return false;
    } 
function setValue(value)
{
//alert(value);	
if(value=="Enter Class")
{
//document.view.action="add_attende.php?eventid=3&id=3&SessionCode=";	
//alert();
var sess=document.getElementById("SessionCode").value;


window.open("add_attende.php?SessionCode="+sess);
return false;
}
return false;

}
    </script>';
echo '<div id="divmodal"  class="modalWindow" style="display: none; width: 500px;">
    <div id="dvMod1" class="uploadingdiv" style="height:200px">
       <div id="close1" style="float:right;"><a id="A1" href="javascript:PopupClose();" >Close</a></div>
          <iframe id="ifrmDownload" width="470px" height="190px" frameborder="0" scrolling="no" style="font-family:Arial; font-size:12px; color:#444" ></iframe>          
                            
    </div>           
 </div>
<img id="modalBackground" class="modalBackground" width="100%" style="display: none; z-index: 3; left: -6px; top: 120px; height: 94%;" alt="" />';

$usr = $USER->username;
$email = $USER->email;
$times=$wiziq->wdate;
$timezone=$wiziq->timezone;
 $wtime=calendar_time_representation($times);
 
$udate=usergetdate($times);
//print_r($udate);
 $m=$udate['mon'];
 $y=$udate['year'];
 $d=$udate['mday'];
$wdate=$m."/".$d."/".$y;
//make_timestamp($year, $month, $day, $hh1, $mm1);
$timecheck=0;
$todaydate=usergetdate(time());

if($udate['year'] < $todaydate['year'])
{

 $timecheck=1; 

}
else if($udate['year'] == $todaydate['year'])
{
 if( $udate['yday'] < $todaydate['yday']) 
 {
	// echo $udate['yday'];
  $timecheck=1; 
 }
 else if( $udate['mon'] < $todaydate['mon'] && $udate['yday'] <= $todaydate['yday'])
 {
	// echo $udate['mon'];
  $timecheck=1;
 }
 else if($udate['hours'] < $todaydate['hours'] && $udate['mon'] <= $todaydate['mon'] && $udate['yday'] <= $todaydate['yday'])
 {
	 //echo $udate['hours'];
  $timecheck=1; 
 }
 else if( $udate['minutes'] < $todaydate['minutes'] && $udate['hours'] <= $todaydate['hours'] && $udate['mon'] <= $todaydate['mon'] && $udate['yday'] <= $todaydate['yday'])
 {
	// echo $udate['minutes']."gfg".$todaydate['minutes'];
  $timecheck=1; 
 }
}
 
$ptani=dst_offset_on($times, $USER->timezone) ;
// checking the timezone of user
if ($CFG->forcetimezone != 99)
 {
     $tmzone=$CFG->forcetimezone;
	 
 } 
 else
 $tmzone=$USER->timezone; 
if(!is_numeric($tmzone))
{
	if ($CFG->forcetimezone != 99)
 	{
 		$timezone=$CFG->forcetimezone;
 	}
	else
	$timezone=$USER->timezone;
	 $tmzone=get_user_timezone_offset($tmzone);
}
else
{
switch($tmzone)
{
	
case("-13.0"):
{
$timezone="GMT-13:00";
break;
}

case("-12.5"):
{
$timezone="GMT-12:30";
break;
}
case("-12.0"):
{
$timezone="GMT-12:00";
break;
}

case("-11.5"):
{
$timezone="GMT-11:30";
break;
}

case("-11.0"):
{
$timezone="GMT-11:00";
break;
}
case("-10.5"):
{
$timezone="GMT-10:30";

break;
}
case("-10.0"):
{
$timezone="GMT-10:00";
break;
}

case("-9.5"):
{
$timezone="GMT-09:30";
break;
}

case("-9.0"):
{
$timezone="GMT-09:00";
break;
}

case("-8.5"):
{
$timezone="GMT-08:30";
break;
}

case("-8.0"):
{
$timezone="GMT-08:00";
break;
}
case("-7.5"):
{
$timezone="GMT-07:30";
break;
}

case("-7.0"):
{
$timezone="GMT-07:00";
break;
}

case("-6.5"):
{
$timezone="GMT-06:30";
break;
}
case("-6.0"):
{
$timezone="GMT-06:00";
break;
}
case("-5.5"):
{
$timezone="GMT-05:30";
break;
}
case("-5.0"):
{
$timezone="GMT-05:00";
break;
}
case("-4.5"):
{
$timezone="GMT-04:30";
break;
}
case("-4.0"):
{
$timezone="GMT-04:00";
break;
}
case("-3.5"):
{
$timezone="GMT-03:30";
break;
}
case("-3.0"):
{
$timezone="GMT-03:00";
break;
}
case("-2.5"):
{
$timezone="GMT-02:30";
break;
}
case("-2.0"):
{
$timezone="GMT-02:00";
break;
}
case("-1.5"):
{
$timezone="GMT-01:30";
break;
}
case("-1.0"):
{
$timezone="GMT-01:00";
break;
}
case("-0.5"):
{
$timezone="GMT-00:30";
break;
}
case("0.0"):
{
$timezone="GMT";
break;
}
case("0.5"):
{
$timezone="GMT+00:30";
break;
}
case("1.0"):
{
$timezone="GMT+01:00";
break;
}
case("1.5"):
{
$timezone="GMT+01:30";
break;
}
case("2.0"):
{
$timezone="GMT+02:00";
break;
}
case("2.5"):
{
$timezone="GMT+02:30";

break;
}
case("3.0"):
{
$timezone="GMT+03:00";
break;
}
case("3.5"):
{
$timezone="GMT+03:30";
break;
}
case("4.0"):
{
$timezone="GMT+04:00";
break;
}
case("4.5"):
{
$timezone="GMT+04:30";
break;
}
case("5.0"):
{
$timezone="GMT+05:00";
break;
}
case("5.5"):
{
$timezone="GMT+05:30";
break;
}
case("6.0"):
{
$timezone="GMT+06:00";
break;
}
case("6.5"):
{
$timezone="GMT+06:30";
break;
}
case("7.0"):
{
$timezone="GMT+07:00";
break;
}
case("7.5"):
{
$timezone="GMT+07:30";

break;
}
case("8.0"):
{
$timezone="GMT+08:00";

break;
}
case("8.5"):
{
$timezone="GMT+08:30";

break;
}
case("9.0"):
{
$timezone="GMT+09:00";

break;
}
case("9.5"):
{
$timezone="GMT+09:30";

break;
}
case("10.0"):
{
$timezone="GMT+10:00";

break;
}
case("10.5"):
{
$timezone="GMT+10:30";

break;
}
case("11.0"):
{
$timezone="GMT+11:00";

break;
}
case("11.5"):
{
$timezone="GMT+11:30";

break;
}
case("12.0"):
{
$timezone="GMT+12:00";

break;
}
case("12.5"):
{
$timezone="GMT+12:30";

break;
}
case("13.0"):
{
$timezone="GMT+13:00";

break;
}
default:
  {
$timezone="GMT-06:00";

  }
}
}

	$f=$wiziq->statusrecording;
	if($f==1)
	{
		$status="Yes";
	}
	if($f==0)
	{
		$status="No";
	}
	
// $query="select * from ".$CFG->prefix."role_assignments where userid =".$USER->id;	
//------------------Finding the roleid of user in current course-------------------------   

if($USER->id==2)
{
$role=1;	
}
else
{
$params=array($USER->id,$wiziq->course);	
$query="select ra.roleid from {context} c,{role_assignments} ra where c.id=ra.contextid and ra.userid=? and (c.instanceid=? or c.instanceid=0 )";
$query1=$DB->get_records_sql($query, $params);
$i=0;
foreach($query1 as $rows)
{
$resultant[$i]= $rows->roleid;
$i++;
}
//s$query1->close();
sort($resultant);
$role=$resultant[0];
}

$insescod=$wiziq->insescod;
$eventid=$wiziq->id;

$params = array('instance' => $wiziq->id, 'name' => '%mod/wiziq/pix/icon.gif%'); //getting records from event table
$qry="select eventtype,userid from {event} where instance=:instance and name like :name"; 
$rs = $DB->get_record_sql($qry, $params);
$eventtype=$rs->eventtype;
$eventuserid=$rs->userid;
if($eventtype=="user")
$_eventType="User Event";

else if($eventtype=="site")
$_eventType="Site Event";

else if($eventtype=="course")
$_eventType="Course Event";

else if($eventtype=="group")
$_eventType="Group Event";


$f=$wiziq->statusrecording;
if($USER->id==1)
{
	
$role='6';
}
$enterflag=1;
echo '<table width="100%">'; if($role==1 || $role==2 || $role==3 ){ echo'<tr><td ><table width="100%"><tr><th class="header" style="text-align:left;"><span style="float:left; width:80px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px;font-family:Arial, Helvetica, sans-serif;"><img src="pix/icon.gif" align="absbottom"/>&nbsp;WiZiQ</span> <span style="float:left; width:120px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px "><a href="event.php?course='.$courseid.'&section=0&add=wiziq">Schedule a Class</a></span><span style="float:left; width:120px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px "> <a href="wiziq_list.php?course='.$courseid.'">Manage Classes</a></span><span style="float:left; width:120px;margin-left:20px; font-size:12px" > <a href="managecontent.php?course='.$courseid.
'">Manage Content</a></span></th></tr></table></td></tr>'; }
echo '<tr><td align="left">';
//----------------initialising the class variables for classview depend on different roles---------
$classRoleView=new ClassView_Role();
$classRoleView->_className=$wiziq->name;
$classRoleView->_classType=$_eventType;
$classRoleView->_classDate=$wdate;
$classRoleView->_classTime=$wtime;
$classRoleView->_classTimeZone=$timezone;
$classRoleView->_classDuration=$wiziq->wdur;
$classRoleView->_classAudioVideo=$wiziq->wtype;
$classRoleView->_classStatus=$status;
$classRoleView->_classPresenterLink=$wiziq->url;
$classRoleView->_classAttendeeLink=$wiziq->attendeeurl;
$classRoleView->_classRecordingLink=$wiziq->recordingurl;
$classRoleView->_eventUserID=$eventuserid;
$classRoleView->_roleID=$role;
$classRoleView->_udate=$udate;
$classRoleView->_todayDate=$todaydate;
$classRoleView->_timeCheck=$timecheck;
$classRoleView->_sessionCode=$insescod;
$classRoleView->_eventID=$eventid;
$classRoleView->_ID=$id;
$classRoleView->_courseID=$wiziq->course;
$classRoleView->_userID=$USER->id;
$classRoleView->_downloadrec=$wiziq->downloadrec;
$classRoleView->_viewrec=$wiziq->viewrec;
$classRoleView->_attendancerep=$wiziq->attendancerep;
$classRoleView->_classDone=$wiziq->classstatus;
if(($wiziq->oldclasses)!=1)// check for old classes
{
if($eventtype=='site')
{

switch($role)
{
case('6'):// Role 6 is for guest
{
$classRoleView->StudentRole();
break;
}

case('4'): // non-editing teacher
{
$classRoleView->StudentRole();
break;
}

case('5'):// Role 5 is for student
{
$classRoleView->StudentRole();
break;	
}

case('2'):// Role 2 is fcourse creator
{
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
break;
}
case('3'): // Role 5 is for Teacher
{
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
break;
}
case('1'):
{
$classRoleView->AdminRole();
$classRoleView->iFrameLoad();
break;
}
}
}
else if($eventtype=='course')
{
switch($role)
{
case('6'):// Role 6 is for guest
{
$classRoleView->StudentRole();
break;
}

case('4'): // non-editing teacher
{
$classRoleView->StudentRole();		
break;
}

case('5'):// Role 5 is for student
{
$classRoleView->StudentRole();
break;	
}

 case('2'):// Role 2 is fcourse creator
{
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
break;

}
case('3'): // Role 5 is for Teacher
{
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
break;
}
case('1'):
{
$classRoleView->AdminRole();
$classRoleView->iFrameLoad();
break;
}
}
}
else if($eventtype=='group')
{
$grpary[]=array();
$grpflag=1;
$params=array('instance'=>$wiziq->id);
$grpquery="select groupid,userid from {groups_members} where groupid in(select groupid from {event} where instance=:instance)";
$groupsrs=$DB->get_records_sql($grpquery,$params);
$i=1;
foreach($groupsrs as $grpresult )
{
	$grpary[$i]=$grpresult->userid;
	$i++;
}

	  foreach($grpary as $grpuserid)
		  {
		
if(($grpuserid==$USER->id || $USER->id==2 || $eventuserid==$USER->id )&& $grpflag==1 )
{
	$grpflag=0;
	switch($role)
{
case('6'):// Role 6 is for guest
{
$classRoleView->StudentRole();
break;
}

case('4'): // non-editing teacher
{
$classRoleView->StudentRole();
break;
}

case('5'):// Role 5 is for student
{
$classRoleView->StudentRole();
break;	
}

 case('2'):// Role 2 is fcourse creator
{
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
break;

}
case('3'): // Role 5 is for Teacher
{
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
break;
}
case('1'):
{
$classRoleView->AdminRole();
$classRoleView->iFrameLoad();
break;
}
}
}
 
}
if($grpflag==1 )
{
?>
<div><strong><center><font color="red"><p>You are not authorized to view this class.</p></font></center></strong><br><br>
<a href="javascript:history.go(-1)"><p align="center">Click Here To Go Back</p></a></div>
<?php	
}
}
else if($eventtype=='user')
{

if($USER->id==$eventuserid || $USER->id==2)
{
switch($role)
{
case('6'):// Role 6 is for guest
{
$classRoleView->StudentRole();
break;
}

case('4'): // Role 4 non-editing teacher
{
$classRoleView->StudentRole();
break;
}

case('5'):// Role 5 is for student
{
$classRoleView->StudentRole();
break;	
}

 case('2'):// Role 2 is for course creator
{
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
break;

}
case('3'): // Role 5 is for Teacher
{
$classRoleView->TeacherRole();
$classRoleView->iFrameLoad();
break;
}
case('1'):
{
$classRoleView->AdminRole();
$classRoleView->iFrameLoad();
break;
}
}
}
else
{
?>
<br /><br />
<div><strong><center><font color="red"><p>You are not authorized to view this class.</p></font></center></strong>
<a href="javascript:history.go(-1)"><p align="center">Click Here To Go Back</p></a></div>
<?php	
}
}
}
else if(($wiziq->oldclasses)==1)
{
if($role=='6')// Role 6 is for guest
{
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">    
  <form name="view" >
  <tr >
    <td><table width="100%" border="0" cellspacing="5" cellpadding="6">
	
      <tr>
        <td  colspan="2" align="center" valign="top" class="contact_bold" ><h2 style="width:250px; float:left; margin-left:20px">Class scheduled</h2></td>
        </tr>
     
      <tr>
         <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Title</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->name.'</td>
        </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Date</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wdate.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Time</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wtime.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Duration</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wdur.'&nbsp;&nbsp;minutes</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Type</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wtype.'</td>
              </tr>';
            if($f==1)
			{
		   echo '<tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Recording URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->recordingurl.' "  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>';
			}
			echo '<tr>
                <td colspan="2" align="center" valign="top" ><a href="javascript:void(0);" 
			 onclick="return openDetails(\''.$wiziq->attendeeurl.'\');">Click here to enter class</a></td>
              </tr>      
    </table></td>
  </tr>
                
  </form>
</table>';
}

if($role=='2') // course creator
{
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="view"  action="checkupdate.php">
  <tr >
    <td><table width="100%" border="0" cellspacing="5" cellpadding="6">
	<tr>
			<td colspan="2" align="center" valign="top" class="contact_bold"><h2 style="width:300px; float:left; margin-left:20px">'.$str.'</h2></td>
	</tr>
      <tr>
       <td  colspan="2" align="center" valign="top" class="contact_bold" ><h2 style="width:250px; float:left; margin-left:20px">Class scheduled</h2></td>
        </tr>
     
      <tr>
         <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Title</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->name.'</td>
        </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Date</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wdate.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Time</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wtime.'</td>
              </tr>
			  
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Duration</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wdur.' &nbsp;&nbsp;minutes</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Type</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wtype.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Record this class</strong>:</td>
			<td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">';
			if($creditpending>0)
			{
		
				echo '<input id="rdtypeyes" name="chkRecording" type="radio" value="yes" />Yes
					  <input id="rdtypeno" name="chkRecording" type="radio" value="no" />No';
			}
			else if($creditpending==0)
			{
				echo '<input id="rdtypeyes" name="chkRecording" type="radio"  disabled="disabled"/>Yes
				<input id="rdtypeno" name="chkRecording" type="radio"  disabled="disabled"/>No';	
			}
			 echo '</td>
              </tr>
			  		  
			   <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Attendee URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->attendeeurl.' "  size="35px"/></td>
              </tr>';
			  if(strtolower($status)=="yes")
			  {
			  echo '<tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Recording URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->recordingurl.' "  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>';
			  }
			  
               echo ' 
      <td colspan="2" align="center" valign="top" class="contact_bold"><a href="javascript:void(0);" 
			 onclick="return openDetails(\''.$wiziq->url.'\');">Click here to enter class</a></td>
      </tr>';
  if($creditpending>0)
			{
echo  '<tr><td colspan="2" align="center" valign="top" ><input type="submit" name="update" value="Update Class" id="name"/><input type="hidden" value="'.$eventid.'" name="eventid"/><input type="hidden" id="old" name="old" value="oldclass"/></td>
      </tr>';
			}
			
	  echo '
      
    </table></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>
	   <script language="javascript" type="text/javascript">
		var chk = "'.strtolower($status).'";
		if(chk == "no")
		{
			document.getElementById("rdtypeno").checked = "true";
		}
		else
		{  	
				document.getElementById("rdtypeyes").checked = "true";
		}
		</script>;
	 
	  </td></tr>
  </form>
</table>';
?>

<div style="width:550px; float:left; margin-left:20px">
   <iframe  src="package_message.php" id="remote_iframe_1" name="remote_iframe_1" style="border:0;padding:0;margin:0;width:80%;height:100px;overflow:auto" frameborder=0 scrolling="no" onload=" " ></iframe>
                         </div>
                         <?php
}


if($role=='5')// Role 5 is for student
{
	
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">    
  <form name="view" >
  <tr >
    <td><table width="100%" border="0" cellspacing="5" cellpadding="6">
	
      <tr>
       <td  colspan="2" align="center" valign="top" class="contact_bold" ><h2 style="width:250px; float:left; margin-left:20px">Class scheduled</h2></td>
        </tr>
     
      <tr>
         <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Title</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->name.'</td>
        </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Date</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wdate.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Time</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wtime.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Duration</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wdur.'&nbsp;&nbsp;minutes</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Type</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wtype.'</td>
              </tr>';
            if($f==1)
			{
		   echo '<tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Recording URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->recordingurl.' "  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>';
			}
			echo '<tr>
                <td colspan="2" align="center" valign="top" ><a href="javascript:void(0);" 
			 onclick="return openDetails(\''.$wiziq->attendeeurl.'\');">Click here to enter class</a></td>
              </tr>      
    </table></td>
  </tr>
                
  </form>
</table>';
}


if($role=='3') // Role 3 is for Teacher
{
	
    echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="view"  action="checkupdate.php">
  <tr >
    <td><table width="100%" border="0" cellspacing="5" cellpadding="6">
	<tr>
			<td colspan="2" align="center" valign="top" class="contact_bold"><h2 style="width:300px; float:left; margin-left:20px">'.$str.'</h2></td>
	</tr>
      <tr>
        <td  colspan="2" align="center" valign="top" class="contact_bold" ><h2 style="width:250px; float:left; margin-left:20px">Class scheduled</h2></td>
        </tr>
     
      <tr>
         <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Title</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->name.'</td>
        </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Date</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wdate.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Time</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wtime.'</td>
              </tr>
			  
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Duration</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wdur.' &nbsp;&nbsp;minutes</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Type</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wtype.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Record this class</strong>:</td>
			<td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">';
			if($creditpending>0)
			{
		
				echo '<input id="rdtypeyes" name="chkRecording" type="radio" value="yes" />Yes
					  <input id="rdtypeno" name="chkRecording" type="radio" value="no" />No';
			}
			else if($creditpending==0)
			{
				echo '<input id="rdtypeyes" name="chkRecording" type="radio"  disabled="disabled"/>Yes
				<input id="rdtypeno" name="chkRecording" type="radio"  disabled="disabled"/>No';	
			}
			 echo '</td>
              </tr>
			  		  
			   <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Attendee URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->attendeeurl.' "  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>';
			  if(strtolower($status)=="yes")
			  {
			  echo '<tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Recording URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->recordingurl.' "  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>';
			  }
			  
               echo ' 
      <td colspan="2" align="center" valign="top" class="contact_bold"><a href="javascript:void(0);" 
			 onclick="return openDetails(\''.$wiziq->url.'\');">Click here to enter class</a></td>
      </tr>';
  if($creditpending>0)
			{
echo  '<tr><td colspan="2" align="center" valign="top" ><input type="submit" name="update" value="Update Class" id="name"/><input type="hidden" value="'.$eventid.'" name="eventid"/><input type="hidden" id="old" name="old" value="oldclass"/></td>
      </tr>';
			}
			
	  echo '
      
    </table></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>
	   <script language="javascript" type="text/javascript">
		var chk = "'.strtolower($status).'";
		if(chk == "no")
		{
			document.getElementById("rdtypeno").checked = "true";
		}
		else
		{  	
				document.getElementById("rdtypeyes").checked = "true";
		}
		</script>;
	 
	  </td></tr>
  </form>
</table>';
?>
<div style="width:550px; float:left; margin-left:20px">
   <iframe  src="package_message.php" id="remote_iframe_1" name="remote_iframe_1" style="border:0;padding:0;margin:0;width:80%;height:100px;overflow:auto" frameborder=0 scrolling="no" onload=" " ></iframe>
                         </div>
                         <?php

}

if($role=='4') // non-editing teacher
{
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">    
  <form name="view" >
  <tr >
    <td><table width="100%" border="0" cellspacing="5" cellpadding="6">
	
      <tr>
        <td  colspan="2" align="center" valign="top" class="contact_bold" ><h2 style="width:250px; float:left; margin-left:20px">Class scheduled</h2></td>
        </tr>
     
      <tr>
         <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Title</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->name.'</td>
        </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Date</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wdate.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Time</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wtime.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Duration</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wdur.'&nbsp;&nbsp;minutes</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Type</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wtype.'</td>
              </tr>';
            if($f==1)
			{
		   echo '<tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Recording URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->recordingurl.' "  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>';
			}
			echo '<tr>
                <td colspan="2" align="center" valign="top" ><a href="javascript:void(0);" 
			 onclick="return openDetails(\''.$wiziq->attendeeurl.'\');">Click here to enter class</a></td>
              </tr>      
    </table></td>
  </tr>
                
  </form>
</table>';	
}

if($role=='1')
{
	
	 echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="view"  action="checkupdate.php">
  <tr >
    <td><table width="100%" border="0" cellspacing="5" cellpadding="6">
	<tr>
			<td colspan="2" align="center" valign="top" class="contact_bold"><h2 style="width:300px; float:left; margin-left:20px">'.$str.'</h2></td>
	</tr>
      <tr>
        <td  colspan="2" align="center" valign="top" class="contact_bold" ><h2 style="width:250px; float:left; margin-left:20px">Class scheduled</h2></td>
        </tr>
     
      <tr>
         <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Title</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->name.'</td>
        </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Date</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wdate.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Time</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wtime.'</td>
              </tr>
			  
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Duration</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wdur.' &nbsp;&nbsp;minutes</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Type</strong>:</td>
        <td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">'.$wiziq->wtype.'</td>
              </tr>
              <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Record this class</strong>:</td>
			<td width="68%" colspan="2" align="left" valign="top" class="m_12b585858">';
			if($creditpending>0)
			{
		
				echo '<input id="rdtypeyes" name="chkRecording" type="radio" value="yes" />Yes
				<input id="rdtypeno" name="chkRecording" type="radio" value="no" />No';
			}
			else if($creditpending==0)
			{
				echo '<input id="rdtypeyes" name="chkRecording" type="radio"  disabled="disabled"/>Yes
				<input id="rdtypeno" name="chkRecording" type="radio"  disabled="disabled"/>No';	
			}
			 echo '</td>
              </tr>
             <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Presenter Link</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value="'.$wiziq->url.'"  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>
			  
			    <tr>
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Attendee URL</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value=" '.$wiziq->attendeeurl.' "  size="35px" class="m_textinput" readonly="true"/></td>
              </tr>';
			  if(strtolower($status)=="yes")
			  {
			  echo '<tr>
			   
                <td width="32%" align="right" valign="top" class="m_12b585858"><strong>Recording Link</strong>:</td>
                <td colspan="2" align="left" valign="top" ><input type="text" onclick="this.select()" value="'.$wiziq->recordingurl.' "  size="35px" class="m_textinput" readonly="true"/></td>
              
			  </tr>';
			  }
			  
               echo '<tr>
        <td colspan="3" align="left" valign="top" ></td>
        </tr>
           <tr>
             <td colspan="2" align="center" valign="top" class="contact_bold"><a href="javascript:void(0);" 
			 onclick="return openDetails(\''.$wiziq->url.'\');">Click here to enter class</a></td>
      </tr>
	  <tr><td></td></tr>';
  if($creditpending>0)
			{
echo  '<tr><td colspan="2" align="center" valign="top" ><input type="submit" name="update" value="Update Class" id="name"/><input type="hidden" value="'.$eventid.'" name="eventid"/><input type="hidden" id="old" name="old" value="oldclass"/></td>
      </tr>';
			}
			
	  echo '        
    </table></td>
  </tr>
  <tr><td>&nbsp;</td></tr><tr><td>
	   <script language="javascript" type="text/javascript">
	   
		var chk = "'.strtolower($status).'";
		
		if(chk == "no")
		{
			document.getElementById("rdtypeno").checked = "true";
		}
		else
		{  	
				document.getElementById("rdtypeyes").checked = "true";
		}
		
		</script>
	 
	  </td></tr>
  </form>
  
</table>';
?>
<div style="width:550px; float:left; margin-left:20px">
   <iframe  src="package_message.php" id="remote_iframe_1" name="remote_iframe_1" style="border:0;padding:0;margin:0;width:80%;height:100px;overflow:auto" frameborder=0 scrolling="no" onload=" " ></iframe>
                         </div>
                         <?php

}	
}
echo '</td>
</tr>
</table>';
 echo '</div>';
    echo '</td>';
    echo '<td class="sidecalendar">';
 

    echo '</td>';
    echo '</tr></table>';
	

   echo $OUTPUT->footer();
	

?>
