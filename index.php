<?php

/*require ('vendor/autoload.php');*/
/*require_once 'bootstrap.php';*/

/*http_response_code( 200 ) ;*/
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css?<?php echo date('Ymd-Hi'); ?>" type="text/css">
        <link rel="stylesheet" href="index.css" type="text/css">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    </head>
    <body>
        <ul class="toubanList"></ul>
        <a class="add_touban large_font btn nowrap">当番を追加</a><!-- .(id)_del -->
<!--scripts-->
        <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
        <script src="getToubanList.js"></script>

    </body>
</html>

