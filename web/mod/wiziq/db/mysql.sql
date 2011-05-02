


        CREATE TABLE `mdl_wiziq` (
          `id` int(10) unsigned NOT NULL auto_increment,
          `name` char(255)  NOT NULL,
          `url` char(255)  NOT NULL,
           `attendeeurl` char(255)  NOT NULL ,
	   `recordingurl` char(255)  NOT NULL,
	    `reviewurl` char(255)  NOT NULL ,	
              `wtime` char(255)  NOT NULL,
               `wdur` char(255)  NOT NULL,
                `wdate` char(255)  NOT NULL ,
		`wtype` char(255)  NOT NULL,
		`insescod` char(255)  NOT NULL,
		`statusrecording` int(1) NOT NULL,
		`timezone` char(100) NOT NULL,
        `oldclasses` int(1) NOT NULL, 
        `course` int(10) NOT NULL 

          PRIMARY KEY  (`id`)
        ); 

        CREATE TABLE `mdl_wiziq_attendee_info` (
              `id` int(10) unsigned NOT NULL auto_increment,
					`username` char(255)  NOT NULL,
					`attendeeurl` char(255)  NOT NULL,
					`insescod` char(255)  NOT NULL,
					`userid` int(10) unsigned NOT NULL,
					 
                      PRIMARY KEY  (`id`)
                     );

		CREATE TABLE IF `mdl_wiziq_content` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(50) NULL,
		  `filepath` varchar(50) NULL,
		  `parentid` int(11) NULL,
		  `type` int(11) NULL,
		  `uploaddatetime` varchar(50) NULL,
		  `description` text NULL,
		  `userid` int(11) NULL,
		  `title` varchar(50) NULL,
		  `contentid` int(11) NOT NULL DEFAULT '0',
		  `icon` varchar(50) NULL,
		  `status` int(10) NOT NULL DEFAULT '1',
		  `isDeleted` int(10) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		);