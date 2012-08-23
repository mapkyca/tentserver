<?php

	/**
	 * Tentserver API parsing functions
	 *
	 * @package Tentserver
	 * @subpackage Core
	 */
	 
	 
	 	class TentAPI {
	 	
	 		static $request = '';		// Current request
	 		static $params = array();	// Current request parameters
	 		static $data = '';			// Request data
	 									// The list of all request handlers
	 		static $requestHandlers = array('public' => array(), 'authenticated' => array());
	 	
	 		/**
	 		 * Parse request variables from the input line
	 		 */
	 		static function parseRequest() {
	 			// TODO: authentication	 		
		 		self::$request = $_GET['func'];
		 		self::$params = explode('/',$_GET['params']);
		 		self::$data = @file_get_contents('php://input');
	 		}
	 	
	 		/**
	 		 * Parse a request and pass it to the correct handler
	 		 */
	 		static function controller() {
	 			self::parseRequest();			// Get the request details from input
	 			$data = self::handleRequest();	// Pass the request details to the handler function
	 			$template = new BonTemp();		// Establish a new template
	 			$template->setTemplateType('json');
	 			$template->body = $data;
				$template->drawPage();
	 		}
	 		
	 		/**
	 		 * Is the current API request authenticated?
	 		 * @return true|false
	 		 */
	 		static function isAuthenticated() {
	 			// TODO: properly handle authentication
	 			return false;
	 		}
	 		
	 		/**
	 		 * Register an API request handler
	 		 * @param $request The request to handle
	 		 * @param $function The function to handle the request
	 		 * @param $authenticated Does the request need to be authenticated? (Default: false)
	 		 */
			static function registerRequestHandler($request, $function, $authenticated = false) {
				if (!empty($request) && is_callable($function)) {
					if ($authenticated) {
						self::$requestHandlers['public'][$request] = $function;
					} else {
						self::$requestHandlers['authenticated'][$request] = $function;
					}
					return true;
				}
				return false;
			}
			
			/**
			 * Handles parsed requests.
			 * 
			 * @return mixed The result of the handled request
			 */
			static function handleRequest() {
				if (self::isAuthenticated()) {
					$handlers = self::$requestHandlers['authenticated'];
				} else {
					$handlers = self::$requestHandlers['public'];
				}
				if (!empty($handlers) && is_array($handlers)) {
					if (!empty(self::$request)) {
						if (!empty($handlers[self::$request]) && is_callable($handlers[self::$request])) {
							return call_user_func($handlers[self::$request]);
						}
					}
				}
				return false;
			}
	 	
	 	}
