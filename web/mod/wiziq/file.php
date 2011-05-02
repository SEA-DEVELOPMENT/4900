<?php
setcookie("query", $_REQUEST['q']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WiZiQ Content</title>
<style type="text/css">
.ulink{text-decoration:underline; font-weight:bold; font-size:12px}
.ulink:hover{text-decoration:none;font-weight:bold;font-size:12px}
</style>
</head>
<body>
<form id="form1" name="form1" method="post" enctype="multipart/form-data" >
<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * This page is for uploading file content
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once("../../config.php");
require_once("lib.php");
require_once($CFG->dirroot."/course/lib.php");
require_once($CFG->dirroot.'/calendar/lib.php');
require_once($CFG->dirroot.'/mod/forum/lib.php');
require_once ($CFG->dirroot.'/lib/blocklib.php');
require_once ($CFG->dirroot.'/lib/moodlelib.php');
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
	$pagetitle="Upload File";
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
$PAGE->navbar->add('Upload File');

echo $OUTPUT->header();

//echo $renderer->start_layout();

//----------------------------for having role of user------------------------------------
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
<table width="100%" style="border:solid 1px #dedede;position:relative;"><?php if($role==1 || $role==2 || $role==3 ){ ?><tr><td colspan="2"><table width="100%"><tr><th colspan="2" class="header" style="text-align:left;"><span style="float:left; width:80px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px;font-family:Arial, Helvetica, sans-serif;"><img src="pix/icon.gif" align="absbottom"/>&nbsp;WiZiQ</span> <span style="float:left; width:120px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px "><a href="event.php?course=<?php echo $courseid;?>&section=0&add=wiziq">Schedule a Class</a></span><span style="float:left; width:120px;margin-left:20px;  border-right:solid 1px #ddd;font-size:12px "> <a href="wiziq_list.php?course=<?php echo $courseid;?>">Manage Classes</a></span><span style="float:left; width:120px;margin-left:20px; font-size:12px" > <a href="managecontent.php?course=<?php echo $courseid;?>">Manage Content</a></span></th></tr></table></td></tr><?php } ?><tr><td colspan="2">


<table cellspacing="2" cellpadding="2" border="0" width="790" align="left">
 <tr>
 <td valign="top" align="left">
    <table align="left">
     <tr><td  colspan="2" valign="top" align="left" width="50%" style="font-weight:bold;">Upload Content</td>
     <td></td>
     </tr>
     <tr>
 <td style="height:10px"></td>
 <td style="height:10px"><div style="color:red" id="errorMsg"></div> </td>
 </tr>
 <tr>
 <td valign="top" align="left" style="font-weight:bold; font-size:12px; margin-left:30px; float:left"> 
<label for="file" style="width:65px; float:left">Upload File:</label></td>
<td valign="top" align="left"><input type='hidden' name='upProgressID' id='upProgressID' />

        <input type="file" id="fileupload"  name="fileupload" size='40'/>
</td>
</tr>
<tr>
<td style="height:20px"></td>
</tr>
<tr>
<td align="right" style="font-weight:bold;font-size:12px"><label>Title:</label></td>
<td><input type="text" id="txtTitle" name="txtTitle" maxlength="50" style='width:300px'/></td>

</tr><tr>
<td style="height:20px"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><!--<label>Description</label>
<textarea id="txtDesc" name="txtDesc" ></textarea><br />
<br />-->
  <input type="submit" value="Upload" name="btnupload" id="btnupload" onClick="return SubmitUpload(this);" />
 <a href="javascript:history.go(-1)" style="margin-left:13px"><span class="ulink" >Cancel</span></a>
  </td>

</tr>
    
    </table>
    </td>


<td align="center">
<div style="font-size:12px; float:left; margin-left:40px; font-weight:bold; margin-top:35px">Supported file formats and Sizes</div>
<div style="color:#818181;font-size:11px;float:left; margin-left:40px;">
<img src="<?php echo $CFG->wwwroot; ?>/mod/wiziq/images/fileformat.gif" />
 </div>
 </td>
 </tr>


<?php
///------------------Logic for decrypting the encrypted url-------------------
if(empty($alink))
$alink="";
if(!empty($_REQUEST['q']))
{

 parse_str(urldecode(decrypt($_REQUEST['q'])),$_request);

}
$id=$_request['id'];
 $s=$_request['s'];
 if(!empty($s))
 {
$subfolder=$_request['s'];
 $arrayfolder=explode(",",$subfolder);
 $sublevel=sizeof($arrayfolder)-1;
for($i=1;$i<sizeof($arrayfolder);$i++)
 {
	$arraystring=explode("|",$arrayfolder[$i]); 
	if($i<sizeof($arrayfolder)-1)
{
	$a=$arraystring[1];
$alink.=$a.'\\';
}
else
$alink.=$arraystring[1];

 }
 
 }
echo '<input type="hidden" id="folderid" name="folderid" value="'.$alink.'" />';

?>
</table>
</td></tr></table>
 <?php echo $OUTPUT->footer();?>
</form>
<script type="text/javascript" language="javascript">
function SubmitUpload(btn)
        {
			var btnID=btn;
			var check=CallSubmit();
			if(check==true)
			{
				var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";

				for (var i = 0; i < document.getElementById('txtTitle').value.length; i++)
				{
				if (iChars.indexOf(document.getElementById('txtTitle').value.charAt(i)) != -1)
				{
				document.getElementById('errorMsg').innerHTML="Special characters are not allowed.";
				return false;
  				}
  				}
			//var filePath=document.getElementById('fileupload').value;
   			//var fileName=filePath.substr(filePath.lastIndexOf('\\')+1);


			//document.cookie="title=" +title;
			//document.cookie="Desc=" +document.getElementById("txtDesc").value;
            var ts = new Date().getTime();
            //alert("iframe"+document.getElementById('filename').value);
            document.getElementById('upProgressID').value =ts;
			//alert(document.getElementById('upProgressID').value);
            up_UpdateFormAction(btnID);
            //document.forms["form1"].submit();
			document.form1.submit();
			return true;
			}
			else
			return false;
		}
		function CallSubmit()
{


			if(document.getElementById('fileupload').value=="")
			{
				document.getElementById('errorMsg').innerHTML="Choose the file";
				return false;
			}
			else
			{

				var check=checkExtension();
				if(check==0)
				{
					document.getElementById('errorMsg').innerHTML="File type not supported";
					return false;
				}
				 return true;
			}
			return true;
}
 function checkExtension()
    {

        // for mac/linux, else assume windows

        var fileTypes     = new Array('.ppt','.pptx','.jnt','.rtf','.pps','.pdf','.swf','.doc','.xls','.xlsx','.docx','.ppsx','.flv','.mp3','.wmv','.wav','.wma','.mov','.avi','.mpeg'); // valid filetypes
        var fileName      = document.getElementById('fileupload').value; // current value

        var extension     = fileName.substr(fileName.lastIndexOf('.'), fileName.length);

        var valid = 0;

        for(var i in fileTypes)
        {

            if(fileTypes[i].toUpperCase() == extension.toUpperCase())
            {
                valid = 1;
                break;

            }

        }

        return valid;
    }
//var rootUrl="http://192.168.17.57/aGLiveContentAPI/contentmanager.ashx";
//var rootUrl="http://192.168.17.231/aGLiveContentAPI/contentmanager.ashx";
var rootUrl="<?php echo $contentUpload; ?>";

var sessioncode=16326;//26046;

function up_UpdateFormAction(btnID)
{//document.getElementById('upProgressID').value='1281613863469';
    var form = document.forms[0];
    var action = form.action;

    var re = new RegExp('&?UploadID=[^&]*');
    if (action.match(re)) action = action.replace(re, '');

    var delim;

    if (action.indexOf('?') == action.length-1)
    {
         delim = '';
    }
    else
    {
        delim = '?';
        if (action.indexOf('?') > -1) delim = '&';
    }
	var filename=document.getElementById('fileupload').value;
   var fileupload=filename.substr(filename.lastIndexOf('\\')+1);
  var title=document.getElementById("txtTitle").value;
			if(title=='')
			title=fileupload;
var folderid=document.getElementById('folderid').value;
btnID.disabled="disabled";
    form.action = rootUrl+'?method=upload&filename='+fileupload+'&UploadID=' + document.getElementById('upProgressID').value+'&m=o&sessioncode=16326&uc=<?php echo $USER->id; ?>&p='+folderid+'&k=<?php echo $customer_key; ?>&nexturl=<?php echo $CFG->wwwroot ;?>/mod/wiziq/uploadreturn.php?t='+title+'|'+<?php echo $urlcourse; ?>;
 //alert(form.action);

}
</script>





 

