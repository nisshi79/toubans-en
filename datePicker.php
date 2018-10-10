<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/10/08
 * Time: 12:53
 */

?>
<!DOCTYPE HTML>
<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">

    <meta http-equiv="content-type" charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- jquery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <!-- bootstrap -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.0/cosmo/bootstrap.min.css" />
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <!-- moment -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/locale/ja.js"></script>

    <!-- daterangepicker -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.18/daterangepicker.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.18/daterangepicker.min.js"></script>

    <link href="dist/css/datepicker.min.css" rel="stylesheet" type="text/css">
    <script src="dist/js/datepicker.min.js"></script>
    <!-- Include English language -->
    <script src="dist/js/i18n/datepicker.ja.js"></script>

    <link rel="stylesheet" href="style.css?<?php echo date('Ymd-Hi'); ?>" type="text/css">

</head>
<body>
    <form name = "spans" method = "GET" action="stopSpanInput.php">
        <div class = "spans">
            <h1><a class="gradation title">期間を設定して通知を停止</a></h1><br>
            <h2><a class="gradation">通知停止期間一覧</a></h2>
            <div class="center">
                <ol id="spans_list"><!-- "id" attribute is required -->
                    <li class="spans_list_var"><!-- .(id)_var -->

                        <input placeholder="ここをタップして日付を入力してください" type="text" data-name-format="spans_list[]" name="spans_list[]" id="spans_list_0" readonly="readonly" class="date_range_input">
                        <button class="spans_list_del btn nowrap vertical_slim"><a class="nowrap">削除</a></button><!-- .(id)_del -->

                    </li>
                </ol>
            </div>

            <a href="javascript:void(0)" id="spans_list_add" class="spans_list_add btn">通知停止期間を追加</a>
        </div>
        <input type="hidden" id="group_id" value="" name="group_id">


        <!--<script>
            $(function() {
                $('.date_range_input').daterangepicker({
                    opens: 'left'
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                });
            });
        </script>-->



        <div class="gradation_button" id="submit-button">
            <button type="submit" class="button"><a>設定完了</a></button>
        </div>
    </form>


    <div id="liffdata">
        <h2>LIFF Data</h2>
        <table border="1">
            <tr>
                <th>language</th>
                <td id="languagefield"></td>
            </tr>
            <tr>
                <th>context.viewType</th>
                <td id="viewtypefield"></td>
            </tr>
            <tr>
                <th>context.userId</th>
                <td id="useridfield"></td>
            </tr>
            <tr>
                <th>context.utouId</th>
                <td id="utouidfield"></td>
            </tr>
            <tr>
                <th>context.roomId</th>
                <td id="roomidfield"></td>
            </tr>
            <tr>
                <th>context.groupId</th>
                <td id="groupidfield"></td>
            </tr>
        </table>
    </div>



<script src="https://cdn.jsdelivr.net/npm/jquery.add-input-area@4.11.0/dist/jquery.add-input-area.min.js"></script>
    <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
    <script src="dateRangePicker.js"></script>
<script src="jquery.add-input-area.min.js"></script>
<script src="liff-starter-datePicker.js"></script>

<!--<script type="text/javascript" src="script.js"></script>-->

</body>
