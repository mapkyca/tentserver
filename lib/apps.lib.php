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
				
				/*
					Reference input from tent.io API docs:
					
					{
					  "name": "FooApp",
					  "description": "Does amazing foos with your data",
					  "url": "http://foooo.com",
					  "icon": "http://foooo.com/icon.png",
					  "redirect_uris": ["http://fooapp.com/tent/callback"],
					  "scopes": {
					    "write_profile": "Uses an app profile section to describe foos",
					    "read_followings": "Calculates foos based on your followings"
					  }
					}
				*/
				
				if ($app = @json_decode(TentAPI::$data)) {
				}
				
				/*
					Reference output from tent.io API docs:
					
					{
					  "id": "6737b",
					  "secret": "3d2adf9a68bf64f4eaff70a7c7700a8",
					  "mac_algorithm": "hmac-sha-256"
					}

				*/
				
				return false;
			}
		
		}
		
	// Register handler function with API
		TentAPI::registerRequestHandler('apps','TentApps::appsRequest',false);
		TentAPI::registerRequestHandler('apps','TentApps::appsRequest',true);