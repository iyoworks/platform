<?php

namespace Filesystem;

class Directory
{
	/**
	 * Directory Object
	 *
	 * @access   protected
	 * @var      Filesystem\Strategy\{Driver}\Directory Object
	 */
	protected $directory = null;

	/**
	 * Fallback Directory Object
	 *
	 * @access   protected
	 * @var      Filesystem\Strategy\{Driver}\Directory Object
	 */
	protected $fallback = null;

	/**
	 * -----------------------------------------
	 * Function: __construct()
	 * -----------------------------------------
	 *
	 * Instantiate the Directory Object
	 *
	 * @access   public
	 * @param    Filesystem\Strategy Object
	 * @param    Filesystem\Strategy Object
	 * @return   Directory Ojbect
	 */
	public function __construct($strategy, $fallback = null)
	{
		$class = 'Filesystem\\Strategy\\'.$strategy->getDriver().'\\Directory';

		if ($fallback)
		{
			$fallback_class = 'Filesystem\\Strategy\\'.$fallback->getDriver().'\\Directory';
			$this->fallback = new $fallback_class($fallback);
		}

		$this->directory = new $class($strategy);

		return $this;
	}

	/**
	 * -----------------------------------------
	 * Function: call()
	 * -----------------------------------------
	 *
	 * Call function with fallback
	 *
	 * @access   protected
	 * @param    string
	 * @return   mixed
	 */
	protected function call($method)
	{
		$args = func_get_args();
		array_shift($args);

		$response = call_user_func_array(array($this->directory, $method), $args);

		if ( $response === false and ! is_null($this->fallback))
		{
			\Event::fire(
				\Config::get('filesystem::filesystem.event.fallback'),
				array(\Lang::line('filesystem::fallback.directory.'.$method)->get())
			);

			$response = call_user_func_array(array($this->fallback, $method), $args);
		}

		return $response;
	}

	/**
	 * -----------------------------------------
	 * Function: move()
	 * -----------------------------------------
	 *
	 * Move a Directory
	 *
	 * @access   public
	 * @param    string
	 * @param    string
	 * @return   bool
	 */
	public function move($from, $to)
	{
		$response = $this->call('rename', Filesystem::findPath($from), Filesystem::findPath($to));

		if ( ! $response)
		{
			\Event::fire(
				\Config::get('filesystem::filesystem.event.failed'),
				array(\Lang::line('filesystem::failed.directory.move')->get())
			);
		}

		return $response;
	}

	/**
	 * -----------------------------------------
	 * Function: make()
	 * -----------------------------------------
	 *
	 * Make a Directory
	 *
	 * @access   public
	 * @param    string
	 * @return   bool
	 */
	public function make($name)
	{
		$response = $this->call('make', Filesystem::findPath($name));

		if ( ! $response)
		{
			\Event::fire(
				\Config::get('filesystem::filesystem.event.failed'),
				array(\Lang::line('filesystem::failed.directory.make')->get())
			);
		}

		return $response;
	}

	/**
	 * -----------------------------------------
	 * Function: delete()
	 * -----------------------------------------
	 *
	 * Delete a Directory
	 *
	 * @access   public
	 * @param    string  directory name
	 * @return   bool
	 */
	public function delete($path)
	{
		$response = $this->call('delete', Filesystem::findPath($path));

		if ( ! $response)
		{
			\Event::fire(
				\Config::get('filesystem::filesystem.event.failed'),
				array(\Lang::line('filesystem::failed.directory.delete')->get())
			);
		}

		return $response;
	}

	/**
	 * -----------------------------------------
	 * Function: clean()
	 * -----------------------------------------
	 *
	 * Clean a Directory
	 *
	 * @access   public
	 * @param    string
	 * @return   bool
	 */
	public function clean($path = null)
	{
		$response = $this->call('clean', Filesystem::findPath($path));

		if ( ! $response)
		{
			\Event::fire(
				\Config::get('filesystem::filesystem.event.failed'),
				array(\Lang::line('filesystem::failed.directory.clean')->get())
			);
		}

		return $response;
	}

	/**
	 * -----------------------------------------
	 * Function: rename()
	 * -----------------------------------------
	 *
	 * Rename a Directory
	 *
	 * @access   public
	 * @param    string
	 * @param    string
	 * @return   bool
	 */
	public function rename($from, $to)
	{
		$response = $this->call('rename', Filesystem::findPath($from), Filesystem::findPath($to));

		if ( ! $response)
		{
			\Event::fire(
				\Config::get('filesystem::filesystem.event.failed'),
				array(\Lang::line('filesystem::failed.directory.rename')->get())
			);
		}

		return $response;
	}

	/**
	 * -----------------------------------------
	 * Function: current()
	 * -----------------------------------------
	 *
	 * Get Current Directory
	 *
	 * @access   public
	 * @return   string
	 */
	public function current()
	{
		$response = $this->call('current');

		if ( ! $response)
		{
			\Event::fire(
				\Config::get('filesystem::filesystem.event.failed'),
				array(\Lang::line('filesystem::failed.directory.current')->get())
			);
		}

		return $response;
	}

	/**
	 * -----------------------------------------
	 * Function: contents()
	 * -----------------------------------------
	 *
	 * Get Directory Contents
	 *
	 * @access   public
	 * @param    string
	 * @return   string
	 */
	public function contents($path = null)
	{
		$response = $this->call('contents', Filesystem::findPath($path));

		if ($response === false)
		{
			\Event::fire(
				\Config::get('filesystem::filesystem.event.failed'),
				array(\Lang::line('filesystem::failed.directory.contents')->get())
			);
		}

		return $response;
	}

	/**
	 * -----------------------------------------
	 * Function: change()
	 * -----------------------------------------
	 *
	 * Change Directory
	 *
	 * @access   public
	 * @param    string
	 * @return   bool
	 */
	public function change($path)
	{
		$response = $this->call('change', Filesystem::findPath($path));

		if ( ! $response)
		{
			\Event::fire(
				\Config::get('filesystem::filesystem.event.failed'),
				array(\Lang::line('filesystem::failed.directory.change')->get())
			);
		}

		return $response;
	}

	/**
	 * -----------------------------------------
	 * Function: exists()
	 * -----------------------------------------
	 *
	 * See if Directory Exists
	 *
	 * @access   public
	 * @param    string
	 * @return   bool
	 */
	public function exists($path)
	{
		$response = $this->call('exists', Filesystem::findPath($path));

		if ( ! $response)
		{
			\Event::fire(
				\Config::get('filesystem::filesystem.event.failed'),
				array(\Lang::line('filesystem::failed.directory.exists')->get())
			);
		}

		return $response;
	}

}