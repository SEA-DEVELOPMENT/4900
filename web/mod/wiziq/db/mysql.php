<?PHP

/*
 * wiziq.com Module
 * WiZiQ's Live Class modules enable Moodle users to use WiZiQ’s web based virtual classroom equipped with real-time collaboration tools 
 * This is Data Base file 
 */
 /**
 * @package mod
 * @subpackage wiziq
 * @author preeti chauhan(preetic@wiziq.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function wiziq_upgrade($oldversion) {
/// This function does anything necessary to upgrade 
/// older versions to match current functionality 

    global $CFG, $db;

   

    if ($oldversion < 2010121000) {
        // recreating the wiki_pages table completelly (missing id, bug 2608)
       execute_sql("
        CREATE TABLE `{$CFG->prefix}wiziq` (
          `id` int(10) unsigned NOT NULL auto_increment,
          `name` char(255)  NOT NULL default ,
          `url` char(255)  NOT NULL default,
           `attendeeurl` char(255)  NOT NULL default,
		    `recordingurl` char(255)  NOT NULL default,
			`reviewurl` char(255)  NOT NULL default,	
		    `wtime` char(255)  NOT NULL default,
           `wdur` char(255)  NOT NULL default,
           `wdate` char(255)  NOT NULL default,
		   `wtype` char(255)  NOT NULL default,
		   `insescod` char(255)  NOT NULL default,
		   `statusrecording` int(1) NOT NULL default,
		   `timezone` char(100) NOT NULL default,
		   `oldclasses` int(1) NOT NULL default,
           `course` int(10) NOT NULL default
		   
          PRIMARY KEY  (`id`)
        ) COMMENT='Defines comments'
        ");
	}

if ($oldversion < 2010121000) {
	execute_sql("
				   CREATE TABLE `{$CFG->prefix}wiziq_attendee_info`(
				    `id` int(10) unsigned NOT NULL auto_increment,
					`username` char(255)  NOT NULL default ,
					`attendeeurl` char(255)  NOT NULL default,
					`insescod` char(255)  NOT NULL default,
					`userid` int(10) unsigned NOT NULL default,
					
					    PRIMARY KEY  (`id`)
					) COMMENT='Defines comments'
				   ");
        }
	
	if ($oldversion < 2010121000) {
	execute_sql("
				   CREATE TABLE `{$CFG->prefix}wiziq_content` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NULL,
  `filepath` varchar(50) NULL,
  `parentid` int(20) NULL,
  `type` tinyint(1) NULL,
  `uploaddatetime` varchar(50) NULL,
  `description` text NULL,
  `userid` int(20) NULL,
  `title` varchar(50) NULL,
  `contentid` int(20) NOT NULL DEFAULT '0',
  `icon` varchar(50) NULL,
  `status` int(10) NOT NULL DEFAULT '1',
  `isDeleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ") ;
        }
	
    return true;

}

?>
