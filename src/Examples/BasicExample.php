<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use SlackMessage\Message;

$webhookUrl = 'YOUR_WEBHOOK_URL';

function createMessage($webhookUrl, string $text): bool
{
    $slackMessage = new Message($webhookUrl);

   return $slackMessage
        ->text($text)
        ->send();
}

createMessage($webhookUrl, 'Hello World to Slack!');