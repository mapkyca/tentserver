<?php


	/**
	 * Tentserver app registration functions
	 *
	 * @package Tentserver
	 * @subpackage Core
	 */
	 

		class TentApps {
		
			/**
			 * Function to handle an /apps request and register an app
			 * @return array
			 */
			static function appsRequest() {
				// TODO Build this - but we need database handling first
				return false;
			}
		
		}
		
	// Register handler function with API
		TentAPI::registerRequestHandler('apps','TentApps::appsRequest',false);
		TentAPI::registerRequestHandler('apps','TentApps::appsRequest',true);