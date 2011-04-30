<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Here request send to api for updating the class details
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once("wiziqconf.php");
//--------------getting the users xnl-----------------
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
	$RecordingCreditPending=$objDOM->getElementsByTagName("RecordingCreditPending");
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

$id=$_REQUEST['eventid'];

$wiziq=$DB->get_record("wiziq",array("id"=>$id));
$sesscode=$wiziq->insescod;
if ($CFG->forcetimezone != 99)
 {
     $tmzone=$CFG->forcetimezone;
 } 
 else
 $tmzone=$USER->timezone; 
// check timezone of user currently logged in
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
//---------------logic for date time string for updation of class---------------
$dur=$_REQUEST['duration'];
$name=$_REQUEST['name'];
$date=$_REQUEST['date'];
$time=$_REQUEST['time'];
$indexof=strrpos($time, ":");
 if($indexof>0)
 {
   
   $mm=intval(substr($time,$indexof+1,2));
 }
 else
 $mm="00";
 $hh=intval(substr($time,0,2));
  $ampm=substr($time,-2);
	                  //$hh=$_REQUEST['hh'];    
             // $mm=$_REQUEST['mm'];
                          // $ampm=$_REQUEST['ampm'];
						   
						$ampm=strtolower($ampm);	
list($month, $day, $year)=split('[/.-]', $date);
 $mm1=intval($mm);
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
				 

 
$wdate=make_timestamp($year, $month, $day, $hh1, $mm1);
//if($hh!="" && $mm!="")
//$time=$hh.":".$mm." ".$ampm; 
if($date!="")
$xyz=$date." ".$time;
else
$xyz="";

 $datetime=strtoupper($xyz);

$usr = $USER->username;
$audio=$_REQUEST['audio'];
					 if($audio=="Video")
                     {
                     $wtype="Audio and Video";
					
                     }
                     if($audio=="Audio")
                     {
                     $wtype="Audio";
					 
                     }

 $recordingtype=$_REQUEST['chkRecording'];

                     
						 if($recordingtype=="yes")
						 {
						 	$value="1";
							
						 }
						 else
					 	{
							 $value="0";
							 
						 }
					 
			if ($CFG->forcetimezone != 99)
 {
     $CountryNameTZ=$CFG->forcetimezone;
 } 
 else
 $CountryNameTZ=$USER->timezone;

// sending the request to api for updating the class			
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
  if(!empty($_REQUEST['old'])&&$_REQUEST['old']=="oldclass")
  {
	$person = array(
		'CustomerKey'=>$customer_key,
		'SessionCode'=>$sesscode,
		'RecodingReplay'=>$recordingtype
  );
	}
  else
  {
$person = array(
				
		'CustomerKey'=>$customer_key,
		'SessionCode'=>$sesscode,
		'EventName' => $name,
	 	'DateTime' => $datetime,
	    'TimeZone' => $timezone,		
	    'Duration' => $dur,
		'RecodingReplay'=>$recordingtype,
		'CountryNameTZ'=>$CountryNameTZ,
		'audio' => $audio
		
	);
  }

$result=do_post_request($WebServiceUrl.'moodle/class/modify',http_build_query($person, '', '&'));
	
   try
	  {
	    $objDOM = new DOMDocument();
	    $objDOM->loadXML($result); 
	  }
	catch(Exception $e)
	  {
		echo $e->getMessage();
	  }
 	
	 $Status=$objDOM->getElementsByTagName("Status");
	 $Status=$Status->item(0)->nodeValue;
	 $message=$objDOM->getElementsByTagName("message");
	 $message=$message->item(0)->nodeValue;
//echo "<br>".$value.$name.$time.$dur.$wdate;	
if($Status=="True") // if it is updated then updating the db
{	

$cmid=$_REQUEST['cmid'];

$str="Class updated successfully";
if(!empty($_REQUEST['old'])&&$_REQUEST['old']=="oldclass")
{
$param=array('id'=>$id,'statusrecording'=>$value);
$DB->update_record('wiziq', $param, $bulk=false);
}
else 
{
$param=array('id'=>$id,'statusrecording'=>$value,'name'=>$name,'wtime'=>$time,'wdur'=>$dur,'wdate'=>$wdate,'wtype'=>$wtype,'timezone'=>$timezone);
$DB->update_record('wiziq', $param, $bulk=false);

$param=array('instance'=>$id ,'name' => '%mod/wiziq/pix/icon.gif%');
$eventquery="select id from {event} where instance=:instance and name like :name";
$eventresult=$DB->get_record_sql($eventquery,$param);

$param1=array('id'=>$eventresult->id,'name'=>'<img height="16" width="16" src="'.$CFG->wwwroot.'/mod/wiziq/pix/icon.gif" style="vertical-align: middle;"/>"  '.$name,'timestart'=>$wdate,'timeduration'=>$dur*60);
$DB->update_record('event', $param1, $bulk=false);
}
//$return="view.php?id=".$cmid."&type=".$value."&str=".$str;
header('Location: view.php?id='.$cmid.'&type='.$value.'&str='.$str);
//redirect("view.php?id=".$cmid."&type=".$value."&str=".$str);
}
else // if error occured
{
	$PAGE->set_heading($course->fullname);
    $PAGE->set_title("Error");    
    
    echo $OUTPUT->header();
	
	//print_header("WizIQ class", "");
    
	//echo $OUTPUT->box_start('center', '100%');
?>

<br /><br /><br />
    <p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="5"><strong><img src="pix/icon.gif" hspace="10" height="16" width="16" border="0" alt="" />Error In Updating WiZiQ Live Class</strong></font></p>
    <?php
	 echo '<strong><center><font color="red">'.$message.'</font></center></strong><br><br>';
echo'<a href="javascript:history.go(-1)"><p align="center">Click Here To Go Back</p></a>';
  // echo $OUTPUT->box_end();
     echo $OUTPUT->footer();
}
	?>