<?php

if ($argc < 2) {
    echo 1;
    exit;
}

$name = $argv[1];

$redis = new Redis();
try {
    $redis->connect("127.0.0.1");

    $redis->psubscribe(["$name*"], function ($redis, $pattern, $channel, $message) {
        list ($channelName, $number) = explode(":", $channel);
        $arNumber = str_split($number);
        if ($arNumber[7] >= 3 && $arNumber[1] == 0 && $arNumber['3'] == 0 && $arNumber[5] == 0 && $arNumber[9] == 0) {
            echo ($message);
            exit;
        }
    });

} catch (RedisException $e) {
    var_dump($e->getMessage());
}
