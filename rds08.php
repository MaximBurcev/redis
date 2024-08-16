<?php

if ($argc < 3) {
    echo 1;
    exit;
}

$redis = new Redis();
try {
    $redis->connect("127.0.0.1");

    $key = $argv[1];
    $num = intval($argv[2]);

    $redis->watch($key);
    $value = intval($redis->get($key));
    $value += $num;

    $redis->multi();

    $redis->set($key, $value);

    $redis->exec();




} catch (RedisException $e) {
    var_dump($e->getMessage());
}
