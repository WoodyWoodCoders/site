<?php

namespace Core\Rest;

class Timer
{
    private static $_start = null;

    static function start()
    {
        $mtime = microtime();
        $mtime = explode(' ', $mtime);
        $mtime = $mtime[1] + $mtime[0];
        self::$_start = $mtime;
    }

    static function end()
    {
        $mtime = microtime();
        $mtime = explode(" ", $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $endtime = $mtime;
        return ($endtime - self::$_start);
    }
}
