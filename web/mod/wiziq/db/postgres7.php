<?PHP

// THIS FILE IS DEPRECATED!  PLEASE DO NOT MAKE CHANGES TO IT!
//
// IT IS USED ONLY FOR UPGRADES FROM BEFORE MOODLE 1.7, ALL 
// LATER CHANGES SHOULD USE upgrade.php IN THIS DIRECTORY.

function wiziq_upgrade($oldversion) {
	/// This function does anything necessary to upgrade 
/// older versions to match current functionality 

    global $CFG, $db;

   

    if ($oldversion < 2005022000) {
        // recreating the wiki_pages table completelly (missing id, bug 2608)
     
        }

        
    return true;
}

?>
