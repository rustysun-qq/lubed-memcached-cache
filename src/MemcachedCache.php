<?php
namespace Lubed\MemcachedCache;

use Lubed\Caches\Cache;
use Lubed\Caches\Exceptions;

class MemcachedCache implements Cache {
    public function getInstance(?array $params=null) {
        if (!$params) {
            Exceptions::CacheFailed('Invalid cache impl params');
        }
        return MemcachedHandler::getInstance($params);
    }
}