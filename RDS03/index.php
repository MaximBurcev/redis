<?php

# 03_php_phpredis.php

if ($argc < 2) {
    echo 1;
    die();
}

$redis_client = new Redis();
try {
    $redis_client->connect("127.0.0.1");
    $ns = $argv[1];
    $id = $redis_client->incr($ns);
    $i = 0;
    foreach ($argv as $k => $arg) {
        if ($k > 1) {
            $key = "$ns-$id-$i";
            $redis_client->set($key, $arg);
            $i++;
        }
    }
    echo 0;
} catch (RedisException $e) {
    var_dump($e->getMessage());
}


