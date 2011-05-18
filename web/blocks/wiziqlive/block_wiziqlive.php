
<?php 
/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ�s web based virtual classroom equipped with real-time collaboration tools 
 * Basic page for  WiZiQ block in moodle. 
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
    	
class block_wiziqlive extends block_base {

    function init() {
        $this->title = get_string('modulename', 'wiziq');
    }

    function get_content() {
        global $USER, $CFG, $SESSION, $COURSE,$DB;
        $cal_m = optional_param( 'cal_m', 0, PARAM_INT );
        $cal_y = optional_param( 'cal_y', 0, PARAM_INT );

        require_once($CFG->dirroot.'/calendar/lib.php');
$courseID=$this->page->course->id;
        if ($this->content !== NULL) {
            return $this->content;
        }
         // Reset the session variables
        calendar_session_vars($this->page->course);
        $this->content = new stdClass;
        $this->content->text = '';

        if (empty($this->instance)) { // Overrides: use no course at all
        
            $courseshown = false;
            $filtercourse = array();
            $this->content->footer = '';

        } else { // for having role of user in class
			if($USER->id==2)
{
	
$role=1;	
}
else
{
$params=array($USER->id,$courseID);	
$query="select ra.roleid from {context} c,{role_assignments} ra where c.id=ra.contextid and ra.userid=? and (c.instanceid=? or c.instanceid=0 )";
$query1=$DB->get_records_sql($query, $params);
$i=0;
foreach($query1 as $rows)
{
$resultant[$i]= $rows->roleid;
$i++;
}
//s$query1->close();
sort($resultant);
$role=$resultant[0];
}
  if($USER->id==1)
{
	
$role='6';
}
$courseshown = $courseID;
if($courseshown!=1)
{
$str='<a href='.$CFG->wwwroot.'/mod/wiziq/ManageContent.php?course='.$courseshown.'>Manage or Upload Content</a>';
}
if($role=='6')// Role 6 is for guest
{
$courseshown = $courseID;
            $this->content->footer = '<div class="gotocal"><a href="'.$CFG->wwwroot.
                                     '/calendar/view.php?view=upcoming&amp;course='.$courseshown.'">'.
                                      get_string('gotocalendar', 'calendar').'</a>...</div>
									  <a href='.$CFG->wwwroot.'/mod/wiziq/index.php?course='.$courseshown.'>WiZiQ Classes</a>...';
            $context = get_context_instance(CONTEXT_COURSE, $courseshown);
       	
}

if($role=='4')
			{
     $courseshown = $courseID;
            $this->content->footer = '<div class="gotocal"><a href="'.$CFG->wwwroot.
                                     '/calendar/view.php?view=upcoming&amp;course='.$courseshown.'">'.
                                      get_string('gotocalendar', 'calendar').'</a>...</div>
									  <a href='.$CFG->wwwroot.'/mod/wiziq/index.php?course='.$courseshown.'>WiZiQ Classes</a>...';
            $context = get_context_instance(CONTEXT_COURSE, $courseshown);
       

}
if($role=='5')
			{
     $courseshown = $courseID;
            $this->content->footer = '<div class="gotocal"><a href="'.$CFG->wwwroot.
                                     '/calendar/view.php?view=upcoming&amp;course='.$courseshown.'">'.
                                      get_string('gotocalendar', 'calendar').'</a>...</div>
									  <a href='.$CFG->wwwroot.'/mod/wiziq/index.php?course='.$courseshown.'>WiZiQ Classes</a>...';
            $context = get_context_instance(CONTEXT_COURSE, $courseshown);
       

}
if($role=='2') // course creator
{
	$courseshown = $courseID;
            $this->content->footer = '<div class="gotocal"><a href="'.$CFG->wwwroot.
                                     '/calendar/view.php?view=upcoming&amp;course='.$courseshown.'">'.
                                      get_string('gotocalendar', 'calendar').'</a>...</div>
			<a href='.$CFG->wwwroot.'/mod/wiziq/wiziq_list.php?course='.$courseshown.'>WiZiQ Classes</a>...<br/>'.$str;
            $context = get_context_instance(CONTEXT_COURSE, $courseshown);
}
if($role=='1')
			{

            $courseshown = $courseID;
            $this->content->footer = '<div class="gotocal"><a href="'.$CFG->wwwroot.
                                     '/calendar/view.php?view=upcoming&amp;course='.$courseshown.'">'.
                                      get_string('gotocalendar', 'calendar').'</a>...</div>
			<a href='.$CFG->wwwroot.'/mod/wiziq/wiziq_list.php?course='.$courseshown.'>WiZiQ Classes</a>...<br/>'.$str;
            $context = get_context_instance(CONTEXT_COURSE, $courseshown);
			}
			
if($role=='3')
			{

            $courseshown = $courseID;
            $this->content->footer = '<div class="gotocal"><a href="'.$CFG->wwwroot.
                                     '/calendar/view.php?view=upcoming&amp;course='.$courseshown.'">'.
                                      get_string('gotocalendar', 'calendar').'</a>...</div>
			<a href='.$CFG->wwwroot.'/mod/wiziq/wiziq_list.php?course='.$courseshown.'>WiZiQ Classes</a>...<br/>'.$str;
            $context = get_context_instance(CONTEXT_COURSE, $courseshown);
			}
            if ($courseshown == SITEID) {
                // Being displayed at site level. This will cause the filter to fall back to auto-detecting
                // the list of courses it will be grabbing events from.
                $filtercourse = NULL;
				  $groupeventsfrom = NULL;
                $SESSION->cal_courses_shown = calendar_get_default_courses(true);
                calendar_set_referring_course(0);
            } else {
                // Forcibly filter events to include only those from the particular course we are in.
                $filtercourse    = array($courseshown => $this->page->course);
                $groupeventsfrom = array($courseshown => 1);
            }
        }

        // We 'll need this later
        calendar_set_referring_course($courseshown);

        // Be VERY careful with the format for default courses arguments!
        // Correct formatting is [courseid] => 1 to be concise with moodlelib.php functions.

         calendar_set_filters($courses, $group, $user, $filtercourse, $groupeventsfrom, false);
        $events = calendar_get_upcoming($courses, $group, $user,
                                        get_user_preferences('calendar_lookahead', CALENDAR_UPCOMING_DAYS),
                                        get_user_preferences('calendar_maxevents', CALENDAR_UPCOMING_MAXEVENTS));

        if (!empty($this->instance)) {
			$this->content->text='<div >'; 
            $this->content->text =$this->content->text . calendar_get_block_upcoming($events,
                                   'view.php?view=day&amp;course='.$courseshown.'&amp;');
			$this->content->text=$this->content->text .'</div>'; 
        }

        if (empty($this->content->text)) {
            $this->content->text = '<div class="post">'.
                                   get_string('noupcomingevents', 'calendar').'</div>';
        }

        return $this->content;
    }
}

?>
