<br /><br /><br /><br />

<div style="display:block" id="div123">

<p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="3"><strong><img src="pix/icon.gif" hspace="10" height="16" width="16" border="0" alt="" />We Are Processing Your Request. Please Wait............</strong></font></p></div>


	<?php
	/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Session scheduled here by calling api and records inserted in database
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
	$timestamp=strtotime(now);
	require_once("wiziqconf.php");
//------------------------- reading the xml file of user---------------------

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
require_once ($CFG->dirroot.'/lib/moodlelib.php');

$section       = $_REQUEST['section'];//required_param('section', PARAM_INT);
$course        = $_REQUEST['course'];//optional_param('course', 0, PARAM_INT);
//mod edit code
$course = $DB->get_record('course', array('id'=>$course), '*', MUST_EXIST); //getting the course info
$module = $DB->get_record('modules', array('name'=>'wiziq'), '*', MUST_EXIST); //getting the moduleid
$cw = get_course_section($section, $course->id);
//print_r($cw);
$cm = null;

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
	 $context = get_context_instance(CONTEXT_COURSE, $course->id);
// code end
       $name=$_POST['name'];
	   // $special = array(" ",'/','!','&','*','@','#','$','%','^','&','*','(',')','<','>','?'); 
 
       
        $name = str_replace ($special, "_", $name);

       $date=$_POST['date'];
	   $time=$_POST['time'];
	                 //$hh=$_POST['hh'];    
              //$mm=$_POST['mm'];
                          //  $ampm=$_POST['ampm'];
                     $duration=intval($_POST['duration']); 
					 
					 
                    // $timezone1=$_POST['timezone'];       
                     $audio=$_POST['audio'];
                     if($audio=="Video")
                     {
                     $waudio="Audio and Video";
					 
                     }
                     if($audio=="Audio")
                     {
                     $waudio="Audio";
					  

                     }
					  $type=$_REQUEST['type'];
				
					
					 if($type=="yes")
					 {
						 $recordingtype="yes"; 
						
					 }
					 else 
					 {
						 $recordingtype="no";
					 }
                   
				   $time=$_REQUEST['time'];
				  
                    list($month, $day, $year)=split('[/.-]', $date);
                   
// check timezone of user
if ($CFG->forcetimezone != 99)
 {
     $tmzone=$CFG->forcetimezone;
 } 
 else
  $tmzone=$USER->timezone; 
if(!is_numeric($tmzone))
{
	$tmzone=get_user_timezone_offset($tmzone);
}

