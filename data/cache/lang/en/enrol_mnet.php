<?php $this->cache['en']['enrol_mnet'] = array (
  'error_multiplehost' => 'Some instance of MNet enrolment plugin already exists for this host. Only one instance per host and/or one instance for \'All hosts\' is allowed.',
  'instancename' => 'Enrolment method name',
  'instancename_help' => 'You can optionally rename this instance of the MNet enrolment method. If you leave this field empty, the default instance name will be used, containing the name of the remote host and the assigned role for their users.',
  'mnet_enrol_description' => 'Publish this service to allow administrators at {$a} to enrol their students in courses you have created on your server.<br/><ul><li><em>Dependency</em>: You must also <strong>publish</strong> the SSO (Service Provider) service to {$a}.</li><li><em>Dependency</em>: You must also <strong>subscribe</strong> to the SSO (Identity Provider) service on {$a}.</li></ul><br/>Subscribe to this service to be able to enrol your students in courses  on {$a}.<br/><ul><li><em>Dependency</em>: You must also <strong>subscribe</strong> to the SSO (Service Provider) service on {$a}.</li><li><em>Dependency</em>: You must also <strong>publish</strong> the SSO (Identity Provider) service to {$a}.</li></ul><br/>',
  'mnet_enrol_name' => 'Remote enrolment service',
  'pluginname' => 'MNet remote enrolments',
  'pluginname_desc' => 'Allows remote MNet host to enrol their users into our courses.',
  'remotesubscriber' => 'Remote host',
  'remotesubscriber_help' => 'Select \'All hosts\' to open this course for all MNet peers we are offering the remote enrolment service to. Or choose a single host to make this course available for their users only.',
  'remotesubscribersall' => 'All hosts',
  'roleforremoteusers' => 'Role for their users',
  'roleforremoteusers_help' => 'What role will the remote users from the selected host get.',
);