<?php

if ($argc < 2) {
    echo 1;
    exit;
}

$name = $argv[1];

$redis = new Redis();
try {
    $redis->connect("127.0.0.1");

    while (1) {
        $n = rand(0, 999999999);
        var_dump($n);
        $arNumber = str_split($n);
        $arResult = [];
        foreach ([0, 1, 2, 3, 4, 5, 6, 7, 8, 9] as $number) {
            $arResult[$number] = 0;
            foreach ($arNumber as $v) {
                if ($number == $v) {
                    ++$arResult[$number];
                }
            }
        }
        $s = join("", $arResult);
        $channelName = $name . ':' . $s;
        $redis->publish($channelName, $n);
    }

} catch (RedisException $e) {
    var_dump($e->getMessage());
}
