<?php
namespace PHPDaemon\Cache;

use PHPDaemon\Structures\StackCallbacks;

/**
 * Item
 *
 * @package Core
 *
 * @author  Zorin Vasily <maintainer@daemon.io>
 */
class Item {
	use \PHPDaemon\Traits\ClassWatchdog;
	use \PHPDaemon\Traits\StaticObjectWatchdog;

	/** Value
	 * @var mixed
	 */
	protected $value;

	/** Listeners
	 * @var StackCallbacks
	 */
	protected $listeners;

	/** Hits counter
	 * @var integer
	 */
	public $hits = 1;

	/** Expire time
	 * @var integer
	 */
	public $expire;

	/** Establish TCP connection
	 * @return boolean Success
	 */
	public function __construct($value) {
		$this->listeners = new StackCallbacks;
		$this->value     = $value;
	}

	/**
	 * Get hits number
	 * @return int
	 */
	public function getHits() {
		return $this->hits;
	}

	/**
	 * Get value
	 * @return mixed
	 */
	public function getValue() {
		++$this->hits;
		return $this->value;
	}

	/**
	 * Adds listener callback
	 * @param callable $cb
	 */
	public function addListener($cb) {
		$this->listeners->push($cb);
	}

	/**
	 * Sets the value
	 * @param $value
	 */
	public function setValue($value) {
		$this->value = $value;
		$this->listeners->executeAll($this->value);
	}
}
