<?php

function scanAllDir($dir)
{
    $result = [];
    foreach (scandir($dir) as $filename) {
        if ($filename[0] === '.') {
            continue;
        }
        $filePath = $dir . DIRECTORY_SEPARATOR . $filename;
        if (is_dir($filePath) && is_readable($filePath)) {
            foreach (scanAllDir($filePath) as $childFilename) {
                if (is_readable($childFilename) && is_file($childFilename)) {
                    $result[] = $childFilename;
                }

            }
        } else {
            if (is_readable($filePath) && is_file($filePath)) {
                $result[] = $filePath;
            }
        }
    }

    return $result;
}

if ($argc < 2) {
    echo 1;
    exit;
}

$base = $argv[1];

if (!file_exists($base)) {
    echo 1;
    exit;
}

$redis = new Redis();
try {
    $redis->connect("127.0.0.1");

    $keysToDelete = $redis->keys("data:$base/*");

    $redisMulti = $redis->multi();
    if (!empty($keysToDelete)) {
        foreach ($keysToDelete as $key) {
            $redisMulti->del($key);
        }
    }

    $arFile = scanAllDir($base);

    foreach ($arFile as $file) {
        $redisMulti->set("data:$file", file_get_contents($file));
    }

    $redisMulti->exec();

} catch (RedisException $e) {
    var_dump($e->getMessage());
}
