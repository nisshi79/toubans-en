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
    $dt = Carbon::now(new DateTimeZone('Asia/Tokyo'));
    notify($table,$dt);
    echo $table['group_id'];
}

function notify($table,$dt){

    switch ($table['notification_span']) {
        case 0: //dsoW
            $doW = $dt->dayOfWeek;

            echo $table['notification_time'];

            echo $table['last_notified_at'];

            if (in_array("{$doW}", explode(',', $table['notification_date'])) && isTimeReady($table['notification_time']) && isGreater($table['last_notified_at'], $table['notification_time'])) send($table);
            // 週のうちの何日目か 0 (日曜)から 6 (土曜)

            break;

        case 1: //doM
            $doM = $dt->day;

            if (in_array("{$doM}", min($table['notification_date'], $dt->daysInMonth)) && isTimeReady($table['notification_time']) && isGreater($table['last_notified_at'], $table['notification_time'])) send($table);


            break;
        default:
            break;
    }
}

function send($table){
    $spent_blocks = $table['sent_count'];


    $push_message ='';
    $push_message.="「$table[top_textarea]」のお知らせ\n";
    $push_message.=generate($table);
    $push_message.="$table[lower_textarea]\n";

    $push_message=substr($push_message,0,-1);

    $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('TOUBAN_BOT_CHANNEL_ACCESS_TOKEN'));
    $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('TOUBAN_BOT_CHANNEL_SECRET')]);

    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($push_message);
    $response = $bot->pushMessage($table['group_id'], $textMessageBuilder);

    $table->update([
        'sent_count' => $table['sent_count']+1,
        'last_notified_at' => Carbon::now(new DateTimeZone('Asia/Tokyo'))
    ]);

    echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
}

function generate($table){
    $roles= $table->role;
    $members=$table->member;

    $generated_message ='';

    $number_of_states = max(count($roles),count($members));

    $pairs_num=min(count($roles),count($members));
    $currentState = 2 % $number_of_states;

    if(count($roles) <= count($members)){
        for($i = 0; $i < $pairs_num; $i++){
            $memberId = ($i-$currentState) % $number_of_states;
            if($memberId<0)$memberId += $number_of_states;
            $generated_message .= $roles[$i].'の担当は'.$members[$memberId]."\n";
        }

    }elseif(count($roles) > count($members)){
        for($i = 0; $i < $pairs_num; $i++){
            $rolesId = ($i + $currentState) % $number_of_states;
            $generated_message .= $roles[$rolesId].'の担当は'.$members[$i]."\n";
        }
    }

    return $generated_message;
}

function isTimeReady($startTime){
     $notificationTimeCarbon = new Carbon($startTime,'Asia/Tokyo');

     $dt = Carbon::now(new DateTimeZone('Asia/Tokyo'));

    echo 'koregaaa'.$dt.'soredaa';
    return $dt->gte($notificationTimeCarbon);
}
function isGreater($time1, $time2){
    $time2Buf = new Carbon($time2,'Asia/Tokyo');
    $time1Buf = new Carbon($time1,'Asia/Tokyo');
    echo 'time1Buf is'.$time1Buf.'this';
    echo 'time2Buf is'.$time2Buf.'this';
    return $time1Buf->lt($time2Buf);
}