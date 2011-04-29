<?php $this->cache['en']['enrol_imsenterprise'] = array (
  'aftersaving...' => 'Once you have saved your settings, you may wish to',
  'allowunenrol' => 'Allow the IMS data to <strong>unenrol</strong> students/teachers',
  'allowunenrol_desc' => 'If enabled, course enrolments will be removed when specified in the Enterprise data.',
  'basicsettings' => 'Basic settings',
  'coursesettings' => 'Course data options',
  'createnewcategories' => 'Create new (hidden) course categories if not found in Moodle',
  'createnewcategories_desc' => 'If the <org><orgunit> element is present in a course\'s incoming data, its content will be used to specify a category if the course is to be created from scratch. The plugin will NOT re-categorise existing courses.

If no category exists with the desired name, then a hidden category will be created.',
  'createnewcourses' => 'Create new (hidden) courses if not found in Moodle',
  'createnewcourses_desc' => 'If enabled, the IMS Enterprise enrolment plugin can create new courses for any it finds in the IMS data but not in Moodle\'s database. Any newly-created courses are initially hidden.',
  'createnewusers' => 'Create user accounts for users not yet registered in Moodle',
  'createnewusers_desc' => 'IMS Enterprise enrolment data typically describes a set of users. If enabled, accounts can be created for any users not found in Moodle\'s database.

Users are searched for first by their "idnumber", and second by their Moodle username. Passwords are not imported by the IMS Enterprise plugin. The use of an authentication plugin is recommended for authenticating users.',
  'cronfrequency' => 'Frequency of processing',
  'deleteusers' => 'Delete user accounts when specified in IMS data',
  'deleteusers_desc' => 'If enabled, IMS Enterprise enrolment data can specify the deletion of user accounts (if the "recstatus" flag is set to 3, which represents deletion of an account). As is standard in Moodle, the user record isn\'t actually deleted from Moodle\'s database, but a flag is set to mark the account as deleted.',
  'pluginname_desc' => 'This method will repeatedly check for and process a specially-formatted text file in the location that you specify.  The file must follow the IMS Enterprise specifications containing person, group, and membership XML elements.',
  'doitnow' => 'perform an IMS Enterprise import right now',
  'pluginname' => 'IMS Enterprise file',
  'filelockedmail' => 'The text file you are using for IMS-file-based enrolments ({$a}) can not be deleted by the cron process.  This usually means the permissions are wrong on it.  Please fix the permissions so that Moodle can delete the file, otherwise it might be processed repeatedly.',
  'filelockedmailsubject' => 'Important error: Enrolment file',
  'fixcasepersonalnames' => 'Change personal names to Title Case',
  'fixcaseusernames' => 'Change usernames to lower case',
  'imsrolesdescription' => 'The IMS Enterprise specification includes 8 distinct role types. Please choose how you want them to be assigned in Moodle, including whether any of them should be ignored.',
  'location' => 'File location',
  'logtolocation' => 'Log file output location (blank for no logging)',
  'mailadmins' => 'Notify admin by email',
  'mailusers' => 'Notify users by email',
  'miscsettings' => 'Miscellaneous',
  'processphoto' => 'Add user photo data to profile',
  'processphotowarning' => 'Warning: Image processing is likely to add a significant burden to the server. You are recommended not to activate this option if large numbers of students are expected to be processed.',
  'restricttarget' => 'Only process data if the following target is specified',
  'restricttarget_desc' => 'An IMS Enterprise data file could be intended for multiple "targets" - different LMSes, or different systems within a school/university. It\'s possible to specify in the Enterprise file that the data is intended for one or more named target systems, by naming them in <target> tags contained within the <properties> tag.

In general you don\'t need to worry about this. Leave the setting blank and Moodle will always process the data file, no matter whether a target is specified or not. Otherwise, fill in the exact name that will be output inside the <target> tag.',
  'sourcedidfallback' => 'Use the &quot;sourcedid&quot; for a person\'s userid if the &quot;userid&quot; field is not found',
  'sourcedidfallback_desc' => 'In IMS data, the <sourcedid> field represents the persistent ID code for a person as used in the source system. The <userid> field is a separate field which should contain the ID code used by the user when logging in. In many cases these two codes may be the same - but not always.

Some student information systems fail to output the <userid> field. If this is the case, you should enable this setting to allow for using the <sourcedid> as the Moodle user ID. Otherwise, leave this setting disabled.',
  'truncatecoursecodes' => 'Truncate course codes to this length',
  'truncatecoursecodes_desc' => 'In some situations you may have course codes which you wish to truncate to a specified length before processing. If so, enter the number of characters in this box. Otherwise, leave the box blank and no truncation will occur.',
  'usecapitafix' => 'Tick this box if using &quot;Capita&quot; (their XML format is slightly wrong)',
  'usecapitafix_desc' => 'The student data system produced by Capita has been found to have one slight error in its XML output. If you are using Capita you should enable this setting - otherwise leave it un-ticked.',
  'usersettings' => 'User data options',
  'zeroisnotruncation' => '0 indicates no truncation',
  'roles' => 'Roles',
  'ignore' => 'Ignore',
  'importimsfile' => 'Import IMS Enterprise file',
);