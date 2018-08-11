<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 18/06/14
 * Time: 1:48
 */

require ('vendor/autoload.php');
require_once ('bootstrap.php');
require_once ('Role.php');
require_once ('Member.php');
require_once ('Table.php');

use Carbon\Carbon;
$tableArray = \Model\Table::all();



foreach ($tableArray as $table ) {
    $dt = Carbon::now();
    notify($table);
}
function notify($table)
{
    global $dt;
    switch ($table['block_size']) {
        case 0: //day
            $dt->addDays($table['notification_date']);
            $actual_date = $dt->dayOfWeek;
            if (in_array("{$actual_date}", explode(',', $table['avaliable_term'])) && isTimeReady($table['notification_time'])) send($table);
            // 週のうちの何日目か 0 (日曜)から 6 (土曜)
            break;
        case 1: //week
            send($table);
            break;
        case 2: //month
            if($table['notification_number']>=0){
                $dt->addDays($table['notification_date']);
            }else{
                $dt->subDays($table['notification_date']);
            }

            $actual_month = $dt->month;
            if (in_array("{$actual_month}", explode(',', $table['avaliable_term']))) send($table);
            break;
    }
}

function send($table){
    $spent_blocks = $table['sent_count'];


    $push_message ='';
    $push_message.="「$table[title]」のお知らせ\n";
    $push_message.=generate($table);

    $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('OSHIRASE_TOUBAN_BOT_CHANNEL_ACCESS_TOKEN'));
    $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('OSHIRASE_TOUBAN_BOT_CHANNEL_SECRET')]);

    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($push_message);
    $response = $bot->pushMessage($table['group_id'], $textMessageBuilder);

    echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
}

function generate($table){
    $roles= $table->role;
    $members=$table->member;
    $generated_message ='';
    $number_of_states = max(count($roles),count($members));
    $currentState = $table['sent_count'] % $number_of_states;

    for($i = 0;$i < $number_of_states;$i++){
        $memberId=($i-$currentState)%$number_of_states;
        $generated_message .= $roles[$i]['role'].'の担当は'.$members[$memberId]['member'];
    }

    return $generated_message;
}

function isTimeReady(){

}

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;

/*$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('test');
$response = $bot->pushMessage(Ud93e55343ff0dfaa0bd51e382521e44d, $textMessageBuilder);*/
/*Cd7e4374358e5fe9a2a25829af7742985*/
/*echo $response->getHTTPStatus() . ' ' . $response->getRawBody();*/