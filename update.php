<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/09/09
 * Time: 12:57
 */
require_once ('vendor/autoload.php');
require_once ('bootstrap.php');
require_once ('Table.php');
require_once ('Role.php');
require_once ('Member.php');
$inputs = filter_input_array(INPUT_POST);
use Carbon\Carbon;
$table = \Model\Table::find($inputs['table_id']);

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
        //週
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

$table->update([
    'top_textarea' => $top_textarea_buf,
    'notification_span'=> $inputs['notification_span'],
    'notification_date' => $notification_date_buf,
    'notification_time' => $inputs['notification_time'],
    'sent_count' => '0',
    'lower_textarea' => $lower_textarea_buf
]);

$table->role()->delete();
$i = 0;
foreach ($inputs['roles_list'] as $roles_list){
    $i++;
    $role = \Model\Role::create([
        'role' => $roles_list,
        'role_id' => $i,
        'table_id' => $table['id']
    ]);
}

$table->member()->delete();
$i = 0;
foreach ($inputs['members_list'] as $members_list){
    $i++;
    $member = \Model\Member::create([
        'member' => $members_list,
        'member_id' => $i,
        'table_id' => $table['id']
    ]);
}
/*foreach ($tableArray as $table ) {
    $table=
}*/
?>
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
        <h1><a class="gradation big_font">Complete!</a></h1>
        <a class="large_font">おめでとうございます！設定を変更しました！<br>あとは通知を待つだけでOKです！<br>右上の×ボタンから、この画面を閉じて下さい。</a>
    </div>
</div>

</body>
</html>
