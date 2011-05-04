<?php

/**
 * Settings for the decaf theme
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // Background colour setting
    $name = 'theme_decaf/backgroundcolor';
    $title = get_string('backgroundcolor','theme_decaf');
    $description = get_string('backgroundcolordesc', 'theme_decaf');
    $default = '#EEE';
    $previewconfig = array('selector'=>'html', 'style'=>'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);

    // Foot note setting
    $name = 'theme_decaf/footnote';
    $title = get_string('footnote','theme_decaf');
    $description = get_string('footnotedesc', 'theme_decaf');
    $setting = new admin_setting_confightmleditor($name, $title, $description, '');
    $settings->add($setting);

    // Custom CSS file
    $name = 'theme_decaf/customcss';
    $title = get_string('customcss','theme_decaf');
    $description = get_string('customcssdesc', 'theme_decaf');
    $setting = new admin_setting_configtextarea($name, $title, $description, '');
    $settings->add($setting);

    // Hide Settings block
    $name = 'theme_decaf/hidesettingsblock';
    $title = get_string('hidesettingsblock','theme_decaf');
    $description = get_string('hidesettingsblockdesc', 'theme_decaf');
    $default = 1;
    $choices = array(1=>'Yes', 0=>'No');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Hide Navigation block
    $name = 'theme_decaf/hidenavigationblock';
    $title = get_string('hidenavigationblock','theme_decaf');
    $description = get_string('hidenavigationblockdesc', 'theme_decaf');
    $default = 0;
    $choices = array(1=>'Yes', 0=>'No');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);
}