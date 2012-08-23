<?php


	/**
	 * Tentserver server profile functions
	 *
	 * @package Tentserver
	 * @subpackage Core
	 */
	 

		class TentServerProfile {
		
			/**
			 * Function to handle a server /profile request and return information about the server
			 * @return array
			 */
			static function profileRequest() {

				return	 array(
								array	(		
											'type' 	=> array	(
																	'url' 		=> 'https://github.com/benwerd/tentserver',
																	'version' 	=> '0.1.0',
																),
											'licenses'
													=> array	(
																	'url'		=> 'http://benwerd.com/licenses/foobar',
																	'version'	=> '1.0',
																),
											'entity'
													=> 'site entity goes here',
											'servers'
													=> array	(
														'server array goes here'
																),
										),
								array	(
											// Available content types go here
											
											// I'm not sure this is actually required …?
										)
								
													
							);
			
			}
		
		}
		
	// Register handler function with API
		TentAPI::registerRequestHandler('profile','TentServerProfile::profileRequest',false);
		TentAPI::registerRequestHandler('profile','TentServerProfile::profileRequest',true);