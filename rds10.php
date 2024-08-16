<?php

# 03_php_phpredis.php

if ($argc < 2) {
    echo 1;
    die();
}

$redis_client = new Redis();
try {
    $redis_client->connect("127.0.0.1");
    $count = $argv[1];

    $arKeyName = [];
    foreach ($argv as $k => $arg) {
        if ($k > 1) {
            $arKeyName[] = $arg;
        }
    }
    if (!empty($arKeyName)) {
        for ($i = 0; $i < $count; $i++) {
            $result = $redis_client->blPop($arKeyName, 5);
            if (!empty($result)) {
                echo $result[0] . ' ' . $result[1] . "\n";
            }
        }
    }
    echo 1;
} catch (RedisException $e) {
    var_dump($e->getMessage());
}


