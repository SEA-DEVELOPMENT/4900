<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * This page is container of scheduling page 
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 require_once('../../config.php');
    require_once($CFG->dirroot.'/calendar/lib.php');
    require_once($CFG->dirroot.'/course/lib.php');
    require_once($CFG->dirroot.'/mod/forum/lib.php');
      require_once("lib.php");
		require_once("wiziqconf.php");
		
//$id            = required_param('id', PARAM_INT);
    $section       = required_param('section', PARAM_INT);
	$sectionreturn = optional_param('sr', '', PARAM_INT);
    $add           = optional_param('add','', PARAM_ALPHA);
    $courseid = optional_param('course', 0, PARAM_INT);
	$course        = optional_param('course', 0, PARAM_INT);
    $indent        = optional_param('indent', 0, PARAM_INT);
    $update        = optional_param('update', 0, PARAM_INT);
    $hide          = optional_param('hide', 0, PARAM_INT);
    $show          = optional_param('show', 0, PARAM_INT);
    $copy          = optional_param('copy', 0, PARAM_INT);
    $moveto        = optional_param('moveto', 0, PARAM_INT);
    $movetosection = optional_param('movetosection', 0, PARAM_INT);
    $delete        = optional_param('delete', 0, PARAM_INT);
   
    $groupmode     = optional_param('groupmode', -1, PARAM_INT);
    $duplicate     = optional_param('duplicate', 0, PARAM_INT);
    $cancel        = optional_param('cancel', 0, PARAM_BOOL);
    $cancelcopy    = optional_param('cancelcopy', 0, PARAM_BOOL);

   // $action = required_param('action', PARAM_ALPHA);
    $eventid = optional_param('id', 0, PARAM_INT);
    $eventtype = optional_param('type', 'select', PARAM_ALPHA);
    $urlcourse = optional_param('course', 0, PARAM_INT);
$cal_y = optional_param('cal_y', 0, PARAM_INT);
$cal_m = optional_param('cal_m', 0, PARAM_INT);
$cal_d = optional_param('cal_d', 0, PARAM_INT);
	
$url = new moodle_url('/calendar/event.php');
    
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
   // If a course has been supplied in the URL, change the filters to show that one// iam taking from table wiziq
   
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

require_login($course,false);
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
    // printing the page title and header.
$strwiziqs = get_string("modulenameplural", "wiziq");
$strwiziq  = get_string("WiZiQ", "wiziq");
$pagetitle="Schedule Class";
    //$prefsbutton = calendar_preferences_button();
$PAGE->set_title("$site->shortname: $strwiziqs: $pagetitle");
$PAGE->set_heading($COURSE->fullname);
//$PAGE->set_button($prefsbutton);
$PAGE->set_pagelayout('admin');
$renderer = $PAGE->get_renderer('core_calendar');
//$calendar->add_sidecalendar_blocks($renderer, true);
$PAGE->navbar->add($COURSE->fullname, new moodle_url('../../course/view.php?id='.$courseid));
$PAGE->navbar->add($strwiziqs, new moodle_url('../../mod/wiziq/index.php?course='.$courseid));
$PAGE->navbar->add('Schedule Class');
echo $OUTPUT->header();
echo $renderer->start_layout();
$action="new";
echo '<style>
.m_12b585858{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
text-decoration:none;
font-weight:bold;
color:#323232;
padding-right:10px;

}
.m_12b{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
text-decoration:none;
color:#333;
padding-right:10px;
}
.Layer1 {
	position:absolute;
	width:36px;
	height:21px;
	z-index:1;
	left: 333px;
	top: 143px;
}
.button{
       font-family:Arial;
	   font-size:11px;
	   color:#333333;
	   background-color:#999999;
	   font-weight:bold;
	   border:#FFFFFF 1px solid;
	   cursor:pointer;
	   height:40px;
}
.perror{
    
	font-family:Arial, Helvetica, sans-serif;
	
	font-weight:normal;
	color:#FF0000;
}
.error{
      
	font-family:Arial, Helvetica, sans-serif;
	
	font-weight:normal;
	color:#FF0000;
}
.ulink{text-decoration:underline; font-weight:bold; font-size:12px}
.ulink:hover{text-decoration:none;font-weight:bold;font-size:12px}
.m_textinput{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
text-decoration: none;
font-weight:normal;
color:#666666;
height:20px;
border-style:solid;
border-width:1px;
border-color:#CCCCCC;
width:270px;
padding-top:3px;
}
</style>
	
