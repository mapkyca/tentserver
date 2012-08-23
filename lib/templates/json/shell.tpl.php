<?php

	/**
	 * Default JSON shell
	 */
	 
	header("content-type: application/json");
	
	echo json_encode($vars['body']);