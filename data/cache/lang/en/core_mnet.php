<?php $this->cache['en']['core_mnet'] = array (
  'aboutyourhost' => 'About your server',
  'accesslevel' => 'Access level',
  'addhost' => 'Add host',
  'addnewhost' => 'Add a new host',
  'addtoacl' => 'Add to access control',
  'allhosts_no_options' => 'No options are available when viewing multiple hosts',
  'allow' => 'Allow',
  'applicationtype' => 'Application type',
  'authfail_nosessionexists' => 'Authorisation failed: the mnet session does not exist.',
  'authfail_sessiontimedout' => 'Authorisation failed: the mnet session has timed out.',
  'authfail_usermismatch' => 'Authorisation failed: the user does not match.',
  'authmnetdisabled' => 'MNet authentication plugin is <strong>disabled</strong>.',
  'badcert' => 'This is not a valid certificate.',
  'certdetails' => 'Cert details',
  'configmnet' => 'MNet allows communication of this server with other servers or services.',
  'couldnotgetcert' => 'No certificate found at <br />{$a}. <br />The host may be down or incorrectly configured.',
  'couldnotmatchcert' => 'This does not match the certificate currently published by the webserver.',
  'courses' => 'courses',
  'courseson' => 'courses on',
  'currentkey' => 'Current public key',
  'current_transport' => 'Current transport',
  'databaseerror' => 'Could not write details to the database.',
  'deleteaserver' => 'Deleting a server',
  'deletehost' => 'Delete host',
  'deletekeycheck' => 'Are you absolutely sure you want to delete this key?',
  'deleteoutoftime' => 'Your 60-second window for deleting this key has expired. Please start again.',
  'deleteuserrecord' => 'SSO ACL: delete record for user \'{$a->user}\' from {$a->host}.',
  'deletewrongkeyvalue' => 'An error has occurred. If you were not trying to delete your server\'s SSL key, it is possible you have been the subject of a malicious attack. No action has been taken.',
  'deny' => 'Deny',
  'description' => 'Description',
  'duplicate_usernames' => 'We failed to create an index on the columns "mnethostid" and "username" in your user table.<br />This can occur when you have <a href="{$a}" target="_blank">duplicate usernames in your user table</a>.<br />Your upgrade should still complete successfully. Click on the link above, and instructions on fixing this problem will appear in a new window. You can attend to that at the end of the upgrade.<br />',
  'enabled_for_all' => '(This service has been enabled for all hosts).',
  'enterausername' => 'Please enter a username, or a list of usernames separated by commas.',
  'error7020' => 'This error normally occurs if the remote site has created a record for you with the wrong wwwroot, for example, http://yoursite.com instead of http://www.yoursite.com. You should contact the administrator of the remote site with your wwwroot (as specified in config.php) asking her to update her record for your host.',
  'error7022' => 'The message you sent to the remote site was encrypted properly, but not signed. This is very unexpected; you should probably file a bug if this occurs (giving as much information as possible about the application versions in question, etc.',
  'error7023' => 'The remote site has tried to decrypt your message with all the keys it has on record for your site. They have all failed. You might be able to fix this problem by manually re-keying with the remote site. This is unlikely to occur unless you\'ve been out of communication with the remote site for a few months.',
  'error7024' => 'You send an unencrypted message to the remote site, but the remote site doesn\'t accept unencrypted communication from your site. This is very unexpected; you should probably file a bug if this occurs (giving as much information as possible about the application versions in question, etc.',
  'error7026' => 'The key that your message was signed with differs from the key that the remote host has on file for your server. Further, the remote host attempted to fetch your current key and failed to do so. Please manually re-key with the remote host and try again.',
  'error709' => 'The remote site failed to obtain a SSL key from you.',
  'expired' => 'This key expired on',
  'expires' => 'Valid until',
  'expireyourkey' => 'Delete this key',
  'expireyourkeyexplain' => 'Moodle automatically rotates your keys every 28 days (by default) but you have the option to <em>manually</em> expire this key at any time. This will only be useful if you believe this key has been compromised. A replacement will be immediately automatically generated.<br />Deleting this key will make it impossible for other applications to communicate with you, until you manually contact each administrator and provide them with your new key.',
  'exportfields' => 'Fields to export',
  'failedaclwrite' => 'Failed to write to the MNet access control list for user \'{$a}\'.',
  'findlogin' => 'Find login',
  'forbidden-function' => 'That function has not been enabled for RPC.',
  'forbidden-transport' => 'The transport method you are trying to use is not permitted.',
  'forcesavechanges' => 'Force save changes',
  'helpnetworksettings' => 'Configure MNet communication',
  'hidelocal' => 'Hide local users',
  'hideremote' => 'Hide remote users',
  'host' => 'host',
  'hostcoursenotfound' => 'Host or course not found',
  'hostdeleted' => 'Ok - host deleted',
  'hostexists' => 'A record already exists for a host with that hostname (it may be deleted). <a href="{$a}">click here</a> to edit that record.',
  'hostlist' => 'List of networked hosts',
  'hostname' => 'Hostname',
  'hostnamehelp' => 'The fully-qualified domain name of the remote host, e.g. www.example.com',
  'hostnotconfiguredforsso' => 'This server is not configured for remote login.',
  'hostsettings' => 'Host settings',
  'http_self_signed_help' => 'Permit connections using a self-signed DIY SSL certificate on the remote host.',
  'https_self_signed_help' => 'Permit connections using a self-signed DIY SSL in PHP on the remote host over http.',
  'https_verified_help' => 'Permit connections using a verified SSL certificate on the remote host.',
  'http_verified_help' => 'Permit connections using a verified SSL certificate in PHP on the remote host, but over http (not https).',
  'id' => 'ID',
  'idhelp' => 'This value is automatically assigned and cannot be changed',
  'importfields' => 'Fields to import',
  'inspect' => 'Inspect',
  'installnosuchfunction' => 'Coding error! Something is trying to install a mnet xmlrpc function ({$a->method}) from a file ({$a->file}) and it can\'t be found!',
  'installnosuchmethod' => 'Coding error! Something is trying to install a mnet xmlrpc method ({$a->method}) on a class ({$a->class}) and it can\'t be found!',
  'installreflectionclasserror' => 'Coding error! MNet introspection failed for method \'{$a->method}\' in class \'{$a->class}\'.  The original error message, in case it helps, is: \'{$a->error}\'',
  'installreflectionfunctionerror' => 'Coding error! MNet introspection failed for function \'{$a->method}\' in file \'{$a->file}\'.  The original error message, in case it helps, is: \'{$a->error}\'',
  'invalidaccessparam' => 'Invalid access parameter.',
  'invalidactionparam' => 'Invalid action parameter.',
  'invalidhost' => 'You must provide a valid host identifier',
  'invalidpubkey' => 'The key is not a valid SSL key. ({$a})',
  'invalidurl' => 'Invalid URL parameter.',
  'ipaddress' => 'IP address',
  'is_in_range' => 'The IP address <code>{$a}</code> represents a valid trusted host.',
  'ispublished' => '{$a} has enabled this service for you.',
  'issubscribed' => '{$a} is subscribing to this service on your host.',
  'keydeleted' => 'Your key has been successfully deleted and replaced.',
  'keymismatch' => 'The public key you are holding for this host is different from the public key it is currently publishing. The currently published key is:',
  'last_connect_time' => 'Last connect time',
  'last_connect_time_help' => 'The time that you last connected to this host.',
  'last_transport_help' => 'The transport that you used for the last connection to this host.',
  'leavedefault' => 'Use the default settings instead',
  'listservices' => 'List services',
  'loginlinkmnetuser' => '<br />If you are MNet remote user and can <a href="{$a}">confirm your email address here</a>, you can be redirected to your login page.<br />',
  'logs' => 'logs',
  'managemnetpeers' => 'Manage peers',
  'method' => 'Method',
  'methodhelp' => 'Method help for {$a}',
  'methodsavailableonhost' => 'Methods available on {$a}',
  'methodsavailableonhostinservice' => 'Methods available for {$a->service} on {$a->host}',
  'methodsignature' => 'Method signature for {$a}',
  'mnet' => 'MNet',
  'mnet_concatenate_strings' => 'Concatenate (up to) 3 strings and return the result',
  'mnetdisabled' => 'MNet is <strong>disabled</strong>.',
  'mnetidprovider' => 'MNet ID provider',
  'mnetidproviderdesc' => 'You can use this facility to retrieve a link that you can log in at, if you can provide the correct email address to match the username you previously tried to log in with.',
  'mnetidprovidermsg' => 'You should be able to login at your {$a} provider.',
  'mnetidprovidernotfound' => 'Sorry, but no further information could be found.',
  'mnetlog' => 'Logs',
  'mnetpeers' => 'Peers',
  'mnetservices' => 'Services',
  'mnet_session_prohibited' => 'Users from your home server are not currently permitted to roam to {$a}.',
  'mnetsettings' => 'MNet settings',
  'moodle_home_help' => 'The path to the homepage of MNet application on the remote host, e.g. /moodle/.',
  'name' => 'Name',
  'net' => 'Networking',
  'networksettings' => 'Network settings',
  'never' => 'Never',
  'noaclentries' => 'No entries in the SSO access control list',
  'noaddressforhost' => 'Sorry, but that hostname ({$a}) could not be resolved!',
  'nocurl' => 'PHP cURL library is not installed',
  'nolocaluser' => 'No local record exists for remote user, and it could not be created, as this host will not auto create users.  Please contact your administrator!',
  'nomodifyacl' => 'You are not permitted to modify the MNet access control list.',
  'nonmatchingcert' => 'The subject of the certificate: <br /><em>{$a->subject}</em><br />does not match the host it came from:<br /><em>{$a->host}</em>.',
  'nopubkey' => 'There was a problem retrieving the public key.<br />Maybe the host does not allow MNet or the key is invalid.',
  'nosite' => 'Could not find site-level course',
  'nosuchfile' => 'The file/function {$a} does not exist.',
  'nosuchfunction' => 'Unable to locate function, or function prohibited for RPC.',
  'nosuchmodule' => 'The function was incorrectly addressed and could not be located. Please use the
mod/modulename/lib/functionname format.',
  'nosuchpublickey' => 'Unable to obtain public key for signature verification.',
  'nosuchservice' => 'The RPC service is not running on this host.',
  'nosuchtransport' => 'No transport with that ID exists.',
  'notBASE64' => 'This string is not in base64 encoded format. It cannot be a valid key.',
  'notenoughidpinfo' => 'Your identity provider is not giving us enough information to create or update your account locally. Sorry!',
  'not_in_range' => 'The IP address <code>{$a}</code> does not represent a valid trusted host.',
  'notinxmlrpcserver' => 'Attempt to access the MNet remote client, not during XMLRPC server execution',
  'notmoodleapplication' => 'WARNING: This is not a Moodle application, so some of the inspection methods may not work properly.',
  'notPEM' => 'This key is not in PEM format. It will not work.',
  'notpermittedtojump' => 'You do not have permission to begin a remote session from this Moodle server.',
  'notpermittedtoland' => 'You do not have permission to begin a remote session.',
  'off' => 'Off',
  'on' => 'On',
  'options' => 'Options',
  'peerprofilefielddesc' => 'Here you can override the global settings for which profile fields to send and import when new users are created',
  'permittedtransports' => 'Permitted transports',
  'phperror' => 'An internal PHP error prevented your request being fulfilled.',
  'position' => 'Position',
  'postrequired' => 'The delete function requires a POST request.',
  'profileexportfields' => 'Fields to send',
  'profilefielddesc' => 'Here you can configure the list of profile fields that are sent and received over MNet when user accounts are created, or updated.  You can also override this for each MNet peer individually. Note that the following fields are always sent and are not optional: {$a}',
  'profilefields' => 'Profile fields',
  'profileimportfields' => 'Fields to import',
  'promiscuous' => 'Promiscuous',
  'publickey' => 'Public key',
  'publickey_help' => 'The public key is automatically obtained from the remote server.',
  'publish' => 'Publish',
  'reallydeleteserver' => 'Are you sure you want to delete the server',
  'receivedwarnings' => 'The following warnings were received',
  'recordnoexists' => 'Record does not exist.',
  'reenableserver' => 'No - select this option to re-enable this server.',
  'registerallhosts' => 'Register all hosts (promiscuous mode)',
  'registerallhostsexplain' => 'You can choose to register all hosts that try to connect to you automatically. This means that a record will appear in your hosts list for any MNet site that connects to you and requests your public key.<br />You have the option below to configure services for \'All hosts\' and by enabling some services there, you are able to provide services to any remote server indiscriminately.',
  'registerhostsoff' => 'Register all hosts is currently <b>off</b>',
  'registerhostson' => 'Register all hosts is currently <b>on</b>',
  'remotecourses' => 'Remote courses',
  'remotehost' => 'Remote host',
  'remotehosts' => 'Remote hosts',
  'remoteuserinfo' => 'Remote {$a->remotetype} user - profile fetched from <a href="{$a->remoteurl}">{$a->remotename}</a>',
  'requiresopenssl' => 'Networking requires the OpenSSL extension',
  'restore' => 'Restore',
  'returnvalue' => 'Return value',
  'reviewhostdetails' => 'Review host details',
  'reviewhostservices' => 'Review host services',
  'RPC_HTTP_PLAINTEXT' => 'HTTP unencrypted',
  'RPC_HTTP_SELF_SIGNED' => 'HTTP (self-signed)',
  'RPC_HTTPS_SELF_SIGNED' => 'HTTPS (self-signed)',
  'RPC_HTTPS_VERIFIED' => 'HTTPS (signed)',
  'RPC_HTTP_VERIFIED' => 'HTTP (signed)',
  'selectaccesslevel' => 'Please select an access level from the list.',
  'selectahost' => 'Please select a remote host.',
  'service' => 'Service name',
  'serviceid' => 'Service ID',
  'servicesavailableonhost' => 'Services available on {$a}',
  'serviceswepublish' => 'Services we publish to {$a}.',
  'serviceswesubscribeto' => 'Services on {$a} that we subscribe to.',
  'settings' => 'Settings',
  'showlocal' => 'Show local users',
  'showremote' => 'Show remote users',
  'ssl_acl_allow' => 'SSO ACL: Allow user {$a->user} from {$a->host}',
  'ssl_acl_deny' => 'SSO ACL: Deny user {$a->user} from {$a->host}',
  'ssoaccesscontrol' => 'SSO access control',
  'ssoacldescr' => 'Use this page to grant/deny access to specific users from remote MNet hosts. This is functional when you are offering SSO services to remote users. To control your <em>local</em> users\' ability to roam to other MNet hosts, use the roles system to grant them the <em>mnetlogintoremote</em> capability.',
  'ssoaclneeds' => 'For this functionality to work, you must have Networking on, plus the MNet authentication plugin enabled.',
  'strict' => 'Strict',
  'subscribe' => 'Subscribe',
  'system' => 'System',
  'testclient' => 'MNet test client',
  'testtrustedhosts' => 'Test an address',
  'testtrustedhostsexplain' => 'Enter an IP address to see if it is a trusted host.',
  'theypublish' => 'They publish',
  'theysubscribe' => 'They subscribe',
  'transport_help' => 'These options are reciprocal, so you can only force a remote host to use a signed SSL cert if your server also has a signed SSL cert.',
  'trustedhosts' => 'XML-RPC hosts',
  'trustedhostsexplain' => '<p>The trusted hosts mechanism allows specific machines to execute calls via XML-RPC to any part of the Moodle API. This is available for scripts to control Moodle behaviour and can be a very dangerous option to enable. If in doubt, keep it off.</p>
<p><strong>This is not needed for any standard MNet feature!</strong> Turn it on only if you know what you are doing.</p>
<p>To enable it, enter a list of IP addresses or networks,
one on each line. Some examples:</p>
Your local host:<br />127.0.0.1<br />Your local host (with a network block):<br />127.0.0.1/32<br />Only the host with IP address 192.168.0.7:<br />192.168.0.7/32<br />Any host with an IP address between 192.168.0.1 and 192.168.0.255:<br />192.168.0.0/24<br />Any host whatsoever:<br />192.168.0.0/0<br />Obviously the last example is <strong>not</strong> a recommended configuration.',
  'turnitoff' => 'Turn it off',
  'turniton' => 'Turn it on',
  'type' => 'Type',
  'unknown' => 'Unknown',
  'unknownerror' => 'Unknown error occurred during negotiation.',
  'usercannotchangepassword' => 'You cannot change your password here since you are a remote user.',
  'userchangepasswordlink' => '<br /> You may be able to change your password at your <a href="{$a->wwwroot}/login/change_password.php">{$a->description}</a> provider.',
  'usernotfullysetup' => 'Your user account is incomplete.  You need to go <a href="{$a}">back to your provider</a> and ensure your profile is completed there.  You may need to log out and in again for this to take effect.',
  'usersareonline' => 'Warning: {$a} users from that server are currently logged on to your site.',
  'validated_by' => 'It is validated by the network: <code>{$a}</code>',
  'verifysignature-error' => 'The signature verification failed. An error has occurred.',
  'verifysignature-invalid' => 'The signature verification failed. It appears that this payload was not signed by you.',
  'version' => 'Version',
  'warning' => 'Warning',
  'wrong-ip' => 'Your IP address does not match the address we have on record.',
  'xmlrpc-missing' => 'You must have XML-RPC installed in your PHP build to be able to use this feature.',
  'yourhost' => 'Your host',
  'yourpeers' => 'Your peers',
);