switch($tmzone)
{
	
case("-13.0"):
{
//(GMT+05:00)	
$timezone="GMT-13:00";
//$timezone_aglive = 18;
break;
}

case("-12.5"):
{
$timezone="GMT-12:50";
//$timezone_aglive = 18;
break;
}
case("-12.0"):
{
$timezone="GMT-12:00";
//$timezone_aglive = 18;
break;
}

case("-11.5"):
{
$timezone="GMT-11:50";
//$timezone_aglive = 58;
break;
}

case("-11.0"):
{
$timezone="GMT-11:00";
//$timezone_aglive = 58;
break;
}
case("-10.5"):
{
$timezone="GMT-10:50";
//$timezone_aglive = 32;

break;
}
case("-10.0"):
{
$timezone="GMT-10:00";
////$timezone_aglive = 32;
break;
}

case("-9.5"):
{
$timezone="GMT-09:50";
//$timezone_aglive = 48;
break;
}

case("-9.0"):
{
$timezone="GMT-09:00";
//$timezone_aglive = 48;
break;
}

case("-8.5"):
{
$timezone="GMT-08:50";
//$timezone_aglive = 52;
break;
}

case("-8.0"):
{
$timezone="GMT-08:00";
//$timezone_aglive = 52;
break;
}
case("-7.5"):
{
$timezone="GMT-07:50";
//$timezone_aglive = 40;
break;
}

case("-7.0"):
{
$timezone="GMT-07:00";
//$timezone_aglive = 40;
break;
}

case("-6.5"):
{
$timezone="GMT-06:50";
//$timezone_aglive = 16;
break;
}
case("-6.0"):
{
$timezone="GMT-06:00";
//$timezone_aglive = 16;
break;
}
case("-5.5"):
{
$timezone="GMT-05:50";
//$timezone_aglive = 23;
break;
}
case("-5.0"):
{
$timezone="GMT-05:00";
//$timezone_aglive = 23;
break;
}
case("-4.5"):
{
$timezone="GMT-04:50";
//$timezone_aglive = 3;
break;
}
case("-4.0"):
{
$timezone="GMT-04:00";
//$timezone_aglive = 3;
break;
}
case("-3.5"):
{
$timezone="GMT-03:50";
//$timezone_aglive = 29;
break;
}
case("-3.0"):
{
$timezone="GMT-03:00";
//$timezone_aglive = 29;
break;
}
case("-2.5"):
{
$timezone="GMT-02:50";
break;
}
case("-2.0"):
{
$timezone="GMT-02:00";
//$timezone_aglive = 39;
break;
}
case("-1.5"):
{
$timezone="GMT-01:50";
//$timezone_aglive = 6;
break;
}
case("-1.0"):
{
$timezone="GMT-01:00";
//$timezone_aglive = 6;
break;
}
case("-0.5"):
{
$timezone="GMT-00:50";
//$timezone_aglive = 28;
break;
}
case("0.0"):
{
$timezone="GMT";
//$timezone_aglive = 28;
break;
}
case("0.5"):
{
$timezone="GMT+00:50";
//$timezone_aglive = 53;
break;
}
case("1.0"):
{
$timezone="GMT+01:00";
//$timezone_aglive = 53;
break;
}
case("1.5"):
{
$timezone="GMT+01:50";
//$timezone_aglive = 35;
break;
}
case("2.0"):
{
$timezone="GMT+02:00";
//$timezone_aglive = 24;
break;
}
case("2.5"):
{
$timezone="GMT+02:50";
//$timezone_aglive = 2;

break;
}
case("3.0"):
{
$timezone="GMT+03:00";
//$timezone_aglive = 2;
break;
}
case("3.5"):
{
$timezone="GMT+03:50";
//$timezone_aglive = 34;
break;
}
case("4.0"):
{
$timezone="GMT+04:00";
//$timezone_aglive = 1;
break;
}
case("4.5"):
{
$timezone="GMT+04:50";
//$timezone_aglive = 47;
break;
}
case("5.0"):
{
$timezone="GMT+05:00";
//$timezone_aglive = 73;
break;
}
case("5.5"):
{
$timezone="GMT+05:50";
//$timezone_aglive = 33;
break;
}
case("6.0"):
{
$timezone="GMT+06:00";
//$timezone_aglive = 12;
break;
}
case("6.5"):
{
$timezone="GMT+06:50";
//$timezone_aglive = 41;
break;
}
case("7.0"):
{
$timezone="GMT+07:00";
//$timezone_aglive = 59;
break;
}
case("7.5"):
{
$timezone="GMT+07:50";
//$timezone_aglive = 17;
break;
}
case("8.0"):
{
$timezone="GMT+08:00";
//$timezone_aglive = 17;
break;
}
case("8.5"):
{
$timezone="GMT+08:50";
//$timezone_aglive = 36;
break;
}
case("9.0"):
{
$timezone="GMT+09:00";
//$timezone_aglive = 36;
break;
}
case("9.5"):
{
$timezone="GMT+09:50";
//$timezone_aglive = 10;
break;
}
case("10.0"):
{
$timezone="GMT+10:00";
//$timezone_aglive = 5;
break;
}
case("10.5"):
{
$timezone="GMT+10:50";
//$timezone_aglive = 10;
break;
}
case("11.0"):
{
$timezone="GMT+11:00";
//$timezone_aglive = 15;
break;
}
case("11.5"):
{
$timezone="GMT+11:50";
//$timezone_aglive = 26;
break;
}
case("12.0"):
{
$timezone="GMT+12:00";
//$timezone_aglive = 26;
break;
}
case("12.5"):
{
$timezone="GMT+12:50";

break;
}
case("13.0"):
{
$timezone="GMT+13:00";
//$timezone_aglive = 66;
break;
}
default:
  {
$timezone="GMT-06:00";
//$timezone_aglive = 33;
  }
}

//-----------------------making the date time string-----------------------

$indexof=strrpos($time, ":");
 if($indexof>0)
 {
    $mm=intval(substr($time,$indexof+1,2));
 }
 else
 $mm="00";
 $hh=intval(substr($time,0,2));
 
 $ampm=substr($time,-2);

$ampm=strtolower($ampm);
 
   //checking ends here
                    
                    
                   $hh1=intval($hh);
				   
                   if($ampm=="pm") 
                   {
				   
				   if($hh1<12)
							{
							$hh1=$hh1+12;
						
						
						}
					}
					if($ampm=="am")

						{
						if($hh1==12)
						{
						$hh1=00;
						}
						}				

                 $hh2=$hh1+12;
						
						
                   $mm1=intval($mm);
				  
                   $month1=intval($month);
                   $day1=intval($day);
                   $year1=intval($year);
				   
