<?php

	/**
	 * Tentserver loader
	 *
	 * @package Tentserver
	 * @subpackage Core
	 */
	 	
	 	
	// API PARSING
	
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
		