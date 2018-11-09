<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/06/12
 * Time: 9:26
 */
require_once ('vendor/autoload.php');
require_once ('bootstrap.php');
require_once ('Table.php');
require_once ('Role.php');
require_once ('Member.php');

$inputs = filter_input_array(INPUT_POST);
use Carbon\Carbon;

//Pre-Processing
switch ($inputs['notification_span']){
    //日
    case 0:
        $notification_date_buf = implode(',',$inputs['notification_dsoW']);

        break;
    //月
    case 1:
        $notification_date_buf = $inputs['notification_doM'];

        break;
    case 2:
        $notification_date_buf = $inputs['notification_doW'];
        break;
    default:
        break;
}
if($inputs['top_textarea_select']=='（挨拶文を自分で入力する）'){
    $top_textarea_buf=$inputs['top_textarea'];
}else{
    $top_textarea_buf=$inputs['top_textarea_select'];
}

if($inputs['lower_textarea_select']=='（締めの文を自分で入力する）'){
    $lower_textarea_buf=$inputs['lower_textarea'];
}else{
    $lower_textarea_buf=$inputs['lower_textarea_select'];
}

$table = \Model\Table::create([
    'top_textarea' => $top_textarea_buf,
    'notification_span'=> $inputs['notification_span'],
    'notification_date' => $notification_date_buf,
    'notification_time' => $inputs['notification_time'],
    'last_notified_at' => Carbon::now(new DateTimeZone('Asia/Tokyo')),
    'group_id' => $inputs['group_id'],
    'sent_count' => '0',
    'lower_textarea' => $lower_textarea_buf
]);

$i = 0;
foreach ($inputs['roles_list'] as $roles_list){
    $i++;
    $role = \Model\Role::create([
        'role' => $roles_list,
        'role_id' => $i,
        'table_id' => $table['id']
    ]);
}

$i = 0;
foreach ($inputs['members_list'] as $members_list){
    $i++;
    $member = \Model\Member::create([
        'member' => $members_list,
        'member_id' => $i,
        'table_id' => $table['id']
    ]);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-Control" content="no-cache">

        <meta http-equiv="content-type" charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css?<?php echo date('Ymd-Hi'); ?>" type="text/css">
    </head>

    <body>
        <div class="screen_center">
            <div class="inner">
                <h1 class="bottom_margin"><a class="gradation big_font">Complete!</a></h1>
                <a class="bottom_margin large_font">おめでとうございます！これで設定は完了です！<br>あとは通知を待つだけでOKです！<br>右上の×ボタンから、この画面を閉じて下さい。</a>
            </div>
        </div>

    </body>
</html>