<script language="JavaScript">
function chkScheduleNow(element)
{
	if(element.checked==true)
	{
	
	document.getElementById("date").disabled="disabled";
	document.getElementById("time").disabled="disabled";
	document.getElementById("rowDate").style.display = "none";
	document.getElementById("rowTime").style.display = "none";

	}
	else if(element.checked==false)
	{
	document.getElementById("date").disabled="";
	document.getElementById("time").disabled="";
	document.getElementById("rowDate").style.display = "";
	document.getElementById("rowTime").style.display = "";


	}

}
function DisableRecordClass()
{
	document.getElementById("yes").disabled="disabled";
	document.getElementById("no").disabled="disabled";
}
</script>
		<script language="JavaScript">
		// Title: Tigra Calendar
// URL: http://www.softcomplex.com/products/tigra_calendar/
// Version: 3.3 (American date format)
// Date: 09/01/2005 (mm/dd/yyyy)
// Note: Permission given to use this script in ANY kind of applications if
//    header lines are left unchanged.
// Note: Script consists of two files: calendar?.js and calendar.html

// if two digit year input dates after this year considered 20 century.
var NUM_CENTYEAR = 30;
// is time input control required by default
var BUL_TIMECOMPONENT = false;
// are year scrolling buttons required by default
var BUL_YEARSCROLL = true;

var calendars = [];
var RE_NUM = /^\-?\d+$/;

function calendar2(obj_target) {

	// assigning methods
	this.gen_date = cal_gen_date2;
	this.gen_time = cal_gen_time2;
	this.gen_tsmp = cal_gen_tsmp2;
	this.prs_date = cal_prs_date2;
	this.prs_time = cal_prs_time2;
	this.prs_tsmp = cal_prs_tsmp2;
	this.popup    = cal_popup2;

	// validate input parameters
	if (!obj_target)
		return cal_error("Error calling the calendar: no target control specified");
	if (obj_target.value == null)
		return cal_error("Error calling the calendar: parameter specified is not valid target control");
	this.target = obj_target;
	this.time_comp = BUL_TIMECOMPONENT;
	this.year_scroll = BUL_YEARSCROLL;
	
	// register in global collections
	this.id = calendars.length;
	calendars[this.id] = this;
}

function cal_popup2 (str_datetime) {
	if (str_datetime) {
		this.dt_current = this.prs_tsmp(str_datetime);
	}
	else {
		this.dt_current = this.prs_tsmp(this.target.value);
		this.dt_selected = this.dt_current;
	}
	if (!this.dt_current) return;

	var obj_calwindow = window.open(
		"calendar.html?datetime=" + this.dt_current.valueOf()+ "&id=" + this.id,
		"Calendar", "width=230,height="+(this.time_comp ? 315 : 250)+
		",status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes"
	);
	obj_calwindow.opener = window;
	obj_calwindow.focus();
}

// timestamp generating function
function cal_gen_tsmp2 (dt_datetime) {
	return(this.gen_date(dt_datetime) + " " + this.gen_time(dt_datetime));
}

// date generating function
function cal_gen_date2 (dt_datetime) {
	return (
		(dt_datetime.getMonth() < 9 ? "0" : "") + (dt_datetime.getMonth() + 1) + "/"
		+ (dt_datetime.getDate() < 10 ? "0" : "") + dt_datetime.getDate() + "/"
		+ dt_datetime.getFullYear()
	);
}
// time generating function
function cal_gen_time2 (dt_datetime) {
	return (
		(dt_datetime.getHours() < 10 ? "0" : "") + dt_datetime.getHours() + ":"
		+ (dt_datetime.getMinutes() < 10 ? "0" : "") + (dt_datetime.getMinutes()) + ":"
		+ (dt_datetime.getSeconds() < 10 ? "0" : "") + (dt_datetime.getSeconds())
	);
}

// timestamp parsing function
function cal_prs_tsmp2 (str_datetime) {
	// if no parameter specified return current timestamp
	if (!str_datetime)
		return (new Date());

	// if positive integer treat as milliseconds from epoch
	if (RE_NUM.exec(str_datetime))
		return new Date(str_datetime);
		
	// else treat as date in string format
	var arr_datetime = str_datetime.split(" ");
	return this.prs_time(arr_datetime[1], this.prs_date(arr_datetime[0]));
}

