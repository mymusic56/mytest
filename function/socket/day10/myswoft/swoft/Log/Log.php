<?php

namespace Swoft\Log;

class Log
{

    /**
     * Standard output stream
     * @var resource
     */
    protected static $_outputStream = null;

    /**
     * If $outputStream support decorated
     * @var bool
     */
    protected static $_outputDecorated = null;

    public static function wirte($msg, $decorated=false)
    {
        $stream = static::outputStream();
        if (!$stream) {
            return false;
        }
        if (!$decorated) {
            $line = $white = $green = $end = '';
            if (static::$_outputDecorated) {
                $line = "\033[1A\n\033[K";
                $white = "\033[47;30m";
                $green = "\033[32;40m";
                $end = "\033[0m";
            }
            $msg = str_replace(array('<n>', '<w>', '<g>'), array($line, $white, $green), $msg);
            $msg = str_replace(array('</n>', '</w>', '</g>'), $end, $msg);
        } elseif (!static::$_outputDecorated) {
            return false;
        }
        fwrite($stream, $msg."\r\n");
        fflush($stream);
        return true;
    }

    /**
     * @param null $stream
     * @return bool|resource
     */
    private static function outputStream($stream = null)
    {
        if (!$stream) {
            $stream = static::$_outputStream ? static::$_outputStream : STDOUT;
        }
        if (!$stream || !is_resource($stream) || 'stream' !== get_resource_type($stream)) {
            return false;
        }
        $stat = fstat($stream);
        if (($stat['mode'] & 0170000) === 0100000) {
            // file
            static::$_outputDecorated = false;
        } else {
            static::$_outputDecorated = true &&
                function_exists('posix_isatty') &&
                posix_isatty($stream);
        }
        return static::$_outputStream = $stream;
    }
}