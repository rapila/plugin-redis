<?php
/**
 * Caches in redis
 */

require_once('predis/autoload.php');

class CachingStrategyRedis extends CachingStrategy {
	protected $host;
	protected $port;
	protected $password;
	protected $prefix = '';

	protected $key = '${module}/${key}';
	protected $timestamp_key = '${module}/${key}/timestamp';
	
	private $oRedisClient = null;
	
	public function init($aOptions = array()) {
		parent::init($aOptions);
		$this->oRedisClient = new Predis\Client(array(
			'scheme' => 'tcp',
			'host' => $this->host,
			'port' => $this->port,
			'password' => $this->password
		));
	}
	
	public function exists(Cache $oCache) {
		$sKey = $this->key($this->replaceOption($oCache, $this->key));
		return $this->oRedisClient->exists($sKey);
	}

	public function read(Cache $oCache, $bAsString = true) {
		$sKey = $this->key($this->replaceOption($oCache, $this->key));
		return $this->oRedisClient->get($sKey);
	}

	public function write(Cache $oCache, $sEntry, $bAppend = false) {
		$sKey = $this->key($this->replaceOption($oCache, $this->key));
		$sTimestampKey = $this->key($this->replaceOption($oCache, $this->timestamp_key));
		if($bAppend) {
			$this->oRedisClient->append($sKey, $sEntry);
			$this->oRedisClient->set($sTimestampKey, time());
		} else {
			$this->oRedisClient->mset(array(
				$sKey => $sEntry,
				$sTimestampKey => time()
			));
		}
	}

	public function date(Cache $oCache) {
		$sTimestampKey = $this->key($this->replaceOption($oCache, $this->timestamp_key));
		return (int)$this->oRedisClient->get($sTimestampKey);
	}
	
	public function size(Cache $oCache) {
		$sKey = $this->key($this->replaceOption($oCache, $this->key));
		return $this->oRedisClient->strlen($sKey);
	}

	private function key($sKey) {
		return ($this->prefix ? $this->prefix . ':' : '') . $sKey;
	}

	public function clearCaches() {
		try {
			$aKeys = $this->oRedisClient->keys($this->key('*'));
			if(count($aKeys) > 0) {
				$this->oRedisClient->del($aKeys);
			}
		} catch (Exception $e) {}
	}
}