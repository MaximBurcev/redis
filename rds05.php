<?php


if ($argc < 2) {
    echo 1;
    exit;
}

$redis = new Redis();
try {
    $redis->connect("127.0.0.1");
} catch (RedisException $e) {
    var_dump($e->getMessage());
}

$sizeInBytes = 100;

$filename = $argv[1];

if (!file_exists($filename)) {
    echo "File not found\n";
    exit;
} else {

    $key = "read#cache#".sha1(serialize($filename));
    try {
        $data = $redis->get($key);
    } catch (RedisException $e) {

    }
    if (!$data) {
        if (filesize($filename) > $sizeInBytes) {
            $fp = fopen($filename, 'r');
            fseek($fp, -$sizeInBytes, SEEK_END); // It needs to be negative
            $data = fread($fp, $sizeInBytes);
        } else {
            $data = file_get_contents($filename);
        }
        try {
            $redis->set($key, $data);
        } catch (RedisException $e) {

        }
    }


    echo $data;
}
