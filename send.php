<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 18/06/14
 * Time: 1:48
 */
require ('vendor/autoload.php');
require_once ('bootstrap.php');
require_once ('utils.php');



/*use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;*/

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('test');
$response = $bot->pushMessage(Ud93e55343ff0dfaa0bd51e382521e44d, $textMessageBuilder);
/*Cd7e4374358e5fe9a2a25829af7742985*/
/*echo $response->getHTTPStatus() . ' ' . $response->getRawBody();*/