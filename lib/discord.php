<?php
//turn off output buffereing
ini_set('output_buffering', 'off');
ini_set('zlib.output_compression', false);

ini_set('implicit_flush', true);
ob_implicit_flush(true);

while (ob_get_level() > 0) {
    $level = ob_get_level();
    ob_end_clean();
    if (ob_get_level() == $level) break;
}

if (function_exists('apache_setenv')) {
    apache_setenv('no-gzip', '1');
    apache_setenv('dont-vary', '1');
}

require_once __DIR__.'/../vendor/autoload.php';

use Discord\Discord;
use Discord\WebSockets\Event;
use Discord\WebSockets\WebSocket;
use WebSocket\Server;

$discord = new Discord(Settings::get("discordKey"));
$ws = new WebSocket($discord);
$server = new Server(array('port' => 3757));

$ws->on(
    'ready',
    function ($discord) use ($ws) {
        echo 'Discord WebSocket is ready!'."\n";
        $ws->on(
            Event::MESSAGE_CREATE,
            function ($message, $discord, $newdiscord) {
                if ($message->content == 'ping') {
                    $message->reply('pong!');
                }
                $reply = $message->timestamp->format('d/m/y H:i:s').' - ';
                $reply .= $message->full_channel->guild->name.' - ';
                $reply .= $message->author->username.' - ';
                $reply .= $message->content;
                $server->send($reply."\n", 'text', false);
            }
        );
    }
);

$ws->on(
    'error',
    function ($error, $ws) {
        dump($error);
        exit(1);
    }
);

$ws->run();
?>
