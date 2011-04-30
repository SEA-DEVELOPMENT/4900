<head>
<title>Manage Content</title>
<style type="text/css">
.ulink{ text-decoration:underline;}
.ulink:hover{ text-decoration:none;}

</style>
</head>
<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Here Users Package info is shown.
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once("wiziqconf.php");

//------------------reading the users xml file---------------
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

require_once("../../config.php");
require_once("lib.php");
require_once($CFG->dirroot."/course/lib.php");
require_once($CFG->dirroot.'/calendar/lib.php');
require_once($CFG->dirroot.'/mod/forum/lib.php');
require_once ($CFG->dirroot.'/lib/blocklib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');

//---------------getting the package info of moodle admin------------------
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

	    'CustomerKey'=>$customer_key

	);
  $result=do_post_request($WebServiceUrl.'moodle/class/packagedetail',http_build_query($person, '', '&'));

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


	$message=$objDOM->getElementsByTagName("message");
	 $message=$message->item(0)->nodeValue;
	 $status=$objDOM->getElementsByTagName("Status");
	 $status=$status->item(0)->nodeValue;
	 $RecordingCreditsPending=$objDOM->getElementsByTagName("RecordingCreditsPending");
	 $RecordingCreditsPending=$RecordingCreditsPending->item(0)->nodeValue;
	 if(empty($RecordingCreditsPending))
	 $RecordingCreditsPending=0;
	 if($concurrsession==-1)
	 $concurrsession="Unlimited Rooms";
//---------------------showing the package info of admin---------------				
				?>
	       <table width="510px" align="left" cellpadding="0"  cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; text-decoration:none;">

        <tr height="30px" style="background-color:#efefef;">
          <td colspan="3" style="font-size:12px;padding-left:10px; width:160px"><strong>Your Account Statistics:</strong></td>

        </tr>
          <tr height="30px">
          <th  align="center" style="font-size:12px; width:160px; border:solid 1px #efefef; padding-left:10px"><strong>Allotted Room </strong></th>
          <th  align="center" style="font-size:12px;width:160px; border-bottom:solid 1px #efefef;padding-left:10px"><strong>Maximum Participant </strong></th>
          <th  align="center" style="font-size:12px;width:160px; border:solid 1px #efefef;padding-left:10px"><strong>Remaining Recording</strong></th>

        </tr>
         <tr height="28px">
         <td align="center" style="font-size:12px; width:160px; border:solid 1px #efefef; border-top:none;padding-left:10px"><?php echo $concurrsession; ?></td>
         <td align="center" style="font-size:12px;width:160px; border-bottom:solid 1px #efefef; padding-left:10px"><?php echo $maxuser; ?></td>
         <td align="center" style="font-size:12px;width:160px; border:solid 1px #efefef;padding-left:10px; border-top:none"><?php echo $RecordingCreditsPending; ?></td>
         </tr>
<tr><td style="border-top:none"><a href="<?php echo $buynow_url; ?> " target="_blank" class="ulink" style="font-family:Arial, Helvetica, sans-serif;font-size:12px; padding-top:4px;float:left; padding-left:10px; line-height:10px; font-weight:bold">Upgrade Your Account</a>
</td></tr>
    </table>

				<?php
				
				if($RecordingCreditsPending ==0)
				{
				echo '<script language="javascript">
				parent.DisableRecordClass();

				</script>
				';
				}

	?>


