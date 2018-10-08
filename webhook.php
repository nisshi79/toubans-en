<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/09/14
 * Time: 2:47
 */
require ('vendor/autoload.php');
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

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
    if (!($event instanceof \LINE\LINEBot\Event\MessageEvent) && !($event instanceof \LINE\LINEBot\Event\JoinEvent)) {
        error_log('Non message or join event has come');
        continue;
    }

    /*if(!$event->isGroupEvent()) {
        $bot->replyText($event->getReplyToken(), 'Add this Bot to Group.');
        continue;
    }*/

    if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage || $event instanceof \LINE\LINEBot\Event\JoinEvent) {
        if($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage){
            if($event->getText() == '当番') $sendFlag=true;
        }
        if($event instanceof \LINE\LINEBot\Event\JoinEvent)$sendFlag=true;

        if($sendFlag) {
            $flexContents=file_get_contents('./flexMessageMenu.json');
            $flexData= <<< JSON
            {
                "type" : "flex",
                "altText": "Toubans! メニュー",
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
                    "text" : "下の「設定画面を開く」をタップして、初期設定を開始してください"
                },
JSON;
            }

            $response = <<<JSON
            {
                "replyToken":"{$event->getReplyToken()}",
                "messages":[
                $introduction
                    $flexData
                ]
            }
JSON;
            /*error_log($response);*/
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