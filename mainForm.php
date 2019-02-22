<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">

    <meta http-equiv="content-type" charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Toubans! Preferences</title>

    <link rel="stylesheet" href="style.css?<?php echo date('Ymd-Hi'); ?>" type="text/css">
    <link rel="stylesheet" href="modaal.css" type="text/css">
</head>

<body>
<h1 class="center margin_top"><a id="title" class="gradation">Toubans! Preferences</a></h1>
<a class="alert-for-ios large_font">To iOS (iPhone, iPad, iPod) users:<br>
    Make sure that your LINE app has been updated to the latest version.<br>
    This service doesn’t function properly if the LINE app version is not the latest.</a>
<form name = "tableInfo" method = "POST" action="input.php">
    <input type="hidden" id="group_id" value="" name="group_id">
    <div id="table_id_container"></div>
    <h2><a class="gradation xlarge_font">1. What to include in notifications: </a></h2>

    <!-- ▼LINE風ここから -->
    <div class="line__container">
        <!-- タイトル -->
        <!--<div class="line__title">
            メッセージのイメージ
        </div>-->
        <div class="form line__contents relax_container">
            <div class="line__left">
                <figure>
                    <img class="shadow" src="pic/icon.png"/>
                </figure>
                <div class="line__left-text">
                    <div class="name">Toubans!</div>
                    <div class="text shadow">
                        <h3><label for="top_textarea" class="gradation large_font">1. First line</label></h3>
                        <select name="top_textarea_select" id="top_textarea_select" class="large_font pulldownmenu">
                            <option value="">(Select)</option>
                            <option value="今日の当番のお知らせです">Notification of today's duty.</option>
                            <option value="明日の当番のお知らせです">Notification of tomorrow's duty.</option>
                            <option value="（挨拶文を自分で入力する）">(Write original message.)</option>
                        </select><br>
                        <input type="text" name="top_textarea" id="top_textarea" class="text_area large_font" placeholder="例）今日の当番のお知らせです"><br><br>

                        <h3><a class="gradation large_font">2.Content of duties</a></h3><br><br>
                        <a href="#touban_modal" class="modal btn large_font">Tap for setup.</a><br>

                        <div id="touban_modal" class="touban_container" style="display: none;">
                            <h3 class="no-margin-bottom"><a class="gradation xlarge_font">1. Enter duty name(s).</a></h3>

                            <div class = "roles">
                                <!--<a class="bold">役割</a><br>-->
                                <ol id="roles_list" class="touban_list_container large_font"><!-- "id" attribute is required -->
                                    <li class="roles_list_var"><!-- .(id)_var -->
                                        <div class="touban_form">
                                            <input type="text" data-name-format="roles_list[]" name="roles_list[]" id="roles_list_0" placeholder="e.g. &quot;Laundry&quot;" class="text_area touban_text_area large_font vertical_fat">
                                            <button class="roles_list_del btn nowrap vertical_slim"><a class="nowrap large_font">Delete</a></button><!-- .(id)_del -->
                                        </div>
                                    </li>
                                </ol>
                                <a href="javascript:void(0)" id="roles_list_add" class="roles_list_add btn roles_add_btn large_font">Add duty</a>
                            </div>

                            <br><br>

                            <h3 class="no-margin-bottom"><a class="gradation xlarge_font">2. Enter member name(s).</a></h3>
                            <a class="large_font">*Tap the "Add duty" button to add member(s). Duties will be rotated in numerical order.<!--※メンバー追加ボタンを押して、当番を回したい全てのメンバー（班）の名前を入力します。--></a><br><br>
                            <div class="members">
                                <!--<a class="bold">メンバー</a><br>-->
                                <ol id="members_list" class="touban_list_container large_font"><!-- "id" attribute is required -->
                                    <li class="members_list_var"><!-- .(id)_var -->
                                        <div class="touban_form">
                                            <input type="text" data-name-format="members_list[]" name="members_list[]" id="members_list_0" placeholder="e.g &quot;Group A&quot;" class="text_area touban_text_area large_font vertical_fat">
                                            <button class="members_list_del btn vertical_slim"><a class="nowrap large_font">Delete</a></button><!-- .(id)_del -->
                                        </div>
                                    </li>
                                </ol>
                                <a href="javascript:void(0)" id="members_list_add" class="members_list_add btn members_add_btn large_font">Add member</a>
                            </div>

                            <br>


                            <h3><a href="javascript:void(0)" class="button" id="modaal_close">Done</a></h3>
                        </div>

                        <!--<a>回し方</a><br>
                        <input type="radio" id="block_size_day" name="block_size_radio" value="0" checked><label for="block_size_day">日</label>
                        <input type="radio" id="block_size_week" name="block_size_radio" value="1"><label for="block_size_week">週</label>
                        <input type="radio" id="block_size_month" name="block_size_radio" value="2"><label for="block_size_month">月</label><br>-->
                        <br><br><h3><label for="lower_textarea" class="gradation large_font">3. Closing remark</label></h3>
                        <select name="lower_textarea_select" id="lower_textarea_select" class="large_font pulldownmenu">
                            <option value="">(Select)</option>
                            <option value="Thanks!">Thanks!</option>
                            <option value="A friendly reminder!">A friendly reminder!</option>
                            <option value="（締めの文を自分で入力する）">（Write original message.）</option>
                        </select><br>
                        <input type="text" name="lower_textarea" id="lower_textarea" class="text_area large_font" placeholder="e.g &quot;Thanks.&quot;">
                    </div>

                    <br>
                </div>
            </div>
        </div>
    </div>

    <br>

        <div class="notification_settings">


            <div class="notification_date_container">
                <h2><a class="gradation xlarge_font">2. Timing to notify:</a></h2><br>
                <h3><a class="gradation large_font">1. Day(s)</a></h3>
                <select name="notification_span" id="notification_span" class="large_font">
                    <option value="3">（Set notification cycle）</option>
                    <option value="0">Once a day（Select day[s] of week.）</option>
                    <option value="2">Once a week（Select day of week.)</option>
                    <option value="1">Once a month（Select day of month.)</option>
                </select>
                <!--曜日を選んだときの通知設定-->
                <div class="notification_dsoW large_font"><br><a>Select day[s] of week.<!--通知を行う曜日を選択して下さい(複数選択可)--></a><br>
                    <div class="notification_dsoW_checkboxes checkboxes">
                        <input type="checkbox" id="checkbox_sunday" name="notification_dsoW[]" class="checkbox notification_dsoW_checkbox transition" value="0">
                        <label class="checkbox_label" for="checkbox_sunday">Sun</label>
                        <input type="checkbox" id="checkbox_monday" name="notification_dsoW[]" value="1" class="checkbox transition notification_dsoW_checkbox">
                        <label class="checkbox_label" for="checkbox_monday">Mon</label>
                        <input type="checkbox" id="checkbox_tuesday" name="notification_dsoW[]" value="2" class="checkbox transition notification_dsoW_checkbox">
                        <label class="checkbox_label" for="checkbox_tuesday">Tue</label>
                        <input type="checkbox" id="checkbox_wednesday" name="notification_dsoW[]" value="3" class="checkbox transition notification_dsoW_checkbox">
                        <label class="checkbox_label" for="checkbox_wednesday">Wed</label>
                        <input type="checkbox" id="checkbox_thursday" name="notification_dsoW[]" value="4" class="checkbox transition notification_dsoW_checkbox">
                        <label class="checkbox_label" for="checkbox_thursday">Thu</label>
                        <input type="checkbox" id="checkbox_friday" name="notification_dsoW[]" value="5" class="checkbox transition notification_dsoW_checkbox">
                        <label class="checkbox_label" for="checkbox_friday">Fri</label>
                        <input type="checkbox" id="checkbox_saturday" name="notification_dsoW[]" class="checkbox transition notification_dsoW_checkbox" value="6">
                        <label class="checkbox_label" for="checkbox_saturday">Sat</label>
                    </div>
                </div>


                <!--週を選んだときの通知設定-->
                <div class="notification_doW large_font">
                    <br><a>Select day of week.<!--通知を行う曜日を選択して下さい--></a><br>
                    <div class="notification_doW_radios">

                        <input type="radio" id="radio_sunday" name="notification_doW"  value="0"><label for="radio_sunday" class="radio_label">Sun</label>
                        <input type="radio" id="radio_monday" name="notification_doW" value="1"><label for="radio_monday" class="radio_label">Mon</label>
                        <input type="radio" id="radio_tuesday" name="notification_doW" value="2"><label for="radio_tuesday" class="radio_label">Tue</label>
                        <input type="radio" id="radio_wednesday" name="notification_doW" value="3"><label for="radio_wednesday" class="radio_label">Wed</label>
                        <input type="radio" id="radio_thursday" name="notification_doW" value="4"><label for="radio_thursday" class="radio_label">Thu</label>
                        <input type="radio" id="radio_friday" name="notification_doW" value="5"><label for="radio_friday" class="radio_label">Fri</label>
                        <input type="radio" id="radio_saturday" name="notification_doW" value="6"><label for="radio_saturday" class="radio_label">Sat</label>
                    </div>
                </div>


                <!--月を選んだときの通知設定-->
                <div class="notification_doM large_font">
                    <br>
                        <!--<a>通知する月を選択して下さい</a><br>
                        <input type="checkbox" id="january" name="notification_months[]" value="1" checked><label for="january">1月</label>
                        <input type="checkbox" id="february" name="notification_months[]" value="2" checked><label for="february">2月</label>
                        <input type="checkbox" id="march" name="notification_months[]" value="3" checked><label for="march">3月</label>
                        <input type="checkbox" id="april" name="notification_months[]" value="4" checked><label for="april">4月</label>
                        <input type="checkbox" id="may" name="notification_months[]" value="5" checked><label for="may">5月</label>
                        <input type="checkbox" id="june" name="notification_months[]" value="6" checked><label for="june">6月</label>
                        <input type="checkbox" id="july" name="notification_months[]" value="7" checked><label for="july">7月</label>
                        <input type="checkbox" id="august" name="notification_months[]" value="8" checked><label for="august">8月</label>
                        <input type="checkbox" id="september" name="notification_months[]" value="9" checked><label for="september">9月</label>
                        <input type="checkbox" id="october" name="notification_months[]" value="10" checked><label for="october">10月</label>
                        <input type="checkbox" id="november" name="notification_months[]" value="11" checked><label for="november">11月</label>
                        <input type="checkbox" id="december" name="notification_months[]" value="12" checked><label for="december">12月</label>
                    <a>の</a>-->
                    <select name="notification_doM" id="notification_doM" class="large_font">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                    </select><br>
                    <a>
                        *If a date not in that month is specified, it will automatically be the end of the month.<br>
                        e.g. If you select 31, the notification will be made on 30 in June.例)31日を指定した場合、6月は30日に通知が行われる
                    </a>
                </div>

                <h3><a class="gradation large_font">2. Time</a></h3>

                <input type="time" id="notification_time" name="notification_time" class="large_font">

            </div>
        </div><br>

        <div class="gradation_button" id="submit-button">
            <button type="submit" class="button"><a>All Done!</a></button>
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

<!--scripts-->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.add-input-area@4.11.0/dist/jquery.add-input-area.min.js"></script>
<script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.12.0/validate.min.js"></script>
<script src="autosize.js"></script>
<script src="script.js"></script>
<!--<script src="liff-starter.js"></script>-->
<script src="modaal.min.js"></script>
<script src="jquery.add-input-area.min.js"></script>
</body>