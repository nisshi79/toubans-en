<?php header( 'Location: /index.html' ) ;

require ('vendor/autoload.php');
/*require_once 'bootstrap.php';*/

http_response_code( 200 ) ;
$request = "php://input";

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv("LineMessageAPIChannelAccessToken"));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv("LineMessageAPIChannelSecret")]);

$channelSecret = getenv('LineMessageAPIChannelSecret'); // Channel secret string
$httpRequestBody = json_decode(file_get_contents('php://input'),true); // Request body string
$hash = hash_hmac('sha256', $httpRequestBody, $channelSecret, true);
$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$body = file_get_contents('php://input');