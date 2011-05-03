<?php /*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Here all classes are shownt in list form with details and control to manage them like delete, editing, viewrecoring, download recording, attendance report.
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<script type='text/javascript'>window.onerror = handleError; function handleError(){return true;}</script>
<style  type="text/css">
.uploadingdiv{border:solid 10px #ccc; background-color:#fff; padding:10px;}
</style>
<script type="text/javascript" language="javascript" src="http://org.wiziq.com/Common/JS/ModalPopup.js"></script>
<script language="javascript" src="http://org.wiziq.com/Common/JS/jquery.js" type="text/javascript"></script>

 <link href="http://org.wiziq.com/Common/CSS/ModalPopup.css" rel="stylesheet" type="text/css" />
  <link href="http://org.wiziq.com/Common/CSS/thickbox.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
function PopUp(code)
{
	
	document.getElementById("divmodal").style.display="block";
	document.getElementById("divmodal").style.visibility="visible";
	document.getElementById("ifrmDownload").src = "downloadrec.php?SessionCode="+code+"&amp;keepThis=true&TB_iframe=true&height=250&width=400";
PopupShow('divmodal','modalBackground'); 
return true;
}
 function openDetails(Url)
    {   
		
        var scheight=screen.height;
        var scwidth=screen.width;
        var w=window.open(Url, null, "left=0,top=0,resize=0, height="+scheight+", width="+scwidth);
		w.focus();
		return false;
    }
</script>
</head>
<body>
<div id="divmodal"  class="modalWindow" style="display: none; width: 500px;">
    <div id="dvMod1" class="uploadingdiv" style="height:200px">
       <div id="close1" style="float:right;"><a id="A1" href="javascript:PopupClose();" >Close</a></div>
          <iframe id="ifrmDownload" width="470px" height="190px" frameborder="0" scrolling="no" style="font-family:Arial; font-size:12px; color:#444" ></iframe>          
                            
    </div>           
 </div>
<img id="modalBackground" class="modalBackground" width="100%" style="display: none; z-index: 3; left: -6px; top: 120px; height: 94%;" alt=""  />
  
<?php  
 require_once("../../config.php");
 require_once("lib.php");
 include("paging.php");
 require_once($CFG->dirroot .'/course/lib.php');
 require_once($CFG->dirroot .'/lib/blocklib.php');
require_once($CFG->dirroot.'/calendar/lib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');
require_once("wiziqconf.php");

//-------------------------Reading the xml file of user---------------------

$content = file_get_contents($ConfigFile);
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
    $limit=10; //setting the limit of no of records shown per page
 if($_REQUEST['course']<>"")
 {
$courseid=$_REQUEST['course'];
 }
 else
 {
	$courseid=$_REQUEST['id'];
 }
 $view = optional_param('view', 'upcoming', PARAM_ALPHA);

$action = optional_param('action', 'new', PARAM_ALPHA);
$id = optional_param('id', 0, PARAM_INT);
$instance = optional_param('instance', 0, PARAM_INT);
$cal_y = optional_param('cal_y', 0, PARAM_INT);
$cal_m = optional_param('cal_m', 0, PARAM_INT);
$cal_d = optional_param('cal_d', 0, PARAM_INT);

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


 $PAGE->set_title("$site->shortname: $strwiziqs: $pagetitle");
$PAGE->set_heading($COURSE->fullname);
//$PAGE->set_button($prefsbutton);

$PAGE->set_pagelayout('admin');
//$renderer = $PAGE->get_renderer('core_calendar');
//$calendar->add_sidecalendar_blocks($renderer, true, $view);
$PAGE->navbar->add($COURSE->fullname, new moodle_url('../../course/view.php?id='.$courseid));
$PAGE->navbar->add($strwiziqs, new moodle_url('../../mod/wiziq/index.php?course='.$courseid));
$PAGE->navbar->add('WiZiQ Classes');
echo $OUTPUT->header();

//echo $renderer->start_layout();
//------------------Getting the timezone of user currently logged in----------
$timezones = get_list_of_timezones();
        
        
         if ($CFG->forcetimezone != 99)
         
            {
                $tmzone=$CFG->forcetimezone;
            }
            else {
                $tmzone=$USER->timezone;
            	}
       
 if(!is_numeric($tmzone))
{
	if ($CFG->forcetimezone != 99)
 	{
 		$timezone=$CFG->forcetimezone;
 	}
	else
	$timezone=$USER->timezone;
}
else
{
// check timezone
switch($tmzone)
{
case("-13.0"):
{
$timezone="GMT-13";
break;
}

case("-12.5"):
{
$timezone="GMT-12.5";
break;
}
case("-12.0"):
{
$timezone="GMT-12";
break;
}

case("-11.5"):
{
$timezone="GMT-11.5";
break;
}

case("-11.0"):
{
$timezone="GMT-11";
break;
}
case("-10.5"):
{
$timezone="GMT-10.5";
break;
}
case("-10.0"):
{
$timezone="GMT-10";
break;
}

case("-9.5"):
{
$timezone="GMT-9.5";
break;
}

case("-9.0"):
{
$timezone="GMT-9";
break;
}

case("-8.5"):
{
$timezone="GMT-8.5";
break;
}

case("-8.0"):
{
$timezone="GMT-8";
break;
}
case("-7.5"):
{
$timezone="GMT-7.5";
break;
}

case("-7.0"):
{
$timezone="GMT-7";
break;
}

case("-6.5"):
{
$timezone="GMT-6.5";
break;
}
case("-6.0"):
{
$timezone="GMT-6";
break;
}
case("-5.5"):
{
$timezone="GMT-5.5";
break;
}
case("-5.0"):
{
$timezone="GMT-5";
break;
}
case("-4.5"):
{
$timezone="GMT-4.5";
break;
}
case("-4.0"):
{
$timezone="GMT-4";
break;
}
case("-3.5"):
{
$timezone="GMT-3.5";
break;
}
case("-3.0"):
{
$timezone="GMT-3";
break;
}
case("-2.5"):
{
$timezone="GMT-2.5";
break;
}
case("-2.0"):
{
$timezone="GMT-2";
break;
}
case("-1.5"):
{
$timezone="GMT-1.5";
break;
}
case("-1.0"):
{
$timezone="GMT-1";
break;
}
case("-0.5"):
{
$timezone="GMT-0.5";
break;
}
case("0.0"):
{
$timezone="GMT";
break;
}
case("0.5"):
{
$timezone="GMT+0.5";
break;
}
case("1.0"):
{
$timezone="GMT+1";
break;
}
case("1.5"):
{
$timezone="GMT+1.5";
break;
}
case("2.0"):
{
$timezone="GMT+2";
break;
}
case("2.5"):
{
$timezone="GMT+2.5";
break;
}
case("3.0"):
{
$timezone="GMT+3";
break;
}
case("3.5"):
{
$timezone="GMT+3.5";
break;
}
case("4.0"):
{
$timezone="GMT+4";
break;
}
case("4.5"):
{
$timezone="GMT+4.5";
break;
}
case("5.0"):
{
$timezone="GMT+5";
break;
}
case("5.5"):
{
$timezone="GMT+5.5";
break;
}
case("6.0"):
{
$timezone="GMT+6";
break;
}
case("6.5"):
{
$timezone="GMT+6.5";
break;
}
case("7.0"):
{
$timezone="GMT+7";
break;
}
case("7.5"):
{
$timezone="GMT+7.5";
break;
}
case("8.0"):
{
$timezone="GMT+8";
break;
}
case("8.5"):
{
$timezone="GMT+8.5";
break;
}
case("9.0"):
{
$timezone="GMT+9";
break;
}
case("9.5"):
{
$timezone="GMT+9.5";
break;
}
case("10.0"):
{
$timezone="GMT+10";
break;
}
case("10.5"):
{
$timezone="GMT+10.5";
break;
}
case("11.0"):
{
$timezone="GMT+11";
break;
}
case("11.5"):
{
$timezone="GMT+11.5";
break;
}
case("12.0"):
{
$timezone="GMT+12";
break;
}
case("12.5"):
{
$timezone="GMT+12.5";
break;
}
case("13.0"):
{
$timezone="GMT+13";
break;
}
default:
  {
$timezone="GMT-6.0";
  }
}
}
$modquery="SELECT id FROM {modules} where name='wiziq'"; // getting module id
$modresult=$DB->get_record_sql($modquery);
$moduleid=$modresult->id;

if(!empty($_REQUEST['refresh']) && $_REQUEST['refresh']==1) // if refresh button is clicked
{
$params=array('courseid'=>$courseid,'moduleid'=>$moduleid);
// this query only bring those records which are done,scheduled or in progress
$query="SELECT * FROM {wiziq} where classstatus in('S','D','I') AND id in (select distinct e.instance from {event} e,{course_modules} cm WHERE e.instance=cm.instance AND cm.course=:courseid AND cm.module=:moduleid AND e.name like '%mod/wiziq/pix/icon.gif%') UNION SELECT *  FROM {wiziq} WHERE oldclasses =1 ORDER BY insescod DESC ";
$query=paging_1($query,"","0%",$courseid,$params);
 $result=$DB->get_records_sql($query,$params);
 
$szXMLNode="";
$sessiontype=array();
$classID=array();
$countID=1;
foreach($result as $rn)
{
	$j=1;
	$code=$rn->insescod;
	$szXMLNode=$szXMLNode."<table><sessioncode>".$code."</sessioncode></table>";
	$classID[$countID][$j]=$code;
	$classID[$countID][$j+1]=$rn->id;
    $countID++;
}
function do_post_request($url, $data, $optional_headers = null) // getting the status of sessions done,expire etc
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
				'szXMLNode'=>'<newdataset>'.$szXMLNode.'</newdataset>',
				   );
 $resultanttt=do_post_request($WebServiceUrl.'moodle/class/GetSessionsStatus',http_build_query($person, '', '&'));
	
	try
	{
	 $objDOM = new DOMDocument();
 	 $objDOM->loadXML($resultanttt); 
  //make sure path is correct
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}
$Table= $objDOM->getElementsByTagName("table");	
$length =$Table->length;
$i=1;
foreach( $Table as $value )
  {
	  $j=1;
$test = $value->getElementsByTagName("sessioncode");
 $SessionCode= $test->item(0)->nodeValue;
//$sessiontype[$i][$j]=$SessionCode;  
$sessioncodeArray[$i]=$SessionCode;
$test1 = $value->getElementsByTagName("type");
 $type= $test1->item(0)->nodeValue;
//$sessiontype[$i][$j+1]=$type;
$test2=$value->getElementsByTagName("status");
 $status=$test2->item(0)->nodeValue;
//$sessiontype[$i][$j+2]=$status; download

$test3=$value->getElementsByTagName("isaglivesummarygenerated");
 $IsaGLiveSummaryGenerated=$test3->item(0)->nodeValue;
//$sessiontype[$i][$j+3]=$IsaGLiveSummaryGenerated; attendance

 $test4=$value->getElementsByTagName("movestatus");
 $MoveStatus=$test4->item(0)->nodeValue;
//$sessiontype[$i][$j+4]=$MoveStatus; view
//print_r($classID);
$k=1;
foreach($classID as $record)
{
	$j=1;
	if(current($record)==$SessionCode)
	{ 
$paramUpdate=array('id'=>$classID[$k][$j+1],'classstatus'=>$type,'downloadrec'=>$MoveStatus,'attendancerep'=>$IsaGLiveSummaryGenerated,'viewrec'=>$status);
$DB->update_record('wiziq', $paramUpdate, $bulk=false);
	}
	$k++;
}
$i++;
}
}
//----------------------------- for having role of user----------------------------------
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
<?php
//---------------------getting the current url-----------------
function curPageURL() {
 $pageURL = 'http';
 if (!empty($_SERVER["HTTPS"])&&($_SERVER["HTTPS"] == "on")) {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>

<table border="0" cellpadding="5px" cellspacing="5px" align="left"  width="100%">
 <tr><td height="30">
  
 <strong>WiZiQ Classes</strong> 
           </td></tr>
  <tr>
    <td align="center" ><font size="1px">
              <p align="right" style="margin-bottom:3px;">*Class Date & Time is shown in your Time Zone (<?php echo $timezone ?>)</p>
           </font><table width="100%" border="1" cellpadding="5px" cellspacing="5px" align="center"  style="border:solid 1px #dedede">
        
          <tr height="30px" style="background-color:#efefef;">
          <th  class="header" style="font-size:12px;padding-left:10px; text-align:left"><strong>Class Name </strong></th>
          <th  class="header" style="padding-left:10px;font-size:12px;text-align:left"><strong>Date & Time </strong></th>
          <th  class="header" align="left" style="font-size:12px;text-align:left"><strong>Status<?php  $url=curPageURL(); 
$urlparam=split("&",$url);
$size=sizeof($urlparam);
if(!empty($_SERVER["REQUEST_URI"]))
$abs= $_SERVER["REQUEST_URI"];
$index=strpos($abs,"?");
if(empty($index))
{
?>
<a href="<?php echo curPageURL()."?refresh=1"; ?>" id="hrefRefresh"><img src="images/refresh.jpg" alt="Refresh" title="Refresh"/></a>
	 <?php 
}
else if($urlparam[$size-1]=="refresh=1" ) {?>
<a href="<?php echo curPageURL(); ?>" id="hrefRefresh"><img src="images/refresh.jpg" alt="Refresh" title="Refresh"/></a><?php } 
else { ?>
<a href="<?php echo curPageURL()."&refresh=1"; ?>" id="hrefRefresh"><img src="images/refresh.jpg" alt="Refresh" title="Refresh"/></a><?php }?>
</strong></th>
          <th class="header" align="left" style="padding-left:10px;font-size:12px;text-align:left"><strong>Manage</strong></th>
          <th class="header" align="left" style="padding-left:10px;font-size:12px;text-align:left"><strong>Actions</strong></th>
        </tr>
        <?php 
$params=array('courseid'=>$courseid,'moduleid'=>$moduleid); //getting records with respect to course allow to shown those
$query="SELECT * FROM {wiziq} where id in (select distinct e.instance from {event} e,{course_modules} cm WHERE e.instance=cm.instance AND cm.course=:courseid AND cm.module=:moduleid AND e.name like '%mod/wiziq/pix/icon.gif%') UNION SELECT *  FROM {wiziq} WHERE oldclasses =1 ORDER BY insescod DESC ";
$query=paging_1($query,"","0%",$courseid,$params);
 $result=$DB->get_records_sql($query,$params);

foreach($result as $r)
{
	$code=$r->insescod;
	$recordingurl=$r->recordingurl;
	$wizid=$r->id;
	$params1=array('wizid'=>$wizid,'instance'=>$wizid);
	$query1="select e.id as eid,e.eventtype as eventtype,cm.id as cmid,e.instance as einst,cm.instance as cminst,e.userid as eventuserid from {event} e,{course_modules} cm where e.instance=:wizid and cm.instance=:instance";
$result1=$DB->get_record_sql($query1,$params1);

 $eventtype=$result1->eventtype;
 if($eventtype=="user")
 $_eventType="User Event";

 else if($eventtype=="site")
 $_eventType="Site Event";

 else if($eventtype=="course")
 $_eventType="Course Event";

 else if($eventtype=="group")
 $_eventType="Group Event";
	$name=$r->name;
	$eid=$result1->eid;
	$id=$r->id;
	$times=$r->wdate;
	$instance=$result1->einst;
	$einst=$result1->einst;
	$eventuserid=$result1->eventuserid;
	$udate=usergetdate($times);

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
  $timecheck=1; 
 }
 else if( $udate['mon'] < $todaydate['mon'] && $udate['yday'] <= $todaydate['yday'])
 {
  $timecheck=1;
 }
 else if($udate['hours'] < $todaydate['hours'] && $udate['mon'] <= $todaydate['mon'] && $udate['yday'] <= $todaydate['yday'])
 {
  $timecheck=1; 
 }
 else if( $udate['minutes'] < $todaydate['minutes'] && $udate['hours'] <= $todaydate['hours'] && $udate['mon'] <= $todaydate['mon'] && $udate['yday'] <= $todaydate['yday'])
 {
  $timecheck=1; 
 }
}
   $wtime=calendar_time_representation($times); // converting the time in users timezone format
   $cmid=$result1->cmid;
   $type=$r->statusrecording;
   $courseid=$r->course;//$result2->course;
   //---------------------------user events shown only for users authorized to see---------------------
   if($eventtype=="user" && $r->oldclasses!=1)
	{
	?> 
        <tr height="30px">
          <td style="padding-left:10px; font-size:12px;border:solid 1px #efefef"><a href="view.php?id=<?php echo $cmid; ?>&type=<?php echo $type; ?>"><?php echo $name;?></a></td>
          <td style="padding-left:10px; font-size:12px;border:solid 1px #efefef"><?php echo $wdate.", ".$wtime;?></td>
          
          <td style="padding-left:10px; font-size:12px;border:solid 1px #efefef"><?php $i=1;
		  
		  	  if($r->classstatus==="D")
			  echo "Done";
			  else if($r->classstatus==="E")
			  echo "Expired";
			  else if($r->classstatus==="S")
			  echo "Scheduled";
			  else if($r->classstatus==="I")
			  echo "InProgress";
			  
			   ?></td><td align="center" style="border:solid 1px #efefef"><?php if($r->classstatus==="S" && ($eventuserid==$USER->id  || $role==1 )){ ?><a href="edit_view.php?id=<?php echo $cmid; ?>&type=<?php echo $type ?>&eventtype=<?php echo $_eventType; ?>"><?php echo "<img
                  src=\" ".$OUTPUT->pix_url('t/edit')."\" alt=\" ".get_string('tt_editevent', 'calendar')."\"
                 title=\" ".get_string('tt_editevent', 'calendar')." \"  />" ?></a> &nbsp;<a href="delete_session.php?id=<?php echo $courseid;?>&section=0&sesskey=<?php echo $USER->sesskey;?>&add=wiziq&aid=<?php echo $id;?>&eid=<?php echo $eid; ?>&type=0&inst=<?php echo $cmid;?>&course=<?php echo $courseid; ?>"><?php echo "<img
                  src=\" ".$OUTPUT->pix_url('t/delete')."\" alt=\" ".get_string('tt_deleteevent', 'calendar')."\"
                 title=\" ".get_string('tt_deleteevent', 'calendar')." \"  />" ?></a> <?php } ?></td><td width="40%" style="border:solid 1px #efefef"><table cellspacing="10px" cellpadding="10px" width="100%"><tr>
                 <td style="padding-left:10px; font-size:12px" width="30%"><?php 
			   if(($eventuserid==$USER->id  || $role==1 ))
			   {
			   
			 		   if($r->viewrec==1)
			 		  {
echo '<a onclick="return openDetails(\''.$CFG->wwwroot.'/mod/wiziq/viewrecording.php?s='.encrypt($code,"Auth@Moo(*)").'\');" href="javascript:void(0);">View Recording</a>';
			 }
			  
			   }?></td>
                 <td style="padding-left:5px; font-size:12px" width="37%"><?php
			   if(($eventuserid==$USER->id  || $role==1 ))
			   {
			   
			  if($r->downloadrec==2)
			  echo '<a onclick="return PopUp(\''.$code.'\');" href="javascript:void(0);">Download Recording</a>';
			 
			   }?></td><td style=" font-size:12px" width="35%"><?php 
			   if(($eventuserid==$USER->id  || $role==1 ))
			   {
			    
			 if($r->attendancerep==1)
			  echo '<a  href="attendancereport.php?courseid='.$courseid.'&SessionCode='.$code.'">Attendance Report</a>';
			 
			   }?></td></tr></table></td>
        </tr>
<?php
	}  //----------------------group events only for groups allowed to see------------	
else if($eventtype=="group" && $r->oldclasses!=1)
{
	$grpflag=1;
	$grpParam=array('instance'=>$id); // getting the group members
$grpquery="select groupid,userid from {groups_members} where groupid in(select groupid from {event} where instance=:instance)";
$grpQresult=$DB->get_records_sql($grpquery,$grpParam);
$while=1;
foreach($grpQresult as $grpresult )
{
	$grpary[$while]=$grpresult->userid;
	$while++;
}
 foreach($grpary as $grpuserid)
		  {
		
if(($grpuserid==$USER->id || $role==1 || $eventuserid==$USER->id )&& $grpflag==1 )
{
	$grpflag=0;

   ?>     <tr height="30px">
          <td style="padding-left:10px; font-size:12px;border:solid 1px #efefef"><a href="view.php?id=<?php echo $cmid; ?>&type=<?php echo $type; ?>"><?php echo $name;?></a></td>
          <TD style="padding-left:10px; font-size:12px;border:solid 1px #efefef"><?php echo $wdate.", ".$wtime;?></TD>
          
          <td style="padding-left:10px; font-size:12px;border:solid 1px #efefef"><?php $i=1;
		  
		      if($r->classstatus==="D")
			  echo "Done";
			  else if($r->classstatus==="E")
			  echo "Expired";
			  else if($r->classstatus==="S")
			  echo "Scheduled";
			  
			   ?></td><td align="center" style="border:solid 1px #efefef"><?php if($r->classstatus==="S" && ($eventuserid==$USER->id  || $role==1 )){ ?><a href="edit_view.php?id=<?php echo $cmid; ?>&type=<?php echo $type ?>&eventtype=<?php echo $_eventType; ?>"><?php echo "<img
                  src=\" ".$OUTPUT->pix_url('t/edit')."\" alt=\" ".get_string('tt_editevent', 'calendar')."\"
                 title=\" ".get_string('tt_editevent', 'calendar')." \"  />" ?></a> &nbsp;<a href="delete_session.php?id=<?php echo $courseid;?>&section=0&sesskey=<?php echo $USER->sesskey;?>&add=wiziq&aid=<?php echo $id;?>&eid=<?php echo $eid; ?>&type=0&inst=<?php echo $cmid;?>&course=<?php echo $courseid; ?>"><?php echo "<img
                  src=\" ".$OUTPUT->pix_url('t/delete')."\" alt=\" ".get_string('tt_deleteevent', 'calendar')."\"
                 title=\" ".get_string('tt_deleteevent', 'calendar')." \"  />" ?></a> <?php } ?></td><td width="40%" style="border:solid 1px #efefef"><table cellspacing="10px" cellpadding="10px" width="100%" ><tr>
                 <td style="padding-left:10px; font-size:12px" width="30%"><?php 
			   
			 if($r->viewrec==1)
			 {
			  
			  echo '<a onclick="return openDetails(\''.$CFG->wwwroot.'/mod/wiziq/viewrecording.php?s='.encrypt($code,"Auth@Moo(*)").'\');" href="javascript:void(0);">View Recording</a>';
			 }
			  
			   ?></td>
                 <td style="padding-left:5px; font-size:12px" width="37%"><?php
			   			    
			  if($r->downloadrec==2)
			  echo '<a onclick="return PopUp(\''.$code.'\');" href="javascript:void(0);">Download Recording</a>';
			  
			   ?></td><td style=" font-size:12px" width="35%"><?php 
			   
			  if($r->attendancerep==1)
			  echo '<a  href="attendancereport.php?courseid='.$courseid.'&SessionCode='.$code.'">Attendance Report</a>';
			  
			   ?></td></tr></table></td>
        </tr>

<?php
}
}
}
if($r->oldclasses==1)
{
$cmid=$result1->cmid;
	?>
<tr>
 <td style="padding-left:10px; padding-top:5px; font-size:12px;border:solid 1px #efefef"><a href="view.php?id=<?php echo $cmid; ?>&type=<?php echo $type; ?>"><?php echo $name;?></a></td>
 <TD style="padding-left:10px; padding-top:5px; font-size:12px;border:solid 1px #efefef"><?php echo $wdate." , ".$wtime;?></TD>
 <td style="padding-left:10px; font-size:12px;border:solid 1px #efefef"><?php $i=1;
		  
			  if($r->classstatus==="D")
			  echo "Done";
			  else if($r->classstatus==="E")
			  echo "Expired";
			  else if($r->classstatus==="S")
			  echo "Scheduled";
			  else if($r->classstatus==="I")
			  echo "InProgress";
			  
		   if($_REQUEST['course']<>"")
 {
$courseid=$_REQUEST['course'];
 }
 else
 {
	$courseid=$_REQUEST['id'];
 }
			   ?></td>
 <td align="center" style="border:solid 1px #efefef"><a href="delete_session.php?id=<?php echo $courseid;?>&section=0&sesskey=<?php echo $USER->sesskey;?>&add=wiziq&aid=<?php echo $id;?>&eid=<?php echo $eid; ?>&type=0&inst=<?php echo $cmid;?>&course=<?php echo $courseid; ?>"><?php echo "<img
                  src=\" ".$OUTPUT->pix_url('t/delete')."\" alt=\" ".get_string('tt_deleteevent', 'calendar')."\"
                 title=\" ".get_string('tt_deleteevent', 'calendar')." \"  />" ?></a></td><td></td> </tr>	
<?php 
} //----------------------site events and course events for users allowed to see---------------
else if($eventtype!="group" && $eventtype!="user" )
{
?>
        <tr height="30px">
          <td style="padding-left:10px; font-size:12px;border:solid 1px #efefef" width="120px"><a href="view.php?id=<?php echo $cmid; ?>&type=<?php echo $type; ?>"><?php echo $name;?></a></td>
          <TD style="padding-left:10px; font-size:12px;border:solid 1px #efefef" width="120px"><?php echo $wdate.", ".$wtime;?></TD>
          
          <td style="padding-left:10px; font-size:12px;border:solid 1px #efefef" width="10px"><?php $i=1;
		  
		  	  if($r->classstatus==="D")
			  echo "Done";
			  else if($r->classstatus==="E")
			  echo "Expired";
			  else if($r->classstatus==="S")
			  echo "Scheduled";
			  else if($r->classstatus==="I")
			  echo "InProgress";
			  
			   ?></td><td align="center" style="border:solid 1px #efefef"><?php if($r->classstatus==="S" && ($eventuserid==$USER->id  || $role==1 )){ ?><a href="edit_view.php?id=<?php echo $cmid; ?>&type=<?php echo $type ?>&eventtype=<?php echo $_eventType; ?>" ><?php echo "<img
                  src=\" ".$OUTPUT->pix_url('t/edit')."\" alt=\" ".get_string('tt_editevent', 'calendar')."\"
                 title=\" ".get_string('tt_editevent', 'calendar')." \"  />" ?></a> &nbsp;<a href="delete_session.php?id=<?php echo $courseid;?>&section=0&sesskey=<?php echo $USER->sesskey;?>&add=wiziq&aid=<?php echo $id;?>&eid=<?php echo $eid; ?>&type=0&inst=<?php echo $cmid;?>&course=<?php echo $courseid; ?>" ><?php echo "<img
                  src=\" ".$OUTPUT->pix_url('t/delete')."\" alt=\" ".get_string('tt_deleteevent', 'calendar')."\"
                 title=\" ".get_string('tt_deleteevent', 'calendar')." \"  />" ?></a> <?php } ?></td><td width="40%" style="border:solid 1px #efefef"><table cellspacing="0px" cellpadding="0px" width="100%"><tr>
                <td style=" font-size:12px" width="30%"><?php 
     		 if($r->viewrec==1)
			  
			  echo '<a onclick="return openDetails(\''.$CFG->wwwroot.'/mod/wiziq/viewrecording.php?s='.encrypt($code,"Auth@Moo(*)").'\');" href="javascript:void(0);">View Recording</a>';
			
			   ?></td>
                 <td style="font-size:12px" width="37%"><?php
			   
			 if($r->downloadrec==2)
			  echo '<a onclick="return PopUp(\''.$code.'\');" href="javascript:void(0);">Download Recording</a>';
			  
			   ?></td><td style=" font-size:12px" width="35%"><?php 
			  
			 if($r->attendancerep==1)
			  echo '<a  href="attendancereport.php?courseid='.$courseid.'&SessionCode='.$code.'">Attendance Report</a>';
			  
			   ?></td></tr></table></td>
        </tr>
       
        
<?php	
}
//-------------------------end------------------------------------
}
?>
<Tr>
          <td colspan="5" align="right"><input type="button" class="txtbox" name="Cancel" value="Go Back" onClick="javascript:location.href='<?php echo $CFG->wwwroot .'/index.php' ?>'"></td></tr><tr><td colspan="5" align="right">
            <?php
$str="";

paging_2($str,"0%",$courseid);
?></td>
        </Tr>
      </table></td>
  </tr></table>
</td></tr></table>
<?php // encrypt function for view recording link
function encrypt($string, $key) {
$result = '';
for($i=0; $i<strlen($string); $i++) {
$char = substr($string, $i, 1);
$keychar = substr($key, ($i % strlen($key))-1, 1);
$char = chr(ord($char)+ord($keychar));
$result.=$char;
}

return base64_encode($result);
}
echo $OUTPUT->footer();
?>
</body>