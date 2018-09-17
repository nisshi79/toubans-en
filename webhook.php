<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/09/14
 * Time: 2:47
 */

use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;
use LINE\LINEBot\Exception\InvalidEventRequestException;
use LINE\LINEBot\Exception\InvalidSignatureException;

$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('TOUBAN_BOT_CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('TOUBAN_BOT_CHANNEL_SECRET')]);
$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

try {
    $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
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

        if($event->getText() == '当番' || $event instanceof \LINE\LINEBot\Event\JoinEvent) {
            $flexContents= <<< JSON
            {
              "type": "bubble",
              "body": {
                "type": "box",
                "layout": "vertical",
                "contents": [
                  {
                    "type": "text",
                    "text": "Toubans! -当番通知Bot",
                    "weight": "bold",
                    "size": "xl"
                  }
                ]
              },
              "footer": {
                "type": "box",
                "layout": "vertical",
                "spacing": "sm",
                "contents": [
                  {
                    "type": "button",
                    "style": "link",
                    "height": "sm",
                    "action": {
                      "type": "uri",
                      "label": "初期設定/情報確認・変更",
                      "uri": "line://app/1603349366-7OnYqWO"
                    }
                  },
                  {
                    "type": "button",
                    "style": "link",
                    "height": "sm",
                    "action": {
                      "type": "uri",
                      "label": "今日の通知を停止する",
                      "uri": "https://linecorp.com"
                    }
                  },
                  {
                    "type": "button",
                    "style": "link",
                    "height": "sm",
                    "action": {
                      "type": "uri",
                      "label": "明日の通知を停止する",
                      "uri": "https://linecorp.com"
                    }
                  },
                  {
                    "type": "button",
                    "style": "link",
                    "height": "sm",
                    "action": {
                      "type": "uri",
                      "label": "期間を指定して通知を停止する",
                      "uri": "https://linecorp.com"
                    }
                  },
                  {
                    "type": "spacer",
                    "size": "sm"
                  }
                ],
                "flex": 0
              }
            }
JSON;
            $messageData= <<< JSON
                "type" => "flex",
                "contents" => {$flexContents}
            ];
JSON;
            $introduction='';
            if($event instanceof \LINE\LINEBot\Event\JoinEvent){
                $introduction= <<<JSON
                {
                    "type" => "text",
                    "text" => "下の「初期設定/情報確認・変更」をタップして、初期設定を開始してください"
                },
JSON;
            }

            $response = <<<JSON
            {
                "replyToken":{$event->getReplyToken()},
                "messages":[
                    {$introduction}
                    {
                        {$messageData}
                    }
                ]
            }
JSON;
            // LINE BOT API へのリクエストを作成して実行
            $curl = curl_init("https://api.line.me/v2/bot/message/reply");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($conn, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.getenv('TOUBAN_BOT_CHANNEL_ACCESS_TOKEN'),'Content-type: application/json'));
            curl_setopt($curl, CURLOPT_POSTFIELDS, $response);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            error_log($result);
            curl_close($ch);
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

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
$response = $bot->replyMessage('<replyToken>', $textMessageBuilder);


echo $response->getHTTPStatus() . ' ' . $response->getRawBody();