// date parsing function
function cal_prs_date2 (str_date) {

	var arr_date = str_date.split("/");

	if (arr_date.length != 3) return alert ("Invalid date format: \'" + str_date + "\'.\nFormat accepted is dd-mm-yyyy.");
	if (!arr_date[1]) return alert ("Invalid date format: \'" + str_date + "\'.\nNo day of month value can be found.");
	if (!RE_NUM.exec(arr_date[1])) return alert ("Invalid day of month value: \'" + arr_date[1] + "\'.\nAllowed values are unsigned integers.");
	if (!arr_date[0]) return alert ("Invalid date format: \'" + str_date + "\'.\nNo month value can be found.");
	if (!RE_NUM.exec(arr_date[0])) return alert ("Invalid month value: \'" + arr_date[0] + "\'.\nAllowed values are unsigned integers.");
	if (!arr_date[2]) return alert ("Invalid date format: \'" + str_date + "\'.\nNo year value can be found.");
	if (!RE_NUM.exec(arr_date[2])) return alert ("Invalid year value: \'" + arr_date[2] + "\'.\nAllowed values are unsigned integers.");

	var dt_date = new Date();
	dt_date.setDate(1);

	if (arr_date[0] < 1 || arr_date[0] > 12) return alert ("Invalid month value: \'" + arr_date[0] + "\'.\nAllowed range is 01-12.");
	dt_date.setMonth(arr_date[0]-1);
	 
	if (arr_date[2] < 100) arr_date[2] = Number(arr_date[2]) + (arr_date[2] < NUM_CENTYEAR ? 2000 : 1900);
	dt_date.setFullYear(arr_date[2]);

	var dt_numdays = new Date(arr_date[2], arr_date[0], 0);
	dt_date.setDate(arr_date[1]);
	if (dt_date.getMonth() != (arr_date[0]-1)) return alert ("Invalid day of month value: \'" + arr_date[1] + "\'.\nAllowed range is 01-"+dt_numdays.getDate()+".");

	return (dt_date)
}

// time parsing function
function cal_prs_time2 (str_time, dt_date) {

	if (!dt_date) return null;
	var arr_time = String(str_time ? str_time : "").split(":");

	if (!arr_time[0]) dt_date.setHours(0);
	else if (RE_NUM.exec(arr_time[0])) 
		if (arr_time[0] < 24) dt_date.setHours(arr_time[0]);
		else return cal_error ("Invalid hours value: \'" + arr_time[0] + "\'.\nAllowed range is 00-23.");
	else return cal_error ("Invalid hours value: \'" + arr_time[0] + "\'.\nAllowed values are unsigned integers.");
	
	if (!arr_time[1]) dt_date.setMinutes(0);
	else if (RE_NUM.exec(arr_time[1]))
		if (arr_time[1] < 60) dt_date.setMinutes(arr_time[1]);
		else return cal_error ("Invalid minutes value: \'" + arr_time[1] + "\'.\nAllowed range is 00-59.");
	else return cal_error ("Invalid minutes value: \'" + arr_time[1] + "\'.\nAllowed values are unsigned integers.");

	if (!arr_time[2]) dt_date.setSeconds(0);
	else if (RE_NUM.exec(arr_time[2]))
		if (arr_time[2] < 60) dt_date.setSeconds(arr_time[2]);
		else return cal_error ("Invalid seconds value: \'" + arr_time[2] + "\'.\nAllowed range is 00-59.");
	else return cal_error ("Invalid seconds value: \'" + arr_time[2] + "\'.\nAllowed values are unsigned integers.");

	dt_date.setMilliseconds(0);
	return dt_date;
}

function cal_error (str_message) {
	alert (str_message);
	return null;
}

		//var cal2 = new calendar2(document.forms["form"].elements["id_date"]);
			//	cal2.year_scroll = false;
				//cal2.time_comp = false;
					</script>
<script language = "Javascript">
// Declaring valid date character, minimum year and maximum year
var dtCh= "/";
var minYear=1900;
var maxYear=2100;

