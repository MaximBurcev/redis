<?php


if ($argc < 3) {
    echo 1;
    exit;
}

$redis = new Redis();
try {
    $redis->connect("127.0.0.1");
    $key = $argv[1];
    $limit = $argv[2];
    for ($i = 0; $i < $limit; $i++) {
        echo $redis->lPop($key);
    }

} catch (RedisException $e) {
    var_dump($e->getMessage());
}
