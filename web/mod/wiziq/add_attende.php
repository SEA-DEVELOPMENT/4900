

<body>

<?php
 /*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Given for adding attendees while entering in the class
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
require_once("../../config.php");
    	require_once("lib.php");
      	require_once($CFG->dirroot.'/course/lib.php');
    	require_once($CFG->dirroot.'/calendar/lib.php');
		require_once("wiziqconf.php");
		//---------------reading the users xml---------------------------
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
	
	$username=$UserName->item(0)->nodeValue;
	$password=$Password->item(0)->nodeValue;
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
	$SessionCode=$_REQUEST['SessionCode'];
	//------------------logic to check if user is presenter or not for secure login--------------
	$params=array('userid'=>$USER->id,'insescod'=>$SessionCode); 
	$qry="select * from {wiziq_attendee_info} where userid=:userid and insescod=:insescod";
	$rs=$DB->get_record_sql($qry,$params);

    $presenterURL=$rs->attendeeurl;
    $screenName=$rs->username;
if(empty( $presenterURL))
{
	
	$screenName = $USER->username;
	$person=array(
				  
				  'CustomerKey'=>$customer_key,
				  'AttendeeListXML'=>'<AddAttendeeToSession><SessionCode>'.$SessionCode.'</SessionCode><Attendee> <ID>'.$USER->id.'</ID><ScreenName>'.$screenName.'</ScreenName></Attendee></AddAttendeeToSession>'
				  );
	// sending request to add attendee in class when he just enter in the class
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
 $attendeURL=do_post_request($WebServiceUrl.'moodle/class/addattendees',http_build_query($person, '', '&'));

try
{
  $objDOM = new DOMDocument();
  $objDOM->loadXML($attendeURL); 
}
catch(Exception $e)
{
	echo $e->getMessage();
}
//$parent=$objDOM->getElementsByTagName("AddAttendeeToSession");
//$child=$parent->getElementsByTagName("Attendees");

$status = $objDOM->getElementsByTagName("status");
$status= $status->item(0)->nodeValue;
$message = $objDOM->getElementsByTagName("message");
$message= $message->item(0)->nodeValue;
if($status=="true")
{
$gchild=$objDOM->getElementsByTagName("Attendee");
$presenterURL=$gchild->item(0)->getAttribute('Url');	
}
}
if($presenterURL!="" || !empty($presenterURL))
{
	echo '<script language="javascript" type="text/javascript">
	window.location = \''.$presenterURL.'\';
	</script>';


//redirect("view.php?id=".$_REQUEST['id']);

}
else // if error occured
{
	$PAGE->set_heading($course->fullname);
    $PAGE->set_title("Error");    
    $PAGE->set_cacheable(false);
    echo $OUTPUT->header();
	
	//print_header("WizIQ class", "");
    
	echo $OUTPUT->box_start('center', '100%');
?>
    <br /><br /><br />
    <p align="center" ><font face="Arial, Helvetica, sans-serif" color="#000000" size="5"><strong><img src="pix/icon.gif" hspace="10" height="16" width="16" border="0" alt="" />Error In Entering WiZiQ Live Class</strong></font></p>
    <?php
	    
    echo '<strong><center><font color="red">'.$message.'</font></center></strong><br><br>';
//echo'<a href="javascript:history.go(-1)"><p align="center">Click Here To Go Back</p></a>';
  echo $OUTPUT->footer(); 	
}
?>

</body>