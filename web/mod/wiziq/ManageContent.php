<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Manage Content</title>
 <style type="text/css">
.ulink{ text-decoration:underline;}
.ulink:hover{ text-decoration:none;} 
 
</style>   
</head>
<body>
<form action="ManageContent.php" method="post">
<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Here all the content uploaded shown with hierarchy of folders
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once("../../config.php");
 require_once("lib.php");
 require_once($CFG->dirroot .'/course/lib.php');
 require_once($CFG->dirroot .'/lib/blocklib.php');
require_once($CFG->dirroot.'/calendar/lib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');
include("contentPaging.php");
require_once("wiziqconf.php");
require_once("cryptastic.php");

$view = optional_param('view', 'upcoming', PARAM_ALPHA);
$action = optional_param('action', 'new', PARAM_ALPHA);
$id = optional_param('id', 0, PARAM_INT);
$courseid = optional_param('courseid', 0, PARAM_INT);
$instance = optional_param('instance', 0, PARAM_INT);
	
$cal_y = optional_param('cal_y', 0, PARAM_INT);
$cal_m = optional_param('cal_m', 0, PARAM_INT);
$cal_d = optional_param('cal_d', 0, PARAM_INT);

$courseid = optional_param('course', 0, PARAM_INT);
$urlcourse= $courseid;
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
	$pagetitle="Manage Content";
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
$PAGE->navbar->add('Content');
echo $OUTPUT->header();

//echo $renderer->start_layout();
//----------------------for having role of user----------------------
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
<table width="100%" style="border:solid 1px #dedede"><?php if($role==1 || $role==2 || $role==3 ){ ?><tr><td colspan="2"><table width="100%"><tr><th colspan="2" class="header" style="text-align:left;"><span style="float:left; width:80px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px;font-family:Arial, Helvetica, sans-serif;"><img src="pix/icon.gif" align="absbottom"/>&nbsp;WiZiQ</span> <span style="float:left; width:120px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px "><a href="event.php?course=<?php echo $courseid;?>&section=0&add=wiziq">Schedule a Class</a></span><span style="float:left; width:120px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px "> <a href="wiziq_list.php?course=<?php echo $courseid;?>">Manage Classes</a></span><span style="float:left; width:120px;margin-left:20px; font-size:12px" > <a href="managecontent.php?course=<?php echo $courseid;?>">Manage Content</a></span></th></tr></table></td></tr><?php } ?><tr><td colspan="2">

   <table cellspacing="3" cellpadding="3" border="0" align="left" style="font-size:14px;font-family:Arial,Verdana,Helvetica,sans-serif;" width="100%">
    <tr>
      <td align="left" valign="top">
        <table class="files" border="0" cellpadding="2" cellspacing="2" width="100%"  style="border-bottom:solid 1px #ddd; margin-bottom:10px; padding:0px">
  <tr><td valign="top" align="left" style="font-size:14px; font-weight:bold">Manage Content
    <input type="hidden" name="refreshCount" id="refreshCount" value=""/></td></tr>
    <tr><td valign="top" height="15px"></td></tr>
    <tr>
    <th scope="col" class="header name"  width="330" style="padding-left:10px; font-size:12px; text-align:left">Name</th>
    <th scope="col" class="header size"  valign="top" width="180" style="font-size:12px; text-align:left" >Status
     <?php

	 $url=curPageURL(); 
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
     	<a href="<?php echo curPageURL(); ?>" id="hrefRefresh"><img src="images/refresh.jpg" alt="Refresh" title="Refresh"/></a>
	 <?php } else { ?>
     	<a href="<?php echo curPageURL()."&refresh=1"; ?>" id="hrefRefresh"><img src="images/refresh.jpg" alt="Refresh" title="Refresh"/></a><?php }?>
    </th><th scope="col" width="150" class="header commands" style="font-size:12px; ">Action</th>
    </tr>
<?php
//$_request=array();

//echo curPageURL();
if(empty($delstr))
$delstr="";
if(!empty($_REQUEST['q']))
{
 parse_str(urldecode(decrypt($_REQUEST['q'])),$_request);

}
	 //--------------getting the current page url---------------------
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
//---------------logic to show the subfolders in parent folder upto level 3-----------------
$sublevel=1; // initializing the first level of folders hierarchy
$subfolder="0|Content";
if(!empty($_request['s']))
{

$subfolder=$_request['s'];
 $arrayfolder=explode(",",$subfolder);
 //print_r($arrayfolder);
$sublevel=sizeof($arrayfolder)-1;
for($i=0;$i<sizeof($arrayfolder);$i++)
 {
	 
if(!empty($_subfolder))
	 $_subfolder=$_subfolder.",".$arrayfolder[$i];
else
$_subfolder=$arrayfolder[$i];

	$arraystring=explode("|",$arrayfolder[$i]); 
 $delstr='id='.$arraystring[0].'&s='.$_subfolder;	

if($i<sizeof($arrayfolder)-1)
{
	$msg='id='.$arraystring[0].'&s='.$_subfolder;
	$str =urlencode(encrypt(urlencode($msg)));
	$alink='<a href="managecontent.php?q='.$str.'&course='.$urlcourse.'">'.$arraystring[1].'</a>';
    $alink=$alink.'>>';
}
else
$alink=$arraystring[1];
echo $alink;
 }
}
if(!empty($delstr))
$delstr=urlencode(encrypt(urlencode($delstr)));

