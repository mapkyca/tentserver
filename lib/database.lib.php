<?php

    /**
     * Tentserver database functions.
     *
     * @package Tentserver
     * @subpackage Core
     */

     /**
      * Database superclass.
      */
     abstract class Database 
     {
	/**
	 * Sanitise a string using the database key.
	 *
	 * @param string $string The string to sanitise.
	 */
	abstract public function sanitise($string);

	/**
	 * Return a query with multiple return results.
	 *
	 * @param array $query The query.
	 * @param string $callback Optional callback function.
	 * @return array|false
	 */
	abstract public function select($query, $callback = "");

	/**
	 * Get a single row from database.
	 *
	 * @param array $query The query.
	 * @param string $callback Optional callback function.
	 * @return stdClass|false
	 */
	abstract public function selectrow($query, $callback = "");

	/**
	 * Insert data into a database according to given parameters.
	 *
	 *@param array $query The query.
	 * @return int|bool Insert key if autoincrement table used, otherwise bool if success false on fail
	 */
	abstract public function insert($query);

	/**
	 * Update delete data.
	 *
	 * @param array $query The query.
	 * @return int affected rows 
	 */
	abstract public function update($query);

	/**
	 * Delete data from the database, returning the number of affected rows.
	 *
	 * @param array $query The query.
	 * @return int
	 */
	abstract public function delete($query);
     }
     
     /**
      * MySQL Database support.
      * 
      */
     class MySQLDatabase extends Database
     {
	 private $user;
	 private $password;
	 private $host;
	 private $database;
	 
	 private $dblink;
	 
	 private $query_count = 0;
	 private $query_details = array();
	 
	 /**
	  * Construct a new database link.
	  * 
	  * The link isn't actually activated until the first call to the database.
	  * @param type $user
	  * @param type $password
	  * @param type $database
	  * @param type $host 
	  */
	 public function __construct($user, $password, $database = 'tentserver', $host = 'localhost') {
	     $this->user = $user;
	     $this->password = $password;
	     $this->host = $host;
	     $this->database = $database;
	 }
	 
	 /**
	  * Retrieve a link, connecting to the database as necessary.
	  */
	 protected function getLink()
	 {
	     if ($this->dblink) return $this->dblink;
		 
	     if (!$this->dblink = mysql_connect($this->host, $this->user, $this->password, true))
		    throw new DatabaseException("Wrong password"); 
	     if (!mysql_select_db($this->database, $this->dblink))
		    throw new DatabaseException("Database connection failed");  

	     mysql_query("SET NAMES utf8", $this->dblink);

	     return $this->dblink;
	 }
	 
	 /**
	  * Low level execute of query.
	  */
	 protected function executeQuery($query)
	 {
	    $this->query_count++;
	    if ((isset(TentAPI::$config->debug)) && (TentAPI::$config->debug)) $this->query_details[$query]++;

	    $dblink = $this->getLink();
	    if (!$dblink)
		return false;
	    $result = mysql_query($query, $dblink);

	    if (mysql_errno($dblink))
		    throw new DatabaseException(mysql_error($dblink) . " QUERY: " . $query);

	    return $result;
	 }
	 
	/**
	 * Sanitise a string using the database key.
	 *
	 * @param string $string The string to sanitise.
	 */
	public function sanitise($string)
	{
	    $dblink = $this->getLink();
	    if (!$dblink)
		    return false;

	    return mysql_real_escape_string(trim($string), $dblink);
	}

	/**
	 * Return a query with multiple return results.
	 *
	 * @param array $query The query.
	 * @param string $callback Optional callback function.
	 * @return array|false
	 */
	public function select($query, $callback = "")
	{
	    if ($query)
	    {
		if ($result = $this->executeQuery("$query"))
		{
		    $resultarray = array();
					
		    while ($row = mysql_fetch_object($result)) 
		    {
			if (!empty($callback) && is_callable($callback)) 
			    $row = call_user_func($callback,$row);
			
			if ($row) $resultarray[] = $row;
		    }
		}
		else
		    $resultarray = -1;
			
		// Return result array
		if (empty($resultarray)) 
		{
		    if ((isset(TentAPI::$config->debug)) && (TentAPI::$config->debug==true))
			Errors::notice("WARNING: DB query \"$query\" returned no results.", 'WARNING');
		
		    return false;
		}
		
		
		if (is_array($resultarray))
		    return $resultarray;
	    }
			
	    return false;	
	}

	/**
	 * Get a single row from database.
	 *
	 * @param array $query The query.
	 * @param string $callback Optional callback function.
	 * @return stdClass|false
	 */
	public function selectRow($query, $callback = "")
	{
	    if ($query)
	    {
		// Execute
		if ($result = $this->executeQuery("$query"))
		{	
		    if ($row = mysql_fetch_object($result))
		    {
			if (!empty($callback) && is_callable($callback)) 
			    $row = call_user_func($callback,$row);
						
			if ((empty($row)) && (isset(TentAPI::$config->debug)) && (TentAPI::$config->debug==true))
				Errors::notice("WARNING: DB query \"$query\" returned no results.", 'WARNING');
						
			return $row;	
		    }   
		}	
	    }
			
	    return false;
	}

	/**
	 * Insert data into a database according to given parameters.
	 *
	 * @param array $query The query.
	 * @return int|bool Insert key if autoincrement table used, otherwise bool if success false on fail
	 */
	public function insert($query)
	{
	    if ($query)
	    {
		if ($this->executeQuery("$query"))
		{
		    $insert_id = mysql_insert_id($this->getLink()); 
		    if ($insert_id) 
			return $insert_id;
		    
		    if ($insert_id!== false)
			return true;
		}
	    }

	    return false;
	}

	/**
	 * Update delete data.
	 *
	 * @param array $query The query.
	 * @return int|bool affected row or true if query was ok but no error was generated, false on error
	 */
	public function update($query)
	{
	    if ($query)
	    {
		if ($this->executeQuery("$query"))
		{
		    $affected = mysql_affected_rows($this->getLink());
		    
		    if ($affected==0)
			return true;
		    
		    if ($affected!=-1)
			return $affected;
		}
	    }

	    return false;
	}

	/**
	 * Delete data from the database, returning the number of affected rows.
	 *
	 * @param array $query The query.
	 * @return int
	 */
	public function delete($query)
	{
	    if ($query)
	    {
		if ($this->executeQuery("$query"))
		{
		    $affected = mysql_affected_rows($this->getLink());
		    
		    if ($affected==0)
			return true;
		    
		    if ($affected!=-1)
			return $affected;		
		}
	    }
			
	    return false;
	}
     }
     
     class DatabaseException extends TentServerException {}