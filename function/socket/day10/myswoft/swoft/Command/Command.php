<?php


namespace Swoft\Command;


use Swoft\Helper\ArrayHelper;

class Command
{
    public static function parseCommand()
    {
        global $argv;
        $serverType = 'http';
        $action = 'start';
        if (isset($argv[1])) {
            $tmp = explode(':', $argv[1]);
            if ($tmp[0] == 'ws') {
                $serverType = 'ws';
                $action = $tmp[1];
            }
        }

        $port = 0;
        $daemonize = false;
        $arr = ArrayHelper::getSplFixedArray($argv);
        for ($i=1; $i<=count($arr); $i++) {
            if ($arr->current() == '-p') {
                $arr->next();
                $port = $arr->current();
            } elseif ($arr->current() == '-d') {
                $daemonize = true;
                $arr->next();
            } else {
                $arr->next();
            }
        }

        return ['server' => $serverType, 'action' => $action, 'port' => $port, 'daemonize' => $daemonize];
    }
}