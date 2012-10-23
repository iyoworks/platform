<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Platform
 * @version    1.0.3
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */


/*
 * --------------------------------------------------------------------------
 * Return the extension data.
 * --------------------------------------------------------------------------
 */
return array(
	/*
     * -----------------------------------------
	 * Extension information.
     * -----------------------------------------
	 */
	'info' => array(
		'name'        => 'Pages',
		'author'      => 'Cartalyst LLC',
		'description' => 'An extension to manage pages and content.',
		'version'     => '1.1',
		'is_core'     => true,
	),

	 /*
     * -----------------------------------------
     * Extension dependencies.
     * -----------------------------------------
     */
    'dependencies' => array(
        'menus',
        'settings'
    ),



    /*
     * -----------------------------------------
     * Extension routes.
     * -----------------------------------------
     */
	'routes' => function(){
		Route::any('/', function() {
			return Controller::call('pages::pages@page');
		});

		Route::any('(:any)', function($page = 'index') {

			// check if the page is a bundle
			if ( ! Bundle::exists($page))
			{
				return Controller::call('pages::pages@page', array($page));
			}
		});
	},

	/*
     * -----------------------------------------
     * Rules
     * -----------------------------------------
     */
	'rules' => array(
		'pages::admin.pages@index',
		'pages::admin.pages@create',
		'pages::admin.pages@edit',
		'pages::admin.pages@delete',
		'pages::admin.content@index',
		'pages::admin.content@create',
		'pages::admin.content@edit',
		'pages::admin.content@delete'
	),

);
