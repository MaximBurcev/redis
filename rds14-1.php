<?php

if ($argc < 2) {
    echo 1;
    die();
}

$redis = new Redis();
try {
    $redis->connect("127.0.0.1");
    $ns = $argv[1];

    foreach ($argv as $k => $arg) {
        if ($k > 1) {
            $arFileName[] = $argv[$k];
        }
    }


    if (count($arFileName) > 0) {
        foreach ($arFileName as $fileName) {
            $redis->lPush("$ns:job", $fileName);
        }
    }

//    while($listItem = $redis->lRange("$ns:job", 0, 1)) {
//        $file = ($redis->lPop("$ns:job"));
//        $res = $redis->mGet(["$ns:res:$file"]);
//        if ($res[0] === false) {
//            $redis->blPop("$ns:res", 1);
//        } else {
//            echo "$file $res\r\n";
//        }
//    }

    echo 0;
} catch (RedisException $e) {
    var_dump($e->getMessage());
}


