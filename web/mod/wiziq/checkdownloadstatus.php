<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Untitled Document</title>
</head>

<body>

<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * This is for checking the download status of recording
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once("wiziqconf.php");
$metaTag="<meta http-equiv='refresh' content='10' />";
$timestamp=strtotime(now);
$XmlPathToPing=$_REQUEST['XmlPathToPing'];
$content = file_get_contents($XmlPathToPing);
	if ($content !== false) {
	   // do something with the content
	   //echo "file is read",$content;
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
	$DownloadStatus=$objDOM->getElementsByTagName("DownloadStatus");
	$DownloadStatus=$DownloadStatus->item(0)->nodeValue;
	$Message=$objDOM->getElementsByTagName("Message");
	$Message=$Message->item(0)->nodeValue;
	if ($DownloadStatus == "true")
        {
			$httpDownloadPath=$objDOM->getElementsByTagName("httpDownloadPath");
	$httpDownloadPath=$httpDownloadPath->item(0)->nodeValue;
	echo '<script language=JavaScript>self.parent.ShowLink(\''.$httpDownloadPath.'\');</script>';
		}
		else
		{
			if(strtolower($Message)=="error in packaging files")
			{
			echo '<script language=JavaScript>self.parent.ShowLink(\'Recording not available.\');</script>';
			}
			else
			{
			echo "<meta http-equiv='refresh' content='10' />";
			echo '<script language=JavaScript>self.parent.ShowLink(\'Recording in progress.\');</script>';
			}
		}
?>
</body>
</html>