<?php

	/**
	 * Tentserver server profile
	 *
	 * @package Tentserver
	 * @subpackage Core
	 */

	// Load main library
		require_once dirname(dirname(__FILE__)) . '/lib/start.php';
		
		$t = new BonTemp();
		$t->body = array(
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
		$t->setTemplateType('json');
		$t->drawPage();
