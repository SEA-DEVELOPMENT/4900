<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Settings page for moodle blocks 
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
include($CFG->dirroot.'/mod/wiziq/wiziqconf.php'); 
$content = file_get_contents($ConfigFile);
           
	if ($content !== false) {
	   
	   //echo "file is read",$content;
	} else {
	  
	   echo "wwXML file is not read";
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
	
 $contentHTML = file_get_contents($CFG->dirroot."/blocks/wiziqlive/config_global.html");
 	if ($contentHTML !== false) {
	   
	   //echo "file is read",$content;
	} else {
	  
	   echo "XML file is not read";
	}
	
$contentHTML=str_replace( '"#$customer_email#"', $customer_email, $contentHTML );
$contentHTML=str_replace( '"#$customer_key#"', $customer_key, $contentHTML );
$contentHTML=str_replace( '"#$concurrsession#"', $concurrsession, $contentHTML );
$contentHTML=str_replace( '"#$subscription_url#"', $subscription_url, $contentHTML );
$contentHTML=str_replace( '"#$maxuser#"', $maxuser, $contentHTML );
$contentHTML=str_replace( '"#$maxdur#"', $maxdur, $contentHTML );
$contentHTML=str_replace( '"#$recordingcredit#"', $recordingcredit, $contentHTML );
$contentHTML=str_replace( '"#$buynow_url#"', $buynow_url, $contentHTML );
defined('MOODLE_INTERNAL') || die();
$settings->add(new admin_setting_heading('WiZiQ', '',
                         $contentHTML, ''));


if (!isset($CFG->customer_email)) {
        $CFG->customer_email =  $customer_email;
    }
    if (!isset($CFG->customer_key)) {
        $CFG->customer_key =  $customer_key;
    }
    if (!isset($CFG->no_rooms)) {
        $CFG->no_rooms = '5';
    }
    if (!isset($CFG->part_rooms)) {
        $CFG->part_rooms = '15';
    }
    if (!isset($CFG->time_class)) {
        $CFG->time_class = '60';
    }
    if (!isset($CFG->no_recordings)) {
        $CFG->no_recordings = '50';
    }

/*$settings->add(new admin_setting_heading('WiZiQ1', 'Customer Email',
                        "<input type='text' class='moddletxtbox' name='customer_email' value='".$customer_email."'  disabled/><br>The email address your account is registered with WiZiQ.</br> You may change your customer email and the change gets automatically saved in WiZiQ. Your scheduling permissions are validated against this customer email and customer key. Refer this email for all your correspondence with WiZiQ.", $customer_email));

$settings->add(new admin_setting_heading('WiZiQ2', 'Customer Key',
                        '<input type="text" class="moddletxtbox" name="customer_key" value="'.$customer_key.'"  disabled/><br>A unique key assigned to your account. The combination of customer email and customer key is used to validate your scheduling and recording permissions.', ''));

$settings->add(new admin_setting_heading('WiZiQ3', 'Module Configuration',
                        '<iframe  src="../mod/wiziq/package_message.php " id="remote_iframe_1" name="remote_iframe_1" style="border:0;padding:0;margin:0;width:100%;height:80px;overflow:auto" frameborder=1 scrolling="no" onload=" " ></iframe>', ''));

$settings->add(new admin_setting_heading('WiZiQ4', '',
                        'These parameters are specific to your account subscription. They change as and when you upgrade, downgrade or cancel your subscription on WiZiQ.<br /> For upgrade, downgrade or cancellation of a purchased pack please contact <a href="mailto:support@wiziq.com">support@wiziq.com.</a><br><br>Number of rooms- <input type="text" class="moddletxtbox" value="'. $concurrsession .'"  name="no_rooms" disabled/>&nbsp; <a href="'. $subscription_url.'" target="_blank">Change subscription</a><br>This is the maximum number of simultaneous classes that can be scheduled by a user subject to the user permissions set for the course by the course administrator.<br><br>Participants in a room- <input type="text" class="moddletxtbox" value="'. $maxuser.'"  name="part_room" disabled/><br>Maximum number of participants allowed in a class<br><br>Time for a class- <input type="text" class="moddletxtbox" value="'. $maxdur.'"  name="time_class" disabled/><br>Maximum time in minutes for which a class can be scheduled and max extended.<br><br>Number of recordings- <input type="text" class="moddletxtbox" value="'.$recordingcredit .'"  name="no_recordings" disabled/>&nbsp; <a href="'.$buynow_url .'" target="_blank">Purchase more recordings</a><br>Total number of recordings that can be built. All the recordings are hosted max for 12 months from the date of their capture. You may purchase additional credits to build more recordings.', ''));*/