<?php

	/**
	 * Tentserver loader
	 *
	 * @package Tentserver
	 * @subpackage Core
	 */
	 	

	// TEMPLATES
		
	// Load Bonita templating engine
		require_once(dirname(__FILE__) . '/bonita/start.php');	
	// Set up Tentserver template location
		Bon::additionalPath(dirname(__FILE__));
	// Set up JSON as the default template
		