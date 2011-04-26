<?php $this->cache['en']['core_install'] = array (
  'admindirerror' => 'The admin directory specified is incorrect',
  'admindirname' => 'Admin directory',
  'admindirsetting' => 'A very few webhosts use /admin as a special URL for you to access a 
    control panel or something.  Unfortunately this conflicts with the 
    standard location for the Moodle admin pages.  You can fix this by 
    renaming the admin directory in your installation, and putting that 
    new name here.  For example: <br /> <br /><b>moodleadmin</b><br /> <br />
    This will fix admin links in Moodle.',
  'admindirsettinghead' => 'Setting the admin directory ...',
  'admindirsettingsub' => 'A very few webhosts use /admin as a special URL for you to access a 
    control panel or something.  Unfortunately this conflicts with the 
    standard location for the Moodle admin pages.  You can fix this by 
    renaming the admin directory in your installation, and putting that 
    new name here.  For example: <br /> <br /><b>moodleadmin</b><br /> <br />
    This will fix admin links in Moodle.',
  'availablelangs' => 'List of available languages',
  'caution' => 'Caution',
  'cliadminpassword' => 'New admin user password',
  'cliadminusername' => 'Admin account username',
  'clialreadyinstalled' => 'File config.php already exists, please use admin/cli/upgrade.php if you want to upgrade your site.',
  'cliinstallfinished' => 'Installation completed successfully.',
  'cliinstallheader' => 'Moodle {$a} command line installation program',
  'climustagreelicense' => 'In non interactive mode you must agree to license by specifying --agree-license option',
  'clitablesexist' => 'Database tables already present, cli installation can not continue.',
  'compatibilitysettings' => 'Checking your PHP settings ...',
  'compatibilitysettingshead' => 'Checking your PHP settings ...',
  'compatibilitysettingssub' => 'Your server should pass all these tests to make Moodle run properly',
  'configfilenotwritten' => 'The installer script was not able to automatically create a config.php file containing your chosen settings, probably because the Moodle directory is not writeable. You can manually copy the following code into a file named config.php within the root directory of Moodle.',
  'configfilewritten' => 'config.php has been successfully created',
  'configurationcomplete' => 'Configuration completed',
  'configurationcompletehead' => 'Configuration completed',
  'configurationcompletesub' => 'Moodle made an attempt to save your configuration in a file in the root of your Moodle installation.',
  'database' => 'Database',
  'databasecreationsettings' => 'Now you need to configure the database settings where most Moodle data
    will be stored.  This database will be created automatically by the installer
    with the settings specified below.<br />
    <br /> <br />
       <b>Type:</b> fixed to "mysql" by the installer<br />
       <b>Host:</b> fixed to "localhost" by the installer<br />
       <b>Name:</b> database name, eg moodle<br />
       <b>User:</b> fixed to "root" by the installer<br />
       <b>Password:</b> your database password<br />
       <b>Tables Prefix:</b> optional prefix to use for all table names',
  'databasecreationsettingshead' => 'Now you need to configure the database settings where most Moodle data
    will be stored.  This database will be created automatically by the installer
    with the settings specified below.',
  'databasecreationsettingssub' => '<b>Type:</b> fixed to "mysql" by the installer<br />
       <b>Host:</b> fixed to "localhost" by the installer<br />
       <b>Name:</b> database name, eg moodle<br />
       <b>User:</b> fixed to "root" by the installer<br />
       <b>Password:</b> your database password<br />
       <b>Tables Prefix:</b> optional prefix to use for all table names',
  'databasecreationsettingssub2' => '<b>Type:</b> fixed to "mysqli" by the installer<br />
       <b>Host:</b> fixed to "localhost" by the installer<br />
       <b>Name:</b> database name, eg moodle<br />
       <b>User:</b> fixed to "root" by the installer<br />
       <b>Password:</b> your database password<br />
       <b>Tables Prefix:</b> optional prefix to use for all table names',
  'databasehead' => 'Database settings',
  'databasehost' => 'Database host',
  'databasename' => 'Database name',
  'databasepass' => 'Database password',
  'databasesettings' => 'Now you need to configure the database where most Moodle data
    will be stored.  This database must already have been created
    and a username and password created to access it.<br />
    <br /> <br />
       <b>Type:</b> mysql or postgres7<br />
       <b>Host:</b> eg localhost or db.isp.com<br />
       <b>Name:</b> database name, eg moodle<br />
       <b>User:</b> your database username<br />
       <b>Password:</b> your database password<br />
       <b>Tables Prefix:</b> optional prefix to use for all table names',
  'databasesettingshead' => 'Now you need to configure the database where most Moodle data
    will be stored.  This database must already have been created
    and a username and password created to access it.',
  'databasesettingssub' => '<b>Type:</b> mysql or postgres7<br />
       <b>Host:</b> eg localhost or db.isp.com<br />
       <b>Name:</b> database name, eg moodle<br />
       <b>User:</b> your database username<br />
       <b>Password:</b> your database password<br />
       <b>Tables Prefix:</b> optional prefix to use for all table names',
  'databasesettingssub_mssql' => '<b>Type:</b> SQL*Server (non UTF-8) <b><strong  class="errormsg">Experimental! (not for use in production)</strong></b><br />
       <b>Host:</b> eg localhost or db.isp.com<br />
       <b>Name:</b> database name, eg moodle<br />
       <b>User:</b> your database username<br />
       <b>Password:</b> your database password<br />
       <b>Tables Prefix:</b> prefix to use for all table names (mandatory)',
  'databasesettingssub_mssql_n' => '<b>Type:</b> SQL*Server (UTF-8 enabled)<br />
       <b>Host:</b> eg localhost or db.isp.com<br />
       <b>Name:</b> database name, eg moodle<br />
       <b>User:</b> your database username<br />
       <b>Password:</b> your database password<br />
       <b>Tables Prefix:</b> prefix to use for all table names (mandatory)',
  'databasesettingssub_mysql' => '<b>Type:</b> MySQL<br />
       <b>Host:</b> eg localhost or db.isp.com<br />
       <b>Name:</b> database name, eg moodle<br />
       <b>User:</b> your database username<br />
       <b>Password:</b> your database password<br />
       <b>Tables Prefix:</b> prefix to use for all table names (optional)',
  'databasesettingssub_mysqli' => '<b>Type:</b> Improved MySQL<br />
       <b>Host:</b> eg localhost or db.isp.com<br />
       <b>Name:</b> database name, eg moodle<br />
       <b>User:</b> your database username<br />
       <b>Password:</b> your database password<br />
       <b>Tables Prefix:</b> prefix to use for all table names (optional)',
  'databasesettingssub_oci8po' => '<b>Type:</b> Oracle<br />
       <b>Host:</b> not used, must be left blank<br />
       <b>Name:</b> given name of the tnsnames.ora connection<br />
       <b>User:</b> your database username<br />
       <b>Password:</b> your database password<br />
       <b>Tables Prefix:</b> prefix to use for all table names (mandatory, 2cc. max)',
  'databasesettingssub_odbc_mssql' => '<b>Type:</b> SQL*Server (over ODBC) <b><strong  class="errormsg">Experimental! (not for use in production)</strong></b><br />
       <b>Host:</b> given name of the DSN in the ODBC control panel<br />
       <b>Name:</b> database name, eg moodle<br />
       <b>User:</b> your database username<br />
       <b>Password:</b> your database password<br />
       <b>Tables Prefix:</b> prefix to use for all table names (mandatory)',
  'databasesettingssub_postgres7' => '<b>Type:</b> PostgreSQL<br />
       <b>Host:</b> eg localhost or db.isp.com<br />
       <b>Name:</b> database name, eg moodle<br />
       <b>User:</b> your database username<br />
       <b>Password:</b> your database password<br />
       <b>Tables Prefix:</b> prefix to use for all table names (mandatory)',
  'databasesettingswillbecreated' => '<b>Note:</b> The installer will try to create the database automatically if not exists.',
  'databasesocket' => 'Unix socket',
  'databasetypehead' => 'Choose database driver',
  'databasetypesub' => 'Moodle supports several types of database servers. Please contact server administrator if you do not know which type to use.',
  'databaseuser' => 'Database user',
  'dataroot' => 'Data directory',
  'datarooterror' => 'The \'data directory\' you specified could not be found or created.  Either correct the path or create that directory manually.',
  'datarootpublicerror' => 'The \'data directory\' you specified is directly accessible via web, you must use different directory.',
  'dbconnectionerror' => 'We could not connect to the database you specified. Please check your database settings.',
  'dbcreationerror' => 'Database creation error. Could not create the given database name with the settings provided',
  'dbhost' => 'Host server',
  'dbpass' => 'Password',
  'dbprefix' => 'Tables prefix',
  'dbtype' => 'Type',
  'dbwrongencoding' => 'The selected database is running under one non-recommended encoding ({$a}). It would be better to use one Unicode (UTF-8) encoded database instead. Anyway, you can bypass this test by selecting the "Skip DB Encoding Test" check below, but you could experience problems in the future.',
  'dbwronghostserver' => 'You must follow "Host" rules as explained above.',
  'dbwrongnlslang' => 'The NLS_LANG environment variable in your web server must use the AL32UTF8 charset. See PHP documentation about how to configure OCI8 properly.',
  'dbwrongprefix' => 'You must follow "Tables Prefix" rules as explained above.',
  'directorysettings' => '<p>Please confirm the locations of this Moodle installation.</p>

<p><b>Web address:</b>
Specify the full web address where Moodle will be accessed.  
If your web site is accessible via multiple URLs then choose the 
most natural one that your students would use.  Do not include 
a trailing slash.</p>

<p><b>Moodle directory:</b>
Specify the full directory path to this installation
Make sure the upper/lower case is correct.</p>

<p><b>Data directory:</b>
You need a place where Moodle can save uploaded files.  This
directory should be readable AND WRITEABLE by the web server user 
(usually \'nobody\' or \'apache\'), but it must not be accessible 
directly via the web. The installer will try to create it if doesn\'t exist.</p>',
  'directorysettingshead' => 'Please confirm the locations of this Moodle installation',
  'directorysettingssub' => '<b>Web address:</b>
Specify the full web address where Moodle will be accessed.  
If your web site is accessible via multiple URLs then choose the 
most natural one that your students would use.  Do not include 
a trailing slash.
<br />
<br />
<b>Moodle directory:</b>
Specify the full directory path to this installation
Make sure the upper/lower case is correct.
<br />
<br />
<b>Data directory:</b>
You need a place where Moodle can save uploaded files.  This
directory must be readable AND WRITEABLE by the web server user 
(usually \'nobody\' or \'apache\'), but it must not be accessible 
directly via the web. The installer will try to create it if doesn\'t exist.',
  'dirroot' => 'Moodle directory',
  'dirrooterror' => 'The \'Moodle directory\' setting seems to be incorrect - we can\'t find a Moodle installation there. The value below has been reset.',
  'download' => 'Download',
  'downloadlanguagebutton' => 'Download the &quot;{$a}&quot; language pack',
  'downloadlanguagehead' => 'Download language pack',
  'downloadlanguagenotneeded' => 'You may continue the installation process using the default language pack, "{$a}".',
  'downloadlanguagesub' => 'You now have the option of downloading a language pack and continuing the installation process in this language.<br /><br />If you are unable to download the language pack, the installation process will continue in English. (Once the installation process is complete, you will have the opportunity to download and install additional language packs.)',
  'doyouagree' => 'Do you agree ? (yes/no):',
  'environmenthead' => 'Checking your environment ...',
  'environmentsub' => 'We are checking if the various components of your system meet the system requirements',
  'environmentsub2' => 'Each Moodle release has some minimum PHP version requirement and a number of mandatory PHP extensions.
Full environment check is done before each install and upgrade. Please contact server administrator if you do not know how to install new version or enable PHP extensions.',
  'errorsinenvironment' => 'Environment check failed!',
  'fail' => 'Fail',
  'fileuploads' => 'File uploads',
  'fileuploadserror' => 'This should be on',
  'fileuploadshelp' => '<p>File uploading seems to be disabled on your server.</p>

<p>Moodle can still be installed, but without this ability, you will not be able 
   to upload course files or new user profile images.</p>

<p>To enable file uploading you (or your system administrator) will need to 
   edit the main php.ini file on your system and change the setting for 
   <b>file_uploads</b> to \'1\'.</p>',
  'gdversion' => 'GD version',
  'gdversionerror' => 'The GD library should be present to process and create images',
  'gdversionhelp' => '<p>Your server does not seem to have GD installed.</p>

<p>GD is a library that is required by PHP to allow Moodle to process images 
   (such as the user profile icons) and to create new images (such as 
   the log graphs).  Moodle will still work without GD - these features 
   will just not be available to you.</p>

<p>To add GD to PHP under Unix, compile PHP using the --with-gd parameter.</p>

<p>Under Windows you can usually edit php.ini and uncomment the line referencing php_gd2.dll.</p>',
  'globalsquotes' => 'Insecure handling of globals',
  'globalsquoteserror' => 'Fix your PHP settings: disable register_globals and/or enable magic_quotes_gpc',
  'globalsquoteshelp' => '<p>Combination of disabled magic quotes GPC and enabled register globals both at the same time is not recommended.</p>

<p>The recommended setting is <b>magic_quotes_gpc = On</b> and <b>register_globals = Off</b> in your php.ini</p>

<p>If you don\'t have access to your php.ini, you might be able to place the following line in a file
   called .htaccess within your Moodle directory:</p>
   <blockquote><div>php_value magic_quotes_gpc On</div></blockquote>
   <blockquote><div>php_value register_globals Off</div></blockquote>',
  'chooselanguage' => 'Choose a language',
  'chooselanguagehead' => 'Choose a language',
  'chooselanguagesub' => 'Please choose a language for the installation. This language will also be used as the default language for the site, though it may be changed later.',
  'inputdatadirectory' => 'Data directory:',
  'inputwebadress' => 'Web address :',
  'inputwebdirectory' => 'Moodle directory:',
  'installation' => 'Installation',
  'langdownloaderror' => 'Unfortunately the language "{$a}" could not be downloaded. The installation process will continue in English.',
  'langdownloadok' => 'The language "{$a}" was installed successfully. The installation process will continue in this language.',
  'magicquotesruntime' => 'Magic quotes run time',
  'magicquotesruntimeerror' => 'This should be off',
  'magicquotesruntimehelp' => '<p>Magic quotes runtime should be turned off for Moodle to function properly.</p>

<p>Normally it is off by default ... see the setting <b>magic_quotes_runtime</b> in your php.ini file.</p>

<p>If you don\'t have access to your php.ini, you might be able to place the following line in a file 
   called .htaccess within your Moodle directory:</p>
   <blockquote><div>php_value magic_quotes_runtime Off</div></blockquote>',
  'memorylimit' => 'Memory limit',
  'memorylimiterror' => 'The PHP memory limit is set quite low ... you may run into problems later.',
  'memorylimithelp' => '<p>The PHP memory limit for your server is currently set to {$a}.</p>

<p>This may cause Moodle to have memory problems later on, especially 
   if you have a lot of modules enabled and/or a lot of users.</p>

<p>We recommend that you configure PHP with a higher limit if possible, like 40M.  
   There are several ways of doing this that you can try:</p>
<ol>
<li>If you are able to, recompile PHP with <i>--enable-memory-limit</i>.  
    This will allow Moodle to set the memory limit itself.</li>
<li>If you have access to your php.ini file, you can change the <b>memory_limit</b> 
    setting in there to something like 40M.  If you don\'t have access you might 
    be able to ask your administrator to do this for you.</li>
<li>On some PHP servers you can create a .htaccess file in the Moodle directory 
    containing this line:
    <blockquote><div>php_value memory_limit 40M</div></blockquote>
    <p>However, on some servers this will prevent <b>all</b> PHP pages from working 
    (you will see errors when you look at pages) so you\'ll have to remove the .htaccess file.</p></li>
</ol>',
  'mssql' => 'SQL*Server (mssql)',
  'mssqlextensionisnotpresentinphp' => 'PHP has not been properly configured with the MSSQL extension so that it can communicate with SQL*Server.  Please check your php.ini file or recompile PHP.',
  'mssql_n' => 'SQL*Server with UTF-8 support (mssql_n)',
  'mysql' => 'MySQL (mysql)',
  'mysqlextensionisnotpresentinphp' => 'PHP has not been properly configured with the MySQL extension so that it can communicate with MySQL.  Please check your php.ini file or recompile PHP.',
  'mysqli' => 'Improved MySQL (mysqli)',
  'mysqliextensionisnotpresentinphp' => 'PHP has not been properly configured with the MySQLi extension so that it can communicate with MySQL.  Please check your php.ini file or recompile PHP.  MySQLi extension is not available for PHP 4.',
  'nativemysqli' => 'Improved MySQL (native/mysqli)',
  'nativemysqlihelp' => 'Now you need to configure the database where most Moodle data will be stored.
Database may be created if database user has needed permissions, username and password must already exist. Table prefix is optional.',
  'nativemssql' => 'SQL*Server FreeTDS (native/mssql)',
  'nativemssqlhelp' => 'Now you need to configure the database where most Moodle data will be stored.
This database must already have been created and a username and password created to access it. Table prefix is mandatory.',
  'nativeoci' => 'Oracle (native/oci)',
  'nativeocihelp' => 'Now you need to configure the database where most Moodle data will be stored.
This database must already have been created and a username and password created to access it. Table prefix is mandatory.',
  'nativepgsql' => 'PostgreSQL (native/pgsql)',
  'nativepgsqlhelp' => 'Now you need to configure the database where most Moodle data will be stored.
This database must already have been created and a username and password created to access it. Table prefix is mandatory.',
  'ociextensionisnotpresentinphp' => 'PHP has not been properly configured with the OCI8 extension so that it can communicate with Oracle.  Please check your php.ini file or recompile PHP.',
  'oci8po' => 'Oracle (oci8po)',
  'odbcextensionisnotpresentinphp' => 'PHP has not been properly configured with the ODBC extension so that it can communicate with SQL*Server.  Please check your php.ini file or recompile PHP.',
  'odbc_mssql' => 'SQL*Server over ODBC (odbc_mssql)',
  'pass' => 'Pass',
  'paths' => 'Paths',
  'pathserrcreatedataroot' => 'Data directory ({$a->dataroot}) cannot be created by the installer.',
  'pathshead' => 'Confirm paths',
  'pathsrodataroot' => 'Dataroot directory is not writable.',
  'pathsroparentdataroot' => 'Parent directory ({$a->parent}) is not writeable. Data directory ({$a->dataroot}) cannot be created by the installer.',
  'pathssubadmindir' => 'A very few webhosts use /admin as a special URL for you to access a
control panel or something.  Unfortunately this conflicts with the standard location for the Moodle admin pages.  You can fix this by
renaming the admin directory in your installation, and putting that  new name here.  For example: <em>moodleadmin</em>. This will fix admin links in Moodle.',
  'pathssubdataroot' => 'You need a place where Moodle can save uploaded files. This directory should be readable AND WRITEABLE by the web server user
(usually \'nobody\' or \'apache\'), but it must not be accessible directly via the web. The installer will try to create it if doesn\'t exist.',
  'pathssubdirroot' => 'Full directory path to Moodle installation.',
  'pathssubwwwroot' => 'Full web address where Moodle will be accessed.
It\'s not possible to access Moodle using multiple addresses.
If your site has multiple public addresses you must set up permanent redirects on all of them except this one.
If your site is accessible both from Intranet and Internet use the public address here and set up DNS so that the Intranet users may use the public address too.
If the address is not correct please change the URL in your browser to restart installation with a different value.',
  'pathsunsecuredataroot' => 'Dataroot location is not secure',
  'pathswrongadmindir' => 'Admin directory does not exist',
  'pgsqlextensionisnotpresentinphp' => 'PHP has not been properly configured with the PGSQL extension so that it can communicate with PostgreSQL.  Please check your php.ini file or recompile PHP.',
  'phpextension' => '{$a} PHP extension',
  'phpversion' => 'PHP version',
  'phpversionhelp' => '<p>Moodle requires a PHP version of at least 4.3.0 or 5.1.0 (5.0.x has a number of known problems).</p>
<p>You are currently running version {$a}</p>
<p>You must upgrade PHP or move to a host with a newer version of PHP!<br />
(In case of 5.0.x you could also downgrade to 4.4.x version)</p>',
  'postgres7' => 'PostgreSQL (postgres7)',
  'releasenoteslink' => 'For information about this version of Moodle, please see the release notes at {$a}',
  'safemode' => 'Safe mode',
  'safemodeerror' => 'Moodle may have trouble with safe mode on',
  'safemodehelp' => '<p>Moodle may have a variety of problems with safe mode on, not least is that 
   it probably won\'t be allowed to create new files.</p>
   
<p>Safe mode is usually only enabled by paranoid public web hosts, so you may have 
   to just find a new web hosting company for your Moodle site.</p>
   
<p>You can try continuing the install if you like, but expect a few problems later on.</p>',
  'sessionautostart' => 'Session auto start',
  'sessionautostarterror' => 'This should be off',
  'sessionautostarthelp' => '<p>Moodle requires session support and will not function without it.</p>

<p>Sessions can be enabled in the php.ini file ... look for the session.auto_start parameter.</p>',
  'skipdbencodingtest' => 'Skip DB encoding test',
  'nativesqlsrv' => 'SQL*Server Microsoft (native/sqlsrv)',
  'nativesqlsrvhelp' => 'Now you need to configure the database where most Moodle data will be stored.
This database must already have been created and a username and password created to access it. Table prefix is mandatory.',
  'sqliteextensionisnotpresentinphp' => 'PHP has not been properly configured with the SQLite extension.  Please check your php.ini file or recompile PHP.',
  'upgradingqtypeplugin' => 'Upgrading question/type plugin',
  'welcomep10' => '{$a->installername} ({$a->installerversion})',
  'welcomep20' => 'You are seeing this page because you have successfully installed and 
    launched the <strong>{$a->packname} {$a->packversion}</strong> package in your computer. Congratulations!',
  'welcomep30' => 'This release of the <strong>{$a->installername}</strong> includes the applications 
    to create an environment in which <strong>Moodle</strong> will operate, namely:',
  'welcomep40' => 'The package also includes <strong>Moodle {$a->moodlerelease} ({$a->moodleversion})</strong>.',
  'welcomep50' => 'The use of all the applications in this package is governed by their respective 
    licences. The complete <strong>{$a->installername}</strong> package is 
    <a href="http://www.opensource.org/docs/definition_plain.html">open source</a> and is distributed 
    under the <a href="http://www.gnu.org/copyleft/gpl.html">GPL</a> license.',
  'welcomep60' => 'The following pages will lead you through some easy to follow steps to 
    configure and set up <strong>Moodle</strong> on your computer. You may accept the default 
    settings or, optionally, amend them to suit your own needs.',
  'welcomep70' => 'Click the "Next" button below to continue with the set up of <strong>Moodle</strong>.',
  'wwwroot' => 'Web address',
  'wwwrooterror' => 'The \'Web Address\' does not appear to be valid - this Moodle installation doesn\'t appear to be there. The value below has been reset.',
);