if(!empty($_request['id']))
{
$id=$_request['id'];
}
else 
$id=0;
if($id==0)
{
$_SESSION['folderSubLevel']=1;	
}

//--------------------------end----------------------------

//---------------------create folder logic----------------------
if(!empty($_POST['btnCreateFolder'])&&$_POST['btnCreateFolder'])
{
$foldername=$_REQUEST['txtFolder'];

$params=array('name'=>$foldername,'userid'=>$USER->id,'isdeleted'=>'0');
$folderResult=$DB->count_records('wiziq_content', $params);

if($folderResult>0)
{
	$errorMsg="This Folder Name is already in use";
	
}
else
{
      $wiziq->name=$foldername;
	  $wiziq->title="folder";
	  $wiziq->description="";
	  $wiziq->type=1;
	  $wiziq->uploaddatetime=time();
	  $wiziq->userid=$USER->id;
	  $filepath="";//'<a href="ManageContent.php?parentid='.$parentid.'">'.$_REQUEST['parentfoldername'].'</a>/';
	  $wiziq->filepath=$filepath;
	  $wiziq->parentid=$id;
	  $DB->insert_record("wiziq_content", $wiziq);	
}
}

$limit=10; //setting the limit to show content per page

$params=array('userid'=>$USER->id,'parentid'=>$id,'isdeleted'=>'0'); //getting the content uploaded
$query="select * from {wiziq_content} where userid=:userid and parentid=:parentid and isDeleted=:isdeleted order by parentid, filepath, name";	
//}
$query=paging_1($query,"","0%",$params);

