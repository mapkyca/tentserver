<?php

	/**
	 * Tentserver loader
	 *
	 * @package Tentserver
	 * @subpackage Core
	 */
	 	
	 	
	// API PARSING

          require_once(dirname(__FILE__) . "/version.info.php");
          require_once(dirname(dirname(__FILE__)) . "/configuration/global.php");
      
        // Include any domain specific configuration
          $settings_file = "{$_SERVER['SERVER_NAME']}.php";
          if (file_exists(dirname(dirname(__FILE__)) . "/configuration/" . $settings_file))
                require_once(dirname(dirname(__FILE__)) . "/configuration/" . $settings_file);
        
        // Load error handlers
                require_once(dirname(__FILE__) . '/errors.lib.php');
          
        // Load database handlers
                require_once(dirname(__FILE__) . '/database.lib.php');
	
	// Load API parsing functions
		require_once(dirname(__FILE__) . '/api.lib.php');
	 	
	// Load server profile functions
		require_once(dirname(__FILE__) . '/profile.lib.php');

	// Load app functions
		require_once(dirname(__FILE__) . '/apps.lib.php');
	 	
	// TEMPLATES
		
	// Load Bonita templating engine
		require_once(dirname(__FILE__) . '/bonita/start.php');	
	// Set up Tentserver template location
		Bon::additionalPath(dirname(__FILE__));
	// Set up JSON as the default template
		