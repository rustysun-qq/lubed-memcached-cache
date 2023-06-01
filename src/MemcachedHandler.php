<?php
namespace Lubed\MemcachedCache;

use Lubed\Caches\CacheHandler;
use Memcached;

class MemcachedHandler implements CacheHandler {
    private static $instance=null;
    private $memcached;

    private function __construct(array $options) {
        $this->memcached=new Memcached;
        $this->memcached->addServer($options['host'], $options['port']);
    }

    public function fetch(string $name, &$result) {
        $result=false;
        $value=$this->memcached->get($name);
        if ($this->memcached->getResultCode() != Memcached::RES_SUCCESS) {
            return false;
        }
        $result=true;
        return $value;
    }

    public function store(string $name, $value) {
        return $this->memcached->set($name, $value);
    }

    public function flush() {
        return $this->memcached->flush();
    }

    public function remove(string $name) {
        return $this->memcached->delete($name);
    }

    public static function getInstance(array $options=[]) {
        if (null === self::$instance) {
            self::$instance=new MemcachedHandler($options);
        }
        return self::$instance;
    }
}