<?php

if ($argc < 2) {
    echo 1;
    die();
}

$redis = new Redis();
try {
    $redis->connect("127.0.0.1");
    $ns = $argv[1];

    while($arResult = $redis->blpop("$ns:job", 1)) {
        $file = $arResult[1];
        if (file_exists($file)) {
            $sha1 = sha1_file($file);
            $redis->set("$ns:res:$file", $sha1);
            $redis->set("$ns:res", 1);
        }
    }


    echo 0;
} catch (RedisException $e) {
    var_dump($e->getMessage());
}


