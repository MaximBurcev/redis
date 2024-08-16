<?php


if ($argc < 2) {
    echo 1;
    exit;
}

$redis = new Redis();
try {
    $redis->connect("127.0.0.1");
    $key = $argv[1];
    $f = fopen( 'php://stdin', 'r' );

    while( $line = fgets( $f ) ) {
        $redis->rPush($key, $line);
        if ($redis->lLen($key) > 20) {
            $redis->lPop($key);
        }
    }

    fclose( $f );
} catch (RedisException $e) {
    var_dump($e->getMessage());
}
