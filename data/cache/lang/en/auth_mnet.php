<?php $this->cache['en']['auth_mnet'] = array (
  'auth_mnet_auto_add_remote_users' => 'When set to Yes, a local user record is auto-created when a remote user logs in for the first time.',
  'auth_mnetdescription' => 'Users are authenticated according to the web of trust defined in your Moodle Network settings.',
  'auth_mnet_roamin' => 'These host\'s users can roam in to your site',
  'auth_mnet_roamout' => 'Your users can roam out to these hosts',
  'auth_mnet_rpc_negotiation_timeout' => 'The timeout in seconds for authentication over the XMLRPC transport.',
  'auto_add_remote_users' => 'Auto add remote users',
  'rpc_negotiation_timeout' => 'RPC negotiation timeout',
  'sso_idp_description' => 'Publish this service to allow your users to roam to the {$a} site without having to re-login there. <ul><li><em>Dependency</em>: You must also <strong>subscribe</strong> to the SSO (Service Provider) service on {$a}.</li></ul><br />Subscribe to this service to allow authenticated users from {$a} to access your site without having to re-login. <ul><li><em>Dependency</em>: You must also <strong>publish</strong> the SSO (Service Provider) service to {$a}.</li></ul><br />',
  'sso_idp_name' => 'SSO  (Identity Provider)',
  'sso_mnet_login_refused' => 'Username {$a->user} is not permitted to login from {$a->host}.',
  'sso_sp_description' => 'Publish  this service to allow authenticated users from {$a} to access your site without having to re-login. <ul><li><em>Dependency</em>: You must also <strong>subscribe</strong> to the SSO (Identity Provider) service on {$a}.</li></ul><br />Subscribe to this service to allow your users to roam to the {$a} site without having to re-login there. <ul><li><em>Dependency</em>: You must also <strong>publish</strong> the SSO (Identity Provider) service to {$a}.</li></ul><br />',
  'sso_sp_name' => 'SSO (Service Provider)',
  'pluginname' => 'MNet authentication',
);