function isInteger(s){
	var i;
    for (i = 0; i < s.length; i++){   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag){
	var i;
    var returnString = "";
    // Search through strings characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++){   
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function daysInFebruary (year){
	// February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
	for (var i = 1; i <= n; i++) {
		this[i] = 31
		if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
		if (i==2) {this[i] = 29}
   } 
   return this
}

function isDate(dtStr){
	var daysInMonth = DaysArray(12)
	var pos1=dtStr.indexOf(dtCh)
	var pos2=dtStr.indexOf(dtCh,pos1+1)
	var strMonth=dtStr.substring(0,pos1)
	var strDay=dtStr.substring(pos1+1,pos2)
	var strYear=dtStr.substring(pos2+1)
	strYr=strYear
	if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
	if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
	for (var i = 1; i <= 3; i++) {
		if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
	}
	month=parseInt(strMonth)
	day=parseInt(strDay)
	year=parseInt(strYr)
	if (pos1==-1 || pos2==-1){
		alert("The date format should be : mm/dd/yyyy")
		return false
	}
	if (strMonth.length<1 || month<1 || month>12){
		alert("Please enter a valid month")
		return false
	}
	if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
		alert("Please enter a valid day")
		return false
	}
	if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
		alert("Please enter a valid 4 digit year between "+minYear+" and "+maxYear)
		return false
	}
	if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
		alert("Please enter a valid date")
		return false
	}

}

String.prototype.cutspace = function()
		{
		return this.replace(/(^\s*)|(\s*$)/g, "");
		}
function ValidateForm(element)
{
	var dt=element;
	var timeUser=document.getElementById("time").value;
	if(timeUser!="")
	{
		
		
		timeUser=timeUser.cutspace();
		var Length=timeUser.length;
		var ampm=timeUser.substring((Length-2));
		ampm=ampm.toUpperCase();
		var Time=timeUser.substring(0,(Length-2))
		Time=Time.cutspace();
		var index=Time.indexOf(":");
		var hh="";
		if(index>0)
		{
		hh=Time.substring(0,index);
		if(hh<10)
		hh="0"+parseInt(hh)+Time.substring(index);
		else
		hh=parseInt(hh)+Time.substring(index);
		}
		else
		{
		if(hh<10)
		hh="0"+Time+":00"	
		else
		hh=Time+":00"	
		}
		//alert(hh);
		var UserDateTime=element.value+" "+hh+" "+ampm;
		//alert(UserDateTime);
		var MoodleDateTime=document.getElementById("MoodleDateTime").value;
		
		var Date1 = new Date(MoodleDateTime);
		var Date2 = new Date(UserDateTime);
		//alert(Date1+">"+Date2);
		 if (Date2 < Date1)
		 {
			return false;
		 }
		
	}

	if (isDate(dt.value)==false)
	{
		dt.focus()
		return false
	}
	
   
 }
 
function IsValidTime(time) {
	var _qfMsg=""; 
	var timeStr=time.value;
if(time.disabled=="")
{
	
	if(timeStr=="")
	{
	_qfMsg ="Please enter the time ";
		
	return qf_errorHandler(time, _qfMsg);	
	}
	else if(timeStr != "")
	{
		
	var timePat = /^((([0-1][0-2]|[1-9]|[0-0][1-9]):([0-5][0-9]))|([0-1][0-2]|[1-9]))((am|pm)|(AM|PM)|( AM| PM)|( am| pm))$/;
	
	var matchArray = timeStr.match(timePat);
	if (matchArray == null)
	{
	_qfMsg ="Please enter the correct format of time ";
	
	return qf_errorHandler(time, _qfMsg);
	}
	else 
	{
	clearMessage("id_error_time");
		        return true;	
	}
}
 
}
else
{
	return true;
}
}


//<![CDATA[



