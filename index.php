<?php

/*require ('vendor/autoload.php');*/
/*require_once 'bootstrap.php';*/

/*http_response_code( 200 ) ;*/
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1">

        <link rel="stylesheet" href="style.css?<?php echo date('Ymd-Hi'); ?>" type="text/css">
        <link rel="stylesheet" href="index.css" type="text/css">
        <link rel="stylesheet" href="modaal.css">
    </head>
    <body>


    <h1 class="center margin_top"><a id="title" class="gradation">Duties in this thread</a></h1>


    <ul class="toubanList"></ul>
        <a class="add_touban large_font btn nowrap margin_top">Add Duty</a><!-- .(id)_del -->

        <!--scripts-->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
        <script src="getToubanList.js"></script>

    </body>
</html>

