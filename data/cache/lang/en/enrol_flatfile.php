<?php $this->cache['en']['enrol_flatfile'] = array (
  'filelockedmail' => 'The text file you are using for file-based enrolments ({$a}) can not be deleted by the cron process.  This usually means the permissions are wrong on it.  Please fix the permissions so that Moodle can delete the file, otherwise it might be processed repeatedly.',
  'filelockedmailsubject' => 'Important error: Enrolment file',
  'location' => 'File location',
  'mailadmin' => 'Notify admin by email',
  'mailstudents' => 'Notify students by email',
  'mailteachers' => 'Notify teachers by email',
  'mapping' => 'Flat file mapping',
  'pluginname' => 'Flat file (CSV)',
  'pluginname_desc' => 'This method will repeatedly check for and process a specially-formatted text file in the location that you specify.
The file is a comma separated file assumed to have four or six fields per line:
<pre class="informationbox">
*  operation, role, idnumber(user), idnumber(course) [, starttime, endtime]
where:
*  operation        = add | del
*  role             = student | teacher | teacheredit
*  idnumber(user)   = idnumber in the user table NB not id
*  idnumber(course) = idnumber in the course table NB not id
*  starttime        = start time (in seconds since epoch) - optional
*  endtime          = end time (in seconds since epoch) - optional
</pre>
It could look something like this:
<pre class="informationbox">
   add, student, 5, CF101
   add, teacher, 6, CF101
   add, teacheredit, 7, CF101
   del, student, 8, CF101
   del, student, 17, CF101
   add, student, 21, CF101, 1091115000, 1091215000
</pre>',
);