switch($month1)
{
    case("1"):
		{
        $stringmonth = "January";
		break;
		}
    case("2"):
		{
        $stringmonth = "February";
		break;
		}
    case("3"):
		{
        $stringmonth = "March";
		break;
		}
    case("4"):
		{
        $stringmonth = "April";
		break;
		}
    case("5"):
		{
        $stringmonth = "May";
		break;
		}
    case("6"):
		{
        $stringmonth = "June";
		}
    case("7"):
		{
        $stringmonth = "July";
		break;
		}
    case("8"):
		{
        $stringmonth = "August";
		break;
		}
    case("9"):
		{
        $stringmonth = "September";
		break;
		}
    case("10"):
		{
        $stringmonth = "October";
		break;
		}
    case("11"):
		{
        $stringmonth = "November";
		break;
		}
    case("12"):
		{
        $stringmonth = "December";
		break;
		}
} 
			  
	$datestr = date('Y-m-d\TH:i:s');
	$datestring=$stringmonth.' '.$day1.', '.$year1.' '.$time;
	$usr = $USER->username;
	$email = $USER->email;
 	$fqdn=$CFG->wwwroot ; 
    $id = intval($USER->id);   
			  
    $user = $DB->get_record("user", array("id"=>$id));
	$description=$user->description;
			  
	
$xyz=$date." ".$time;
$datetime=strtoupper($xyz); //final date time string
//end---------------------------------------------------------------------------------

//------------------initializing the parameters send to api---------------
$mm=$_REQUEST['duration'];
$maxduration=$mm-$maxdur;

if($presenterentry=="1")
	 {
			$entry="true";
	 }
     else if($presenterentry=="0")
		{
             $entry="false";
		}
if ($CFG->forcetimezone != 99)
 {
     $CountryNameTZ=$CFG->forcetimezone;
 } 
 else
 $CountryNameTZ=$USER->timezone;
 
$ScheduleNow=$_REQUEST['chkNow'];
//---------------end------------------------------------

//----------------------sending the request to api of wiziq for scheduling-------------------
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
  
  if($ScheduleNow=="checked") //if schedule now is checked
  {
	  $person = array(
	    'TimeZone' => $timezone,
		'CountryNameTZ'=>$CountryNameTZ,
	);
	 $result=do_post_request($WebServiceUrl.'moodle/class/schedulenow',http_build_query($person, '', '&')); 
	 try
	  {
	    $objDOM = new DOMDocument();
	    $objDOM->loadXML($result); 
	  }
	catch(Exception $e)
	  {
		echo $e->getMessage();
	  }
   
 	
	 $DateNow=$objDOM->getElementsByTagName("DateNow");
	 $DateNow=$DateNow->item(0)->nodeValue;
	$TimeNow=$objDOM->getElementsByTagName("TimeNow");
	 $TimeNow=$TimeNow->item(0)->nodeValue;
	$ErrorMessage=$objDOM->getElementsByTagName("message");
	$ErrorMessage=$ErrorMessage->item(0)->nodeValue; 
	
	
 $indexof=strrpos($TimeNow, ":");
 if($indexof>0)
 {
   
  $mm=intval(substr($TimeNow,$indexof+1,2));
 }
 else
 $mm="00";
 $hh=intval(substr($TimeNow,0,2));
 
 $ampm=substr($TimeNow,-2);

$ampm=strtolower($ampm);
 
   //checking ends here
                    
                    
                   $hh1=intval($hh);
				   
                   if($ampm=="pm") 
                   {
				   
				   if($hh1<12)
							{
							$hh1=$hh1+12;
						
						
						}
					}
					if($ampm=="am")

						{
						if($hh1==12)
						{
						$hh1=00;
						}
						}				

                 $hh2=$hh1+12;
						
                   $mm1=intval($mm);
	list($month, $day, $year)=split('[/.-]', $DateNow);						
			  
                   $month1=intval($month);
                   $day1=intval($day);
                   $year1=intval($year);
$time=$TimeNow;				   
$xyz=$DateNow." ".$TimeNow;
$datetime=strtoupper($xyz);
  }
  if(empty($ScheduleNow) || (!empty($DateNow) && !empty($TimeNow)) ) //if class scheduled 
  {
  $person = array(
	
		'CustomerKey'=>$customer_key,
		'EventName' => $_REQUEST['name'],
	 	'DateTime' => $datetime,
	    'TimeZone' => $timezone,
	    'Duration' => $_REQUEST['duration'],
	    'UserCode' => $id,
	    'UserName'=>$usr,
		'audio' => $audio,							
		'CountryNameTZ'=>$CountryNameTZ,
		'RecodingReplay'=>$recordingtype,
		
		
	);
	 $result=do_post_request($WebServiceUrl.'moodle/class/schedule',http_build_query($person, '', '&'));

  
   try
	  {
	    $objDOM = new DOMDocument();
	    $objDOM->loadXML($result); 
	  }
	catch(Exception $e)
	  {
		echo $e->getMessage();
	  }
   
 	
	 $Code=$objDOM->getElementsByTagName("SessionCode");
	 $SessionCode=$Code->item(0)->nodeValue;
	 $PresenterUrl=$objDOM->getElementsByTagName("PresenterUrl");
	 $PresenterUrl=$PresenterUrl->item(0)->nodeValue;
	 $RecordingUrl=$objDOM->getElementsByTagName("RecordingUrl");
$RecordingUrl=$RecordingUrl->item(0)->nodeValue;
	 $CommonAttendeeUrl=$objDOM->getElementsByTagName("CommonAttendeeUrl");
	$CommonAttendeeUrl=$CommonAttendeeUrl->item(0)->nodeValue;
	 $ReviewSessionUrl=$objDOM->getElementsByTagName("ReviewSessionUrl");
	$ReviewSessionUrl=$ReviewSessionUrl->item(0)->nodeValue;
	 $AttendeeUrls=$objDOM->getElementsByTagName("AttendeeUrls");
	$AttendeeUrls=$AttendeeUrls->item(0)->nodeValue;
	$ErrorMessage=$objDOM->getElementsByTagName("message");
	$ErrorMessage=$ErrorMessage->item(0)->nodeValue;
  }
	//exit;
