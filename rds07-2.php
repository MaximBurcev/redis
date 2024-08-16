<?php


$redis = new Redis();
try {
    $redis->connect("127.0.0.1");

    $keys = $redis->keys("data:*");

    if (!empty($keys)) {
        foreach ($keys as $key) {
            echo strlen($redis->get($key)) . ' ' .  str_replace("data:", "", $key)  . "\r\n";
        }
    }


} catch (RedisException $e) {
    var_dump($e->getMessage());
}
