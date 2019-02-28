<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/09/14
 * Time: 2:47
 */
require ('vendor/autoload.php');

require_once ('bootstrap.php');
require_once ('Table.php');
require_once ('Role.php');
require_once ('Member.php');

use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\QuickReplyBuilder;
use \Carbon\Carbon;

/*$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();*/

$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);
error_log($json_string);
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('TOUBAN_BOT_CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('TOUBAN_BOT_CHANNEL_SECRET')]);
/*$channelSecret = '62d8ad6634010ecd45d64f2056dfbcac'; // Channel secret string
$httpRequestBody = $json_string; // Request body string
$hash = hash_hmac('sha256', $httpRequestBody, $channelSecret, true);
$signature = base64_encode($hash);*/

// Compare X-Line-Signature request header string and the signature
$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

try {
    $events = $bot->parseEventRequest($json_string, $signature);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
    error_log('parseEventRequest failed. InvalidSignatureException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
    error_log('parseEventRequest failed. UnknownEventTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
    error_log('parseEventRequest failed. UnknownMessageTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
    error_log('parseEventRequest failed. InvalidEventRequestException => '.var_export($e, true));
}

// 配列に格納された各イベントをループで処理
foreach ($events as $event) {
    // MessageEventクラスのインスタンスでなければ処理をスキップ
    if (!($event instanceof \LINE\LINEBot\Event\MessageEvent) && !($event instanceof \LINE\LINEBot\Event\JoinEvent) && !($event instanceof \LINE\LINEBot\Event\PostbackEvent)) {
        error_log('Non message or join event has come');
        continue;
    }

    /*if(!$event->isGroupEvent()) {
        $bot->replyText($event->getReplyToken(), 'Add this Bot to Group.');
        continue;
    }*/
    function sendConfirmMessage($replyToken,$stopDate){
        // 「はい」ボタン
        $yes_post = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("はい", "ans=y&stop={$stopDate}",'はい');
        // 「いいえ」ボタン
        $no_post = new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("いいえ", "ans=n",'いいえ');
        // Confirmテンプレートを作る
        $yesButton = new QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder($yes_post);
        $noButton = new QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder($no_post);
        $confirm_message = new LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder([$yesButton,$noButton]);
        $confirmDate='';
        if($stopDate=='today')$confirmDate='今日';
        if($stopDate=='tomorrow')$confirmDate='明日';
        $message = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("本当に{$confirmDate}の通知を停止しますか？",$confirm_message);
        // Confirmメッセージを作る
        /*$confirm_message = new TemplateMessageBuilder("確認", $confirm);*/

        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('TOUBAN_BOT_CHANNEL_ACCESS_TOKEN'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('TOUBAN_BOT_CHANNEL_SECRET')]);
        /* $message = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('ooooo');*/
        $res = $bot->replyMessage($replyToken, $message);
    }
    function inputStopSpan($event,$postbackData){
        $table = \Model\Table::where('group_id', $event->getEventSourceId())
            ->first();
        var_dump($table);
        //processing
        $dt = Carbon::now(new DateTimeZone('Asia/Tokyo'));
        error_log($postbackData['stop']);
        if($postbackData['stop']=='tomorrow')$dt->addDay();

        $spans_buf = $table['stop_span'].','.$dt->format('Y/m/d').' - '.$dt->format('Y/m/d');
        $table->update([
            'stop_span' => $spans_buf
        ]);
    }
    function isAlreadyStopped($stopDate,$sourceId){
        $isInRange=false;

        $checkDate = Carbon::now(new DateTimeZone('Asia/Tokyo'));
        if($stopDate=='tomorrow')$checkDate->addDay();
        $table = \Model\Table::where('group_id', $sourceId)
            ->first();
        if(isset($table['stop_span'])){
            $stop_spans = explode(',',$table['stop_span']);

            foreach ($stop_spans as $stop_span){

                $edgeDates = explode(' - ',$stop_span);
                $fromDate = Carbon::createFromFormat('Y/m/d H:i:s', $edgeDates[0].' '.'00:00:00');
                $toDate = Carbon::createFromFormat('Y/m/d H:i:s', $edgeDates[1].' '.'23:59:59');
                error_log($edgeDates[1]);
                if($checkDate->gte($fromDate) && $checkDate->lte($toDate))$isInRange=true;
            }
        }

        return $isInRange;
    }
    function sendAlreadyStopped($stopDate, $sourceId,$replyToken){
        $stopDateStr='';
        if($stopDate=='tomorrow')$stopDateStr='明日';
        if($stopDate=='today')$stopDateStr='今日';

        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('TOUBAN_BOT_CHANNEL_ACCESS_TOKEN'));
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('TOUBAN_BOT_CHANNEL_SECRET')]);
        $message = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("{$stopDateStr}'s notification is already stopped.");
        $res = $bot->replyMessage($replyToken, $message);
    }

    /////////////////
    /// stop
    ////////////////
    if(($event instanceof \LINE\LINEBot\Event\PostbackEvent)){
        $query=$event->getPostbackData();

        parse_str($query, $postbackData);
        error_log($postbackData['stopdate']);
        if($postbackData['stopdate']=='tomorrow' || $postbackData['stopdate']=='today'){
            if(isAlreadyStopped($postbackData['stopdate'],$event->getEventSourceId())){
                sendAlreadyStopped($postbackData['stopdate'],$event->getEventSourceId(),$event->getReplyToken());
            }else{
                sendConfirmMessage($event->getReplyToken(),$postbackData['stopdate']);
            }

        }elseif (isset($postbackData['ans'])){
            if($postbackData['ans']=='y'){
                inputStopSpan($event,$postbackData);
                sendComplete();
            }
        }

    }


    /////////////////////
    /// menu
    /// /////////////

    if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage || $event instanceof \LINE\LINEBot\Event\JoinEvent) {

        $sendFlag =false;

        if($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage){
            if($event->getText() == 'menu') $sendFlag=true;
        }
        if($event instanceof \LINE\LINEBot\Event\JoinEvent)$sendFlag=true;

        if($sendFlag) {
            $flexContents=file_get_contents('./flexMessageMenu.json');
            $flexData= <<< JSON
            {
                "type" : "flex",
                "altText": "Toubans! Menu",
                "contents" : $flexContents
            }
JSON;
            $introduction=<<<JSON
 
JSON;

            ;
            if($event instanceof \LINE\LINEBot\Event\JoinEvent){
                $introduction= <<<JSON
                {
                    "type" : "text",
                    "text" : "Welcome to Toubans!\\nThis service allows you to receive the following type of “duty notifications” with a quick and simple setup."
                },
JSON;
                $example= <<<JSON
                {
                    "type" : "text",
                    "text" : "(1st notification)\\n\\nThis is a friendly reminder of today’s duty.\\n\\nCleaning duty: Ms. Jones"
                },
JSON;
                $example2=<<<JSON
                {
                    "type" : "text",
                    "text" : "(2nd notification)\\n\\nThis is a friendly reminder of today’s duty.\\n\nCleaning duty: Mary"
                },
JSON;

                $introduction2=<<<JSON
                ,
                
                {
                    "type" : "text",
                    "text" : "Please begin setup by pressing the “SETUP/CHANGES” button in the above menu.\\nYou can call up the menu any time by sending a message saying “MENU” to the chat room."
                }
JSON;


            }

            $response = <<<JSON
            {
                "replyToken":"{$event->getReplyToken()}",
                "messages":[
                $introduction
                $example
                $example2
                $flexData
                $introduction2
                ]
            }
JSON;
            error_log($response);
            // LINE BOT API へのリクエストを作成して実行
            $curl = curl_init("https://api.line.me/v2/bot/message/reply");
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.getenv('TOUBAN_BOT_CHANNEL_ACCESS_TOKEN'),'Content-type: application/json'));
            curl_setopt($curl, CURLOPT_POSTFIELDS, $response);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);
            /*error_log($result);*/
            curl_close($curl);
            /*replyMultiMessage($bot, $event->getReplyToken(),
                new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("以下のリンクをクリックするとトークのアルバムをプレビューできます。"),
                new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("http://" . $_SERVER["HTTP_HOST"] . "/album/" . $event->getGroupId())
            );*/
            continue;
        }

        /*appendMessage($event->getUserId(), $event->getGroupId(), $event->getTimestamp(), $event->getMessageId(), $event->getMessageType(), $event->getText());*/
    }
    /*else if($event instanceof \LINE\LINEBot\Event\MessageEvent\ImageMessage) {

        $response = $bot->getMessageContent($event->getMessageId());
        $fileUrl = uploadImageToCloudAppThenGetUrl($response->getRawBody());
        appendMessage($event->getUserId(), $event->getGroupId(), $event->getTimestamp(), $event->getMessageId(), $event->getMessageType(), $fileUrl);

    } else if($event instanceof \LINE\LINEBot\Event\MessageEvent\StickerMessage) {
        appendMessage($event->getUserId(), $event->getGroupId(), $event->getTimestamp(), $event->getMessageId(), $event->getMessageType(), json_encode(array('packageID' => $event->getPackageId(), 'stickerId' => $event->getStickerId())));
    } else {
        $bot->replyText($event->getReplyToken(), '未対応のメッセージ形式');
    }*/
}


/*$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
$response = $bot->replyMessage('<replyToken>', $textMessageBuilder);*/


/*echo $response->getHTTPStatus() . ' ' . $response->getRawBody();*/