if($SessionCode !=-1)
{	

	$event=$_REQUEST['name'];
	$presenterurl=$PresenterUrl;
	$recodingurl=$RecordingUrl;
	$reviewurl=$ReviewSessionUrl;
	$attendeeurl=$CommonAttendeeUrl;
	
	$insescod=$SessionCode;

$res=$result1['diffgram']['NewDataSet']['Table']['SessionURL'];

require_login();

    $sectionreturn = optional_param('sr', '', PARAM_INT);
    $add           = optional_param('add','', PARAM_ALPHA);
	$modulename    = optional_param('modulename','', PARAM_ALPHA);
	$mode    	   = optional_param('mode','', PARAM_ALPHA);
    $type          = optional_param('type', '', PARAM_ALPHA);
    $indent        = optional_param('indent', 0, PARAM_INT);
    $update        = optional_param('update', 0, PARAM_INT);
    $hide          = optional_param('hide', 0, PARAM_INT);
    $show          = optional_param('show', 0, PARAM_INT);
    $copy          = optional_param('copy', 0, PARAM_INT);
    $moveto        = optional_param('moveto', 0, PARAM_INT);
    $movetosection = optional_param('movetosection', 0, PARAM_INT);
    $delete        = optional_param('delete', 0, PARAM_INT);
    $course1       = optional_param('course', 0, PARAM_INT);
    $groupmode     = optional_param('groupmode', -1, PARAM_INT);
    $duplicate     = optional_param('duplicate', 0, PARAM_INT);
    $cancel        = optional_param('cancel', 0, PARAM_BOOL);
    $cancelcopy    = optional_param('cancelcopy', 0, PARAM_BOOL);
	
	$eventtype= $_REQUEST['eventType'];	
	$group=$_REQUEST['Groups'];
	
 $userid=$_REQUEST['userid'];	
$modquery="SELECT id FROM {modules} where name='wiziq'";
$modresult=$DB->get_record_sql($modquery);
$moduleid=$modresult->id;
//////////////////////////////////////////////////////////////
if (!empty($course->groupmodeforce) ) {
            $cm->groupmode = 0; // do not set groupmode
        }

        if (!course_allowed_module($course, $moduleName)) {
            print_error('moduledisable', '', '', $moduleName);
        }

        // first add course_module record because we need the context
        $form = new object();
        $form->course           = $course->id;
        $form->module           = $moduleid;
        $form->instance         = 0; // not known yet, will be updated later (this is similar to restore code)
        $form->visible          = 1;
        $form->groupmode        = 0;
        $form->groupingid       = 0;
        $form->groupmembersonly = 0;
        
        
        if (!$form->coursemodule = add_course_module($form)) {
            print_error('cannotaddcoursemodule');
        }
 $form->course = $course->id;
    $form->modulename = clean_param($moduleName, PARAM_SAFEDIR);  // For safety
	$form->section=$cw->section;
//--------------------Adding wiziq event--------------------
$obj2->name=$event;
$obj2->url=$presenterurl;
$obj2->attendeeurl=$attendeeurl;
$obj2->recordingurl=$recodingurl;
$obj2->reviewurl=$reviewurl;
$obj2->wtime=$time;
$obj2->wdur=$duration;


$obj2->wdate=make_timestamp($year, $month, $day, $hh1, $mm1);

$obj2->wtype=$waudio;
$obj2->insescod=$insescod;
$type=$_REQUEST['type'];
					 if($type=="yes")
					 {
						 $value=1;
					 }
					 else
					 {
						 $value=0;
					 }
					
$obj2->statusrecording=$value;
$obj2->timezone=$timezone;
$obj2->oldclasses='';
$obj2->course=$course->id;

                $return = wiziq_add_instance($obj2);
				$returnfromfunc=$return;
				
//--------------------Adding coursemodule entry--------------------

        if (!$returnfromfunc or !is_number($returnfromfunc)) {
            // undo everything we can
            $modcontext = get_context_instance(CONTEXT_MODULE, $form->coursemodule);
            delete_context(CONTEXT_MODULE, $form->coursemodule);
            $DB->delete_records('course_modules', array('id'=>$form->coursemodule));

            if (!is_number($returnfromfunc)) {
                print_error('invalidfunction', '', 'view.php?id=$course->id');
            } else {
                print_error('cannotaddnewmodule', '', "view.php?id=$course->id",  $moduleName);
            }
        }

        $form->instance = $returnfromfunc;

        $DB->set_field('course_modules', 'instance', $returnfromfunc, array('id'=>$form->coursemodule));
//print_r($form);
        // update embedded links and save files
        $modcontext = get_context_instance(CONTEXT_MODULE, $form->coursemodule);
        

        // course_modules and course_sections each contain a reference
        // to each other, so we have to update one of them twice.
        $sectionid = add_mod_to_section($form);

        $DB->set_field('course_modules', 'section', $sectionid, array('id'=>$form->coursemodule));

       
        // Trigger mod_created event with information about this module.
        $eventdata = new object();
        $eventdata->modulename = $moduleName;
        $eventdata->name       = $_REQUEST['name'];
        $eventdata->cmid       = $form->coursemodule;
        $eventdata->courseid   = $course->id;
        $eventdata->userid     = $USER->id;
        events_trigger('mod_created', $eventdata);

        add_to_log($course->id, "course", "add mod",
                   "../mod/$moduleName/view.php?id=$form->coursemodule",
                   "$moduleName $form->instance");
        add_to_log($course->id, $moduleName, "add",
                   "view.php?id=$form->coursemodule",
                   "$form->instance", $form->coursemodule);
                 

///----------------Adding information in wiziq attende info table-------------------      
     
	 $obj->username=$usr;
	  $obj->attendeeurl=$presenterurl;
	  $obj->insescod=$insescod;
	  $obj->userid=$USER->id;
    $result=wiziq_add_attendeeinfo($obj);
	
	
///----------------Adding information in event table-------------------      
      	   
		if($eventtype=="site")
		{
			$form1->courseid=SITEID;
			$form1->groupid=0;
		 	$form1->name='<img height="16" width="16" src="'.$CFG->wwwroot.'/mod/'.$moduleName.'/pix/icon.gif" style="vertical-align: middle;"/>'.' '.$name;
			
			
		 	$form1->description='<input type="text" value="'.$CFG->wwwroot.'/mod/'.$moduleName.'/view.php" onfocus="this.select();"><br><a href="'.$CFG->wwwroot.'/mod/'.$moduleName.'/view.php?instance='.$return.'" >View Class details</a>';
            $form1->userid=intval($USER->id);
            $form1->modulename="";//"wiziq";
            $form1->instance=$return;
			$form1->timestart=make_timestamp($year, $month, $day, $hh1, $mm1);
			$form1->timeduration=$_REQUEST['duration']*60;
            $form1->eventtype=$eventtype;
			$form1->format=1;
            $form1->visible=1;
			$eventid = wiziq_add_event($form1);  
		} 
		if($eventtype=='course')
		{
			
					$form1->courseid=$course->id;
					$form1->groupid=0;
			 		$form1->name='<img height="16" width="16" src="'.$CFG->wwwroot.'/mod/'.$moduleName.'/pix/icon.gif" style="vertical-align: middle;"/>'.' '.$name;
					$form1->description='<input type="text" value="'.$CFG->wwwroot.'/mod/'.$moduleName.'/view.php" onfocus="this.select();"><br><a href="'.$CFG->wwwroot.'/mod/'.$moduleName.'/view.php?instance='.$return.'" >View Class details</a>';
        	    	$form1->userid=intval($USER->id);
            	   	$form1->modulename="";//"wiziq";
               		$form1->instance=$return;
     		    	$form1->timestart=make_timestamp($year, $month, $day, $hh1, $mm1);
			    	$form1->timeduration=$_REQUEST['duration']*60;
                	$form1->eventtype=$eventtype;
					$form1->format=1;
                	$form1->visible=1;
					$eventid = wiziq_add_event($form1); 
					
		}
		if($eventtype=='user')
		{

			
					$form1->courseid=0;
					$form1->groupid=0;
					$form1->name='<img height="16" width="16" src="'.$CFG->wwwroot.'/mod/'.$moduleName.'/pix/icon.gif" style="vertical-align: middle;"/>'.' '.$name;
				 	$form1->description='<input type="text" value="'.$CFG->wwwroot.'/mod/'.$moduleName.'/view.php" onfocus="this.select();"><br><a href="'.$CFG->wwwroot.'/mod/'.$moduleName.'/view.php?instance='.$return.'" >View Class details</a>';
		            $form1->userid=$USER->id;
		            $form1->modulename="";//"wiziq";
		            $form1->instance=$return;
					$form1->timestart=make_timestamp($year, $month, $day, $hh1, $mm1);
					$form1->timeduration=$_REQUEST['duration']*60;
		            $form1->eventtype=$eventtype;
					$form1->format=1;
		            $form1->visible=1;
					$eventid = wiziq_add_event($form1); 
					
				
		}
		if($eventtype=='group')
		{
				$form1->groupid=$group;
				$form1->courseid=$course->id;
		 		$form1->name='<img height="16" width="16" src="'.$CFG->wwwroot.'/mod/'.$moduleName.'/pix/icon.gif" style="vertical-align: middle;"/>'.' '.$name;
				$form1->description='<input type="text" value="'.$CFG->wwwroot.'/mod/'.$moduleName.'/view.php" onfocus="this.select();"><br><a href="'.$CFG->wwwroot.'/mod/'.$moduleName.'/view.php?instance='.$return.'" >View Class details</a>';
            	$form1->userid=intval($USER->id);
               	$form1->modulename="";//"wiziq";
               	$form1->instance=$return;
     		    $form1->timestart=make_timestamp($year, $month, $day, $hh1, $mm1);
			    $form1->timeduration=$_REQUEST['duration']*60;
                $form1->eventtype=$eventtype;
				$form1->format=1;
                $form1->visible=1;
				$eventid = wiziq_add_event($form1);  
				
		}
rebuild_course_cache($course->id);
                    $SESSION->returnpage = "$CFG->wwwroot/mod/$moduleName/view.php?instance=$return&type=$value";
          
            
            
       

        
            $return = $SESSION->returnpage;
            
          redirect($return);
}
   else{ // if error occured
 $flag="none";

echo ' <script language="javascript" type="text/javascript">
		var chk =  "'.$flag.'" ;
		if(chk == "none")
		{
			document.getElementById("div123").style.display="none";
		}
				
		</script>;  ';
 
	
	$PAGE->set_heading($course->fullname);
    $PAGE->set_title("Error");    
    $PAGE->set_cacheable(false);
    echo $OUTPUT->header();
	
	//print_header("WizIQ class", "");
    
	echo $OUTPUT->box_start('center', '100%');
?>
    <br /><br />
    <p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="5"><strong><img src="pix/icon.gif" hspace="10" height="16" width="16" border="0" alt="" />Error In Scheduling WiZiQ Live Class</strong></font></p><br />
    <?php
    
    echo '<strong><center><font color="red">'.$ErrorMessage.'</font></center></strong><br><br>';
echo'<a href="javascript:history.go(-1)"><p align="center">Click Here To Go Back</p></a>';
    echo $OUTPUT->box_end();
     echo $OUTPUT->footer();
  //  echo("in error this is wat have to check");
 }
?>