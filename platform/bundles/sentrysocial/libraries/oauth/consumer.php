<?php
/**
 * OAuth Consumer
 *
 * @package    Kohana/OAuth
 * @category    Base
 * @author     Kohana Team
 * @copyright  (c) 2010 Kohana Team
 * @license    http://kohanaframework.org/license
 * @since      3.0.7
 *
 * @modified_by  Cartalyst LLC
 * @copyright    (c) 2012 Cartalyst LLC.
 * @version      1.1
 */

namespace SentrySocial;

use Exception;

class Libraries_OAuth_Consumer {

	/**
	 * Create a new consumer object.
	 *
	 *     $consumer = Consumer::make($options);
	 *
	 * @param   array  consumer options, key and secret are required
	 * @return  Consumer
	 */
	public static function make(array $options = NULL)
	{
		return new static($options);
	}

	/**
	 * @var  string  consumer key
	 */
	protected $key;

	/**
	 * @var  string  consumer secret
	 */
	protected $secret;

	/**
	 * @var  string  callback URL for OAuth authorization completion
	 */
	protected $callback;

	/**
	 * @var  string  scope for OAuth authorization completion
	 */
	protected $scope;

	/**
	 * Sets the consumer key and secret.
	 *
	 * @param   array  consumer options, key and secret are required
	 * @return  void
	 */
	public function __construct(array $options = NULL)
	{
		if (empty($options['key']))
		{
			throw new Exception('Required option not provided: key');
		}

/* TODO Erm? YouTube doesnt need this
		if ( ! isset($options['secret']))
		{
			throw new Exception('Required option not provided: secret');
		}
*/
		$this->key = $options['key'];

		$this->secret = $options['secret'];

		if (isset($options['callback']))
		{
			$this->callback = $options['callback'];
		}

		if (isset($options['scope']))
		{
			$this->scope = $options['scope'];
		}
	}

	/**
	 * Return the value of any protected class variable.
	 *
	 *     // Get the consumer key
	 *     $key = $consumer->key;
	 *
	 * @param   string  variable name
	 * @return  mixed
	 */
	public function __get($key)
	{
		return $this->$key;
	}

	/**
	 * Change the consumer callback.
	 *
	 * @param   string  new consumer callback
	 * @return  $this
	 */
	public function callback($callback)
	{
		$this->callback = $callback;

		return $this;
	}

} // End Consumer
