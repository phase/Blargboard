<?php
require_once __DIR__."/vendor/autoload.php";

use Discord\Discord;
use Discord\WebSockets\Event;
use Discord\WebSockets\WebSocket;

$discord = new Discord("MTg4MjM2MjM4ODIwNjA1OTYx.CjLvbA.S7F8s_AVa3zN8vcBpS7GBccNoXg");
$ws = new WebSocket($discord);

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
                $reply = $message->timestamp->format('d/m/y H:i:s').' - '; // Format the message timestamp.
                $reply .= $message->full_channel->guild->name.' - ';
                $reply .= $message->author->username.' - '; // Add the message author's username onto the string.
                $reply .= $message->content; // Add the message content.
                echo $reply."\n"; // Finally, echo the message with a PHP end of line.
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