function qf_errorHandler(element, _qfMsg) {
  div = element.parentNode;
 
  if (_qfMsg != "") {
    var errorSpan = document.getElementById("id_error_"+element.name);
    if (!errorSpan) {
      errorSpan = document.createElement("span");
      errorSpan.id = "id_error_"+element.name;
      errorSpan.className = "perror";
     // element.parentNode.insertBefore(errorSpan, element.parentNode.firstChild);
	 element.parentNode.appendChild(errorSpan);

    }

    while (errorSpan.firstChild) {
      errorSpan.removeChild(errorSpan.firstChild);
    }

    errorSpan.appendChild(document.createTextNode(_qfMsg));
    errorSpan.appendChild(document.createElement("br"));

   // if (div.className.substr(div.className.length - 6, 6) != " error"
//        && div.className != "error") {
//      div.className += " perror";
//    }

    return false;
  } else {
    var errorSpan = document.getElementById("id_error_"+element.name);
    if (errorSpan) {
      errorSpan.parentNode.removeChild(errorSpan);
    }

    if (div.className.substr(div.className.length - 6, 6) == " error") {
      div.className = div.className.substr(0, div.className.length - 6);
    } else if (div.className == "error") {
      div.className = "";
    }

    return true;
  }
}
function validate_mod_wiki_mod_form_name(element) {
 var _qfMsg=""; 
var value=element.value;

  if (value == "") {
   
    _qfMsg ="Please enter class title";
 return qf_errorHandler(element, _qfMsg);
  }
else if(value != "")
{
	clearMessage("id_error_name");
		        return true;	
}
  
}

function validate_mod_wiki_mod_form_duration(element) {
var maxdur=document.getElementById("maxDuration").value;

 var _qfMsg=""; 
var value=element.value;

 
  if (value == "") {
    
    _qfMsg ="Please enter duration";
 return qf_errorHandler(element, _qfMsg);
  }

  else if(value != "")
{
	if (isNaN(value)) 
	{
		_qfMsg="Please enter duration in numeric only";
         return qf_errorHandler(element, _qfMsg);
    }
	else
	{
		
		if(value>=30 && value <=parseInt(maxdur))
		{
			clearMessage("id_error_duration");
		return true;
		
		}
		else
		{
		_qfMsg ="Please enter duration between 30 and "+maxdur;
		return qf_errorHandler(element, _qfMsg);		
		}
			
	}
}
}


function validate_mod_wiki_mod_form_date(element) {
var _qfMsg="";
var emailID=element;

if(element.disabled=="")
{
	if (emailID.value=="")
	{		
		_qfMsg ="Please enter the date ";
 		return qf_errorHandler(element, _qfMsg);
	}
	else if(emailID.value != "")
    {

		if (ValidateForm(emailID)==false)
		{
			_qfMsg ="Date/time cannot be less than the current date/time ";
			 return qf_errorHandler(element, _qfMsg);		
		}
		else 
		{
		clearMessage("id_error_date");
		return true;	
		}
		 
   }
}
else
{	
	return true;
}

}
 
function clearMessage(elementID)
{
	if(document.getElementById(elementID))
		document.getElementById(elementID).innerHTML="";	
}

function GroupEnable(selected)
{
	if(selected.options[selected.selectedIndex].value=="group")
	{
	document.getElementById("Groups").disabled="";
	}
    else
	document.getElementById("Groups").disabled="disabled";
}

function GroupSelected()
{
	var selected=document.getElementById("eventType");
	var IsGroupSelected=false;
	if(selected.options[selected.selectedIndex].value=="group")
	{
		var i;
		if(document.getElementById("Groups").options[document.getElementById("Groups").selectedIndex].value!=-1)
		{
		   IsGroupSelected=true;
		   clearMessage("id_error_Groups");
		   return IsGroupSelected;
		}
		
		if(IsGroupSelected==false)
		{
		_qfMsg ="Please select the group";
			 return qf_errorHandler(document.getElementById("Groups"), _qfMsg);	
		}
		
	}
	else
		{
		clearMessage("id_error_Groups");
		return true;
		}
}


function validate_mod_wiki_mod_form() {


		var isNameValid = validate_mod_wiki_mod_form_name(document.getElementById("name"));
		//alert("isNameValid"+isNameValid);
  		var isDateValid = validate_mod_wiki_mod_form_date(document.getElementById("date"));
		//alert("isDateValid"+isDateValid);
		
	    var isTimeValid = IsValidTime(document.getElementById("time"));
		//alert("isTimeValid"+isTimeValid)
	    var isDurationValid = validate_mod_wiki_mod_form_duration(document.getElementById("duration"));
      //  alert("isDurationValid"+isDurationValid);
		var isGroupSelected=GroupSelected();
		
 	return (isNameValid && isDateValid && isTimeValid && isDurationValid && isGroupSelected);
}
//]]>

</script>';	
    include('mode1.html'); //including the html file for scheduling page
				

   echo $OUTPUT->footer();





?>