//-------------------------- REFRESH CODE ---------------------------------
if(!empty($_REQUEST['refresh'])&&$_REQUEST['refresh']==1)
{
$refreshParams=array('userid'=>$USER->id,'parentid'=>$id);	
$refreshQuery="select * from {wiziq_content} where userid=:userid and parentid=:parentid and isDeleted=0 and status=1 and type=2";
$contentTableID=array();
$countID=1;
$contenExist=0;
$resultRefresh=$DB->get_records_sql($refreshQuery,$refreshParams);
foreach($resultRefresh as $refreshItem)
{
	if(!empty($refreshItem))
	$contenExist=1;
	    //$resultset=mysql_data_seek($resultRefresh,$i);
		//$resultset=mysql_fetch_assoc($resultRefresh);
		$cids=$cids.",".$refreshItem->contentid;
		$contentTableID[$countID]=$refreshItem->id;
		$countID++;
}
 $cids=trim($cids,",");
	
	if($contenExist==1)
	{    //reading the content info which is uploaded 
		 $content = file_get_contents($contentUpload.'?method=contentconversionstatus&cids='.$cids.'');
		
		try
			{
			 $objDOM = new DOMDocument();
			 $objDOM->loadXML($content); 
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		$contentTable= $objDOM->getElementsByTagName("content");	
		$length =$contentTable->length;
		$count=1;
		foreach( $contentTable as $value )
		  {
			  
			//  $j=1;
		$conid = $value->getElementsByTagName("id");
		 $conid= $conid->item(0)->nodeValue;
		//$statusXMLarray[$i][$j]=$conid;  
		
		$stat = $value->getElementsByTagName("stat");
		 $stat= $stat->item(0)->nodeValue;
		//$statusXMLarray[$i][$j+1]=$stat;
		//$i++;
		$contentIdToUpdate=$contentTableID[$count];
		$paramUpdate=array('id'=>$contentIdToUpdate,'status'=>$stat);
		//$sqlStatement='update {wiziq_content} set status=:status where id=:id';
		$DB->update_record('wiziq_content', $paramUpdate, $bulk=false);
		//mysql_query($sqlStatement) or die("can not update");
		  $count++;
		  }
     
	}
//print_r($statusXMLarray);
}
$params=array('userid'=>$USER->id,'parentid'=>$id,'isdeleted'=>'0'); 
$totalContents=$DB->count_records('wiziq_content',$params);
$result=$DB->get_records_sql($query,$params);

//mysql_query($query) or die("fail to get records");
if(!empty($totalContents))
{
foreach($result as $contentArray)
{
	
	//$resultset=mysql_data_seek($result,$i);
	//$resultset=mysql_fetch_assoc($result);
if($contentArray->type==2) //file
{
?>
<tr class="folder"><td align="left" width="330" class="name" style="white-space: nowrap;padding:0 0 10px 10px"><?php echo "<img src=\"images/".$contentArray->icon."\" /> ".$contentArray->title; ?>
<?php
}
else if($contentArray->type==1) //folder
{
?>

<tr class="folder">

<td align="left" class="name" width="330" style="white-space: nowrap;padding:0 0 10px 10px"><?php 
$msgtable='id='.$contentArray->id.'&s='.$subfolder.','.$contentArray->id.'|'.$contentArray->name;
	 $strtable =urlencode(encrypt(urlencode($msgtable)));
echo "<img src=\" ".$OUTPUT->pix_url('f/folder')."\"  />"." <a href=\"ManageContent.php?q=".$strtable."&course=".$urlcourse."\"  >". $contentArray->name."</a>"	;
}
?></td><td width="180px" valign="top" style="padding:0 0 10px 7px"><?php  
     if(!empty($_REQUEST['currenttotal']))
	 $currenttotal=$_REQUEST['currenttotal'];
	 if(!empty($_REQUEST['offset']))
	 $offset=$_REQUEST['offset'];
		 if($contentArray->type==2) //file
		 {
		  	  if($contentArray->status==3)
			  echo 'Not Available';
			  else if ($contentArray->status==2)
			  echo 'Available';
			  else
			  echo 'InProgress';
			 
		 }
		  ?></td><td class="commands" width="140px" align="center" style="font-size:12px;padding:0 0 10px 0px"><?php if($contentArray->type==2){ ?>
     	<a href="deleteobject.php?<?php echo  "id=".$contentArray->id."&contentid=".$contentArray->contentid."&q=".$delstr."&offset=".$offset."&currenttotal=".$currenttotal."&course=".$urlcourse; ?>" id="hrefDelete">Delete</a><?php } else if($contentArray->type==1){ ?><a href="deleteobject.php?<?php echo "folderid=".$contentArray->id."&q=".$delstr."&offset=".$offset."&currenttotal=".$currenttotal."&course=".$urlcourse; ?>" id="hrefDelete">Delete</a><?php } ?> </td></tr>
<?php

}
}
else
{
?>
<tr><td colspan="3"><center>No files in this folder</center><br /><a href="javascript:history.go(-1)"><p align="center">Click Here To Go Back</p></a></td></tr>
<?php
}
?>

</table>

<table cellspacing="2" cellpadding="2" border="0" width="640">
<tr><td>
<?php
$createid='id='.$id.'&s='.$subfolder;
	 $strcreate =urlencode(encrypt(urlencode($createid)));
if($sublevel<=2)
{
	
?>
 <div style="color:red" id="errorMsg"><?php if(!empty($errorMsg)) { echo $errorMsg; } ?></div>     

<input type="text" id="txtFolder" name="txtFolder" maxlength="20"/> &nbsp; &nbsp; &nbsp;<input type="submit" id="btnCreateFolder" name="btnCreateFolder" value="Make Folder" onclick="return submitForm('<?php echo $strcreate; ?>','<?php echo $urlcourse; ?>');"/>&nbsp; &nbsp; &nbsp; 

<?php
}
?>
<a href="file.php?q=<?php echo $strcreate; ?>&course=<?php echo $urlcourse; ?>">Upload File</a></td>
<td >
<?php
$str=""; // footer of paging
paging_2($str,"0%",$strcreate);?>
</td></tr>
</table>

</td></tr>
 </table></td></tr></table>


<?php
 echo $OUTPUT->footer();	?>

</form>
</body>
<script type="text/javascript">
function submitForm(id,courseid)
{
	//alert(id+','+s);
	if(document.getElementById('txtFolder').value=="")
	{
	document.getElementById('errorMsg').innerHTML="Enter folder name";	
	return false;
	}
	
	var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";

  for (var i = 0; i < document.getElementById('txtFolder').value.length; i++) {
  	if (iChars.indexOf(document.getElementById('txtFolder').value.charAt(i)) != -1) {
  	document.getElementById('errorMsg').innerHTML="Special characters are not allowed.";
  	return false;
  	}
  }
	 var form = document.forms[0];
    var action = form.action; 
	
	action=action+'?q='+id+'&course='+courseid;
	
  form.action =action;
  return true;
}
function refreshlink()
{
var currentPageUrl=location.href;
document.getElementById('refreshCount').value="1";
document.getElementById('hrefRefresh').href=currentPageUrl;
}
</script>
</html>