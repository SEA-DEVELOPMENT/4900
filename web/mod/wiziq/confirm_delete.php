<?php
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * Here is the code for confirmation before deleting class
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

$aid=$_REQUEST['aid'];
$insid=$_REQUEST['inst'];
$eid=$_REQUEST['eid'];
$courseid=$_REQUEST['id'];
$type=$_REQUEST['type'];
$sessionkey=$USER->sesskey;
	?>
<div align="center" style="margin-top:20px; margin-bottom:20px; width:550px; height:100px; margin-left:230px; background-color:#FAA; padding-top:20px; padding-left:5px; padding-right:5px; border-color:#DDD; border-width:thin; border-style:solid" ><font face="Arial, Helvetica, sans-serif" color="#020202" size="3"><strong>Are you sure you want to delete WiZiQ live class <?php  echo "'".$peventname."'"; ?>?</strong></font><br />
<div align="center"><font face="Arial, Helvetica, sans-serif" color="#0066CC" size="5"><strong><input type="submit" value="Yes" name="yes" onclick="javascript:location.href='delete_session.php?flag=1&aid=<?php echo $aid; ?>&insid=<?php echo $insid; ?>&eid=<?php echo $eid; ?>&courseid=<?php echo $courseid; ?>&type=<?php echo $type; ?>&course=<?php echo $courseid;?>'" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="No" name="no" onclick="javascript:location.href='wiziq_list.php?course=<?php echo $courseid;?>'"/></strong></font></div>
<input type="hidden" name="aid" value="<?php echo $aid; ?>" />
<input type="hidden" name="insid" value="<?php echo $insid; ?>" />
<input type="hidden" name="eid" value="<?php echo $eid; ?>" />
<input type="hidden" name="courseid" value="<?php echo $courseid; ?>" />
<input type="hidden" name="type" value=""<?php echo $type; ?>  />
<input type="hidden" name="sessionkey" value="<?php echo $USER->sesskey; ?>" />

</div>

