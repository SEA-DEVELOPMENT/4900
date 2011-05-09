<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();
//Added by Carey to use Paypal Sandbox
$CFG->usepaypalsandbox=true;

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'jamesbrennan.ca';
$CFG->dbname    = 'jamesbr5_sea';
$CFG->dbuser    = 'jamesbr5_sea';
$CFG->dbpass    = 'sea4900';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbsocket' => 0,
);

$CFG->wwwroot   = 'http://localhost/moodle';
$CFG->dataroot  = '/var/moodle/data';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;

$CFG->passwordsaltmain = 'aS1?5YI03K2OIL=`A~CmFqOq';

require_once(dirname(__FILE__) . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
