<?php
    /**
     * Tentserver basic error handling.
     *
     * @package Tentserver
     * @subpackage Core
     */


     class Errors
     { 
	 /**
	  * Trap PHP error message.
	  * 
	  * @see http://www.php.net/set-error-handler
	  * @param int $errno The level of the error raised
	  * @param string $errmsg The error message
	  * @param string $filename The filename the error was raised in
	  * @param int $linenum The line number the error was raised at
	  * @param array $vars An array that points to the active symbol table at the point that the error occurred
	  */
	 public static function __error_handler($errno, $errmsg, $filename, $linenum, $vars)
	 {
	    $error = date("Y-m-d H:i:s (T)") . ": \"" . $errmsg . "\" in file " . $filename . " (line " . $linenum . ")";
		
	    switch ($errno) {
		    case E_USER_ERROR:
				    self::error($error);
			    break;

		    case E_WARNING :
		    case E_USER_WARNING : 
				    self::warning($error);
			    break;

		    default:
			    self::log_echo($error, 'DEBUG'); 
	    }

	    return true;
	 }
	 
	 /**
	  * Custom exception handler.
	  * This function catches any thrown exceptions and handles them appropriately.
	  *
	  * @see http://www.php.net/set-exception-handler
	  * @param Exception $exception The exception being handled
	  */
	 public static function __exception_handler($exception) {
	    ob_end_clean(); // Clear existing / half empty buffer
		
	    // Log exception
	    self::log_echo($exception->getMessage(), 'EXCEPTION');
            
	    // If this is a platform exception then render it creatively, otherwise enforce the default
	    if ($exception instanceof TentServerException)
		    $body = "$exception";
	    else
		    die($exception->getMessage ());
	 }
	 
	 public static function init()
	 {
	     // Now set php error handlers
	     if (TentAPI::$config->debug)
		set_error_handler('Errors::__error_handler', E_ALL & E_STRICT);
	     else
		set_error_handler('Errors::__error_handler', E_ALL & ~E_NOTICE); // Hide notice level errors when not in debug
	     
	     set_exception_handler('Errors::__exception_handler');
	 }
         
         /**
	 * Write a message to the system log.
	 * @param type $message
	 * @param type $level
	 * @return type 
	 */
	public static function log_echo($message, $level = 'notice')
	{
	    $level = strtoupper($level);
	    
	    error_log("$level: $message");
	}
	
	public static function notice($message) { self::log_echo($message); }
	public static function warning($message) { self::log_echo($message, 'warning'); }
	public static function error($message) { self::log_echo($message, 'error'); }
	public static function debug($message) { self::log_echo($message, 'debug'); }
     }

     /**
      * Superclass for exceptions.
      */
     class TentServerException extends Exception {
        /**
	 * Render the exception using the views system.
	 */
	public function __toString() 
	{
            // TODO: Render exception via bonita template.
	}
     }