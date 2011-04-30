<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Setting page for moodle activity plugin
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
include('wiziqconf.php'); 
//-------------------------Reading the xml file of user---------------------
$content = file_get_contents($ConfigFile);
           
	if ($content !== false) {
	   
	   //echo "file is read",$content;
	} else {
	  
	   echo "XML file is not read";
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

//-------------------------Reading the html file---------------------
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
$settings->add(new admin_setting_heading('WiZiQ', '', $contentHTML, ''));


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

