<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Here request send to api for getting the path for download recording
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
    h3{border-bottom:solid 1px #cecece;font-size:14px;font-weight:bold;}
    p{float:left;width:100%;}
    a{text-decoration:underline;}
    a:hover{text-decoration:none}
    </style>
    <script language="javascript" type="text/javascript">
   
        var l=0;//lower value
        var u=10;//upper value
        var IntervalId = 0;
        var divNameOld=null;
        var arrowOld = null;
         var intval="";
         var link=0;
         percentage = 0;
       function create()
        {
            start_Int();
        }
        function GenerateRandomNumber()
        {   
             if ( percentage < 90 )
             {
                percentage=percentage+1;
                document.getElementById('spPercentage').innerHTML=percentage+ "%Complete";
            }
            else
            {
                window.clearInterval(intval);
            }
        }
       
         function start_Int()
           {
               
               if(intval != "")
                {
                  window.clearInterval(intval);
                  intval = "";
                }
                if(intval=="")
                {
                  intval=window.setInterval("GenerateRandomNumber()",1100);
                }

            }
            
    function ShowDiv()
    {
    
        document.getElementById('spPercentage').innerHTML=percentage+ "% Complete";
         document.getElementById('DivInProgress').style.display = 'block';
        document.getElementById('DivSuccessful').style.display = 'none'; 
        document.getElementById('hrefDownloadLink').href = '#';
        //Processing percentage 
        create();
       
    }
    function ShowLink(txt)
    {
     
        ShowDiv();
       if(txt.indexOf("Recording not available")>-1)
        {
            document.getElementById('DivInProgress').style.display = 'none';
            document.getElementById('DivSuccessful').style.display = 'block';
            document.getElementById('spToolTip').style.display = 'none';
            document.getElementById('hrefDownloadLink').style.display = 'none';
            document.getElementById('spMessage').innerHTML=txt;
           
     
        }
        else if(txt.indexOf(".exe")>-1)
        {
			
			
            document.getElementById('DivInProgress').style.display = 'none';
            document.getElementById('DivSuccessful').style.display = 'block';
            document.getElementById('hrefDownloadLink').href = txt;
            
        }
    }
   
      
    </script>

</head>

<body>
    <form id="form1" >
        <div id="DivDownload"  style="width:450px;">
           
            <div id="DivInProgress" >
                    <h3>Build and Download Recording</h3>
                    <div class="s_popudivcontent" >
                        <div class="s_divfrom">
                            <p>Packaging recording...</p>
                            <div style="padding-bottom: 10px">
                                <div style="float: left ;">
                                    <img src="http://org.wiziq.com/Common/Images/loaderwiziq.gif" /></div>
                                <div style="float: left; padding-top: 10px">
                                    <span style="margin-left: 2px;" id="spPercentage"
                                        ></span>
                                </div>
                            </div>
                            <p style="padding-bottom:10px;color:#999; font-size:11px;"">
                                It may take a few seconds, please wait. You may download the recording once it’s
                                complete.
                            </p>
                        </div>
                    </div>
            </div>
            <div id="DivSuccessful" class="s_popupdivinner" style="height:180px;display:none;">
                <div style="float: left; width: 490px;">
                    <h3><strong>Build and Download Recording</strong></h3>
                </div>               
                <div class="s_popudivcontent" >
                    <div class="s_divfrom">
                        <p class="btnyoucontact" style="width: 100%; margin-bottom: 6px;" align="left">
                            <span id="spMessage">The recording has been successfully packaged and is ready for download.</span>
                        </p>
                        <p style="width: 100%; text-align: left; ">
                            <a id="hrefDownloadLink" class="ulink">Download Recording</a>
                        </p>
                        <p style="width: 100%;" align="left">
                            <span class="arialltbox11r999999" id="spToolTip" style="color:#999; font-size:11px;">This downloads a zip file on your computer.
                                Extract the file to play the recording. </span>
                        </p>
                    </div>
                </div>
            </div>
           
        </div>
        <iframe id="frmDownload" scrolling="no" style="width: 10px;
            height: 10px; overflow: hidden; visibility:hidden;" src="#"></iframe>
            <?php
			require_once("../../config.php");
 require_once("lib.php");
  require_once($CFG->dirroot .'/course/lib.php');
 require_once($CFG->dirroot .'/lib/blocklib.php');
require_once($CFG->dirroot.'/calendar/lib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');
require_once("wiziqconf.php");
$sessioncode=$_REQUEST['SessionCode'];
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
$person=array(
			  'SessionCode'=>$sessioncode,
			  'CustomerKey'=>$customer_key
			  );
  $result=do_post_request($WebServiceUrl.'moodle/class/downloadrecording',http_build_query($person, '', '&'));
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
	$Status=$objDOM->getElementsByTagName("Status");
	$Status=$Status->item(0)->nodeValue;
	
	$message=$objDOM->getElementsByTagName("message");
	$message=$message->item(0)->nodeValue;
	
	$XmlPathToPing1=$objDOM->getElementsByTagName("XmlPathToPing");
	$XmlPathToPing=$XmlPathToPing1->item(0)->nodeValue;
	
	if($Status=="False")
	{
	echo '<script language=JavaScript>ShowLink(\'Recording not available.\');</script>'	;
	}
	else if($Status=="True")
	{
		//echo '<script language=JavaScript>document.getElementById("frmDownload").src = "checkdownloadstatus.php?XmlPathToPing=http://122.160.138.84/downloads/633936890662031250.xml";/script>';	
		
	 echo '<script language=JavaScript>
	
	document.getElementById("frmDownload").src = "checkdownloadstatus.php?XmlPathToPing='.$XmlPathToPing.'"</script>';	 
	}
			?>
    </form>
</body>
</html>