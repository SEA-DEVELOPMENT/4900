<?php
 
/**
 * Settings for the sky_high theme
 */
 
defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
 
//Shaughn, took out setting to allow user to set a url for the logo

// Logo file setting
//$name = 'theme_sea/logo';
//$title = get_string('logo','theme_sea');
//$description = get_string('logodesc', 'theme_sea');
//$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
//$settings->add($setting);

 
// Block region width
$name = 'theme_sea/regionwidth';
$title = get_string('regionwidth','theme_sea');
$description = get_string('regionwidthdesc', 'theme_sea');
$default = 240;
$choices = array(200=>'200px', 240=>'240px', 290=>'290px', 350=>'350px', 420=>'420px');
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$settings->add($setting);
 
// Foot note setting
$name = 'theme_sea/footnote';
$title = get_string('footnote','theme_sea');
$description = get_string('footnotedesc', 'theme_sea');
$setting = new admin_setting_confightmleditor($name, $title, $description, '');
$settings->add($setting);
 
// Custom CSS file
$name = 'theme_sea/customcss';
$title = get_string('customcss','theme_sea');
$description = get_string('customcssdesc', 'theme_sea');
$setting = new admin_setting_configtextarea($name, $title, $description, '');
$settings->add($setting);
 
// Add our page to the structure of the admin tree


}
?>
