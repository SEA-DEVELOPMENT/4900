<?php $this->cache['en']['core_portfolio'] = array (
  'activeexport' => 'Resolve active export',
  'activeportfolios' => 'Available portfolios',
  'addalltoportfolio' => 'Export all to portfolio',
  'addnewportfolio' => 'Add a new portfolio',
  'addtoportfolio' => 'Export to portfolio',
  'alreadyalt' => 'Already exporting - please click here to resolve this transfer',
  'alreadyexporting' => 'You already have an active portfolio export in this session. Before continuing, you must either complete this export, or cancel it.  Would you like to continue it? (No will cancel it)',
  'availableformats' => 'Available export formats',
  'callbackclassinvalid' => 'Callback class specified was invalid or not part of the portfolio_caller hierarchy',
  'callercouldnotpackage' => 'Failed to package up your data for export: original error was {$a}',
  'cannotsetvisible' => 'Cannot set this to visible - the plugin has been completely disabled because of a misconfiguration',
  'commonportfoliosettings' => 'Common portfolio settings',
  'commonsettingsdesc' => '<p>Whether a transfer is considered to take a \'Moderate\' or \'High\' amount of time changes whether the user is able to wait for the transfer to complete or not.</p><p>Sizes up to the \'Moderate\' threshold just happen immediately without the user being asked, and \'Moderate\' and \'High\' transfers mean they are offered the option but warned it might take some time.</p><p>Additionally, some portfolio plugins might ignore this option completely and force all transfers to be queued.</p>',
  'configexport' => 'Configure exported data',
  'configplugin' => 'Configure portfolio plugin',
  'configure' => 'Configure',
  'confirmcancel' => 'Are you sure you wish you cancel this export?',
  'confirmexport' => 'Please confirm this export',
  'confirmsummary' => 'Summary of your export',
  'continuetoportfolio' => 'Continue to your portfolio',
  'deleteportfolio' => 'Delete portfolio instance',
  'destination' => 'Destination',
  'disabled' => 'Sorry, but portfolio exports are not enabled in this site',
  'disabledinstance' => 'Disabled',
  'displayarea' => 'Export area',
  'displayexpiry' => 'Transfer expiry time',
  'displayinfo' => 'Export info',
  'dontwait' => 'Don\'t wait',
  'enabled' => 'Enable portfolios',
  'enableddesc' => 'This will allow administrators to configure remote systems for users to export content to',
  'err_uniquename' => 'Portfolio name must be unique (per plugin)',
  'exportalreadyfinished' => 'Portfolio export complete!',
  'exportalreadyfinisheddesc' => 'Portfolio export complete!',
  'exportcomplete' => 'Portfolio export complete!',
  'exportedpreviously' => 'Previous exports',
  'exportexceptionnoexporter' => 'A portfolio_export_exception was thrown with an active session but no exporter object',
  'exportexpired' => 'Portfolio export expired',
  'exportexpireddesc' => 'You tried to repeat the export of some information, or start an empty export. To do that properly you should go back to the original location and start again. This sometimes happens if you use the back button after an export has completed, or by bookmarking an invalid url.',
  'exporting' => 'Exporting to portfolio',
  'exportingcontentfrom' => 'Exporting content from {$a}',
  'exportingcontentto' => 'Exporting content to {$a}',
  'exportqueued' => 'Portfolio export has been successfully queued for transfer',
  'exportqueuedforced' => 'Portfolio export has been successfully queued for transfer (the remote system has enforced queued transfers)',
  'failedtopackage' => 'Could not find files to package',
  'failedtosendpackage' => 'Failed to send your data to the selected portfolio system: original error was {$a}',
  'filedenied' => 'Access denied to this file',
  'filenotfound' => 'File not found',
  'fileoutputnotsupported' => 'Rewriting file output is not supported for this format',
  'format_document' => 'Document',
  'format_file' => 'File',
  'format_image' => 'Image',
  'format_leap2a' => 'Leap2A portfolio format',
  'format_mbkp' => 'Moodle backup format',
  'format_pdf' => 'PDF',
  'format_plainhtml' => 'HTML',
  'format_presentation' => 'Presentation',
  'format_richhtml' => 'HTML with attachments',
  'format_spreadsheet' => 'Spreadsheet',
  'format_text' => 'Plain text',
  'format_video' => 'Video',
  'hidden' => 'Hidden',
  'highdbsizethreshold' => 'High transfer dbsize',
  'highdbsizethresholddesc' => 'Number of db records over which will be considered to take a high amount of time to transfer',
  'highfilesizethreshold' => 'High transfer filesize',
  'highfilesizethresholddesc' => 'Filesizes over this threshold will be considered to take a high amount of time to transfer',
  'insanebody' => 'Hi! You are receiving this message as an administrator of {$a->sitename}.

Some portfolio plugin instances have been automatically disabled due to misconfigurations. This means that users can not currently export content to these portfolios.

The list of portfolio plugin instances that have been disabled is:

{$a->textlist}

This should be corrected as soon as possible, by visiting {$a->fixurl}.',
  'insanebodyhtml' => '<p>Hi! You are receiving this message as an administrator of {$a->sitename}.</p>
<p>Some portfolio plugin instances have been automatically disabled due to misconfigurations. This means that users can not currently export content to these portfolios.</p>
<p>The list of portfolio plugin instances that have been disabled is:</p>
{$a->htmllist}
<p>This should be corrected as soon as possible, by visiting <a href="{$a->fixurl}">the portfolio configuration pages</a></p>',
  'insanebodysmall' => 'Hi! You are receiving this message as an administrator of {$a->sitename}. Some portfolio plugin instances have been automatically disabled due to misconfigurations. This means that users can not currently export content to these portfolios. This should be corrected as soon as possible, by visiting {$a->fixurl}.',
  'insanesubject' => 'Some portfolio instances automatically disabled',
  'instancedeleted' => 'Portfolio deleted successfully',
  'instanceismisconfigured' => 'Portfolio instance is misconfigured, skipping. Error was: {$a}',
  'instancenotdelete' => 'Failed to delete portfolio',
  'instancenotsaved' => 'Failed to save portfolio',
  'instancesaved' => 'Portfolio saved successfully',
  'invalidaddformat' => 'Invalid add format passed to portfolio_add_button. ({$a}) Must be one of PORTFOLIO_ADD_XXX',
  'invalidbuttonproperty' => 'Could not find that property ({$a}) of portfolio_button',
  'invalidconfigproperty' => 'Could not find that config property ({$a->property} of {$a->class})',
  'invalidexportproperty' => 'Could not find that export config property ({$a->property} of {$a->class})',
  'invalidfileareaargs' => 'Invalid file area arguments passed to set_file_and_format_data - must contain contextid, component, filearea and itemid',
  'invalidformat' => 'Something is exporting an invalid format, {$a}',
  'invalidinstance' => 'Could not find that portfolio instance',
  'invalidpreparepackagefile' => 'Invalid call to prepare_package_file - either single or multifiles must be set',
  'invalidproperty' => 'Could not find that property ({$a->property} of {$a->class})',
  'invalidsha1file' => 'Invalid call to get_sha1_file - either single or multifiles must be set',
  'invalidtempid' => 'Invalid export id. Maybe it has expired',
  'invaliduserproperty' => 'Could not find that user config property ({$a->property} of {$a->class})',
  'leap2a_emptyselection' => 'Required value not selected',
  'leap2a_entryalreadyexists' => 'You tried to add a Leap2A entry with an id ({$a}) that already exists in this feed',
  'leap2a_feedtitle' => 'Leap2A export from Moodle for {$a}',
  'leap2a_filecontent' => 'Tried to set the content of a Leap2A entry to a file, rather than using the file subclass',
  'leap2a_invalidentryfield' => 'You tried to set an entry field that didn\'t exist ({$a}) or you can\'t set directly',
  'leap2a_invalidentryid' => 'You tried to access an entry by an id that didn\'t exist ({$a})',
  'leap2a_missingfield' => 'Required Leap2A entry field {$a} missing',
  'leap2a_nonexistantlink' => 'A Leap2A entry ({$a->from}) tried to link to a non existing entry ({$a->to}) with rel {$a->rel}',
  'leap2a_overwritingselection' => 'Overwriting the original type of an entry ({$a}) to selection in make_selection',
  'leap2a_selflink' => 'A Leap2A entry ({$a->id}) tried to link to itself with rel {$a->rel}',
  'logs' => 'Transfer logs',
  'logsummary' => 'Previous successful transfers',
  'manageportfolios' => 'Manage portfolios',
  'manageyourportfolios' => 'Manage your portfolios',
  'mimecheckfail' => 'The portfolio plugin {$a->plugin} doesn\'t support that mimetype {$a->mimetype}',
  'missingcallbackarg' => 'Missing callback argument {$a->arg} for class {$a->class}',
  'moderatedbsizethreshold' => 'Moderate transfer dbsize',
  'moderatedbsizethresholddesc' => 'Number of db records over which will be considered to take a moderate amount of time to transfer',
  'moderatefilesizethreshold' => 'Moderate transfer filesize',
  'moderatefilesizethresholddesc' => 'Filesizes over this threshold will be considered to take a moderate amount of time to transfer',
  'multipleinstancesdisallowed' => 'Trying to create another instance of a plugin that has disallowed multiple instances ({$a})',
  'mustsetcallbackoptions' => 'You must set the callback options either in the portfolio_add_button constructor or using the set_callback_options method',
  'noavailableplugins' => 'Sorry, but there are no available portfolios for you to export to',
  'nocallbackclass' => 'Could not find the callback class to use ({$a})',
  'nocallbackfile' => 'Something in the module you\'re trying to export from is broken - couldn\'t find a required file ({$a})',
  'noclassbeforeformats' => 'You must set the callback class before calling set_formats in portfolio_button',
  'nocommonformats' => 'No common formats between any available portfolio plugin and the calling location {$a->location} (caller supported {$a->formats})',
  'noinstanceyet' => 'Not yet selected',
  'nologs' => 'There are no logs to display!',
  'nomultipleexports' => 'Sorry, but the portfolio destination ({$a->plugin}) doesn\'t support multiple exports at the same time. Please <a href="{$a->link}">finish the current one first</a> and try again',
  'nonprimative' => 'A non primitive value was passed as a callback argument to portfolio_add_button. Refusing to continue. The key was {$a->key} and the value was {$a->value}',
  'nopermissions' => 'Sorry but you do not have the required permissions to export files from this area',
  'notexportable' => 'Sorry, but the type of content you are trying to export is not exportable',
  'notimplemented' => 'Sorry, but you are trying to export content in some format that is not yet implemented ({$a})',
  'notyetselected' => 'Not yet selected',
  'notyours' => 'You are trying to resume a portfolio export that doesn\'t belong to you!',
  'nouploaddirectory' => 'Could not create a temporary directory to package your data into',
  'off' => 'Enabled but hidden',
  'on' => 'Enabled and visible',
  'plugin' => 'Portfolio plugin',
  'plugincouldnotpackage' => 'Failed to package up your data for export: original error was {$a}',
  'pluginismisconfigured' => 'Portfolio plugin is misconfigured, skipping. Error was: {$a}',
  'portfolio' => 'Portfolio',
  'portfolios' => 'Portfolios',
  'queuesummary' => 'Currently queued transfers',
  'returntowhereyouwere' => 'Return to where you were',
  'save' => 'Save',
  'selectedformat' => 'Selected export format',
  'selectedwait' => 'Selected to wait?',
  'selectplugin' => 'Select destination',
  'singleinstancenomultiallowed' => 'Only a single portfolio plugin instance is available, it doesn\'t support multiple exports per session, and there\'s already an active export in the session using this plugin!',
  'somepluginsdisabled' => 'Some entire portfolio plugins have been disabled because they are either misconfigured or rely on something else that is:',
  'sure' => 'Are you sure you want to delete \'{$a}\'? This cannot be undone.',
  'thirdpartyexception' => 'A third party exception was thrown during portfolio export ({$a}). Caught and rethrown but this should really be fixed',
  'transfertime' => 'Transfer time',
  'unknownplugin' => 'Unknown (may have since been removed by an administrator)',
  'wait' => 'Wait',
  'wanttowait_high' => 'It is not recommended that you wait for this transfer to complete, but you can if you\'re sure and know what you\'re doing',
  'wanttowait_moderate' => 'Do you want to wait for this transfer? It might take a few minutes',
);