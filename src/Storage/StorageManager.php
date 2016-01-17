<?php
namespace Burzum\FileStorage\Storage;

use Burzum\StorageFactory\StorageFactory;

/**
 * StorageManager - manages and instantiates Gaufrette storage engine instances
 *
 * @author Florian Krämer
 * @copyright 2012 - 2016 Florian Krämer
 * @license MIT
 * @deprecated Use Burzum\StorageFactory\StorageFactory instead. StorageManager is going to be removed in 2.0
 */
class StorageManager {

	/**
	 * Adapter configurations
	 *
	 * @var array
	 */
	protected $_adapterConfig = [
		'Local' => [
			'adapterOptions' => [TMP, true],
			'adapterClass' => '\Gaufrette\Adapter\Local',
			'class' => '\Gaufrette\Filesystem'
		]
	];

	/**
	 * Gets the whole config array.
	 *
	 * @return array
	 */
	public function getAllConfig() {
		return $this->_adapterConfig;
	}

	/**
	 * Return a singleton instance of the StorageManager.
	 *
	 * @return \Burzum\FileStorage\Storage\StorageManager
	 */
	public static function &getInstance() {
		static $instance = array();
		if (!$instance) {
			$instance[0] = new StorageManager();
			foreach ($instance[0]->getAllConfig() as $name => $config) {
				StorageFactory::config($name, $config);
			}
		}
		return $instance[0];
	}

	/**
	 * Gets the configuration array for an adapter.
	 *
	 * @param string $adapter
	 * @param array $options
	 * @return mixed
	 */
	public static function config($adapter, $options = array()) {
		return StorageFactory::config($adapter, $options);;
	}

	/**
	 * Flush all or a single adapter from the config.
	 *
	 * @param string $name Config name, if none all adapters are flushed.
	 * @return bool True on success.
	 */
	public static function flush($name = null) {
		return StorageFactory::flush($name);
	}

	/**
	 * Gets a configured instance of a storage adapter.
	 *
	 * @param mixed $adapterName string of adapter configuration or array of settings
	 * @param boolean $renewObject Creates a new instance of the given adapter in the configuration
	 * @throws \RuntimeException
	 * @return \Gaufrette\Filesystem
	 */
	public static function adapter($adapterName, $renewObject = false) {
		return StorageFactory::get($adapterName, $renewObject);
	}
}
