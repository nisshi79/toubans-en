<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/10/08
 * Time: 13:27
 */
require_once ('vendor/autoload.php');
require_once ('bootstrap.php');
require_once ('Table.php');
require_once ('Role.php');
require_once ('Member.php');

$inputs = filter_input_array(INPUT_GET);
use Carbon\Carbon;

$table = \Model\Table::where('group_id', $inputs['group_id'])
    ->first();
/*var_dump($table);*/
//processing
/*var_dump(implode(',',$inputs['spans_list']));*/
$spans_buf = implode(',',$inputs['spans_list']);
$table->update([
    'stop_span' => $spans_buf
]);
?>
<!DOCTYPE HTML>
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
        <a class="bottom_margin">おめでとうございます！これで設定は完了です！右上の×ボタンから、この画面を閉じて下さい。</a>
    </div>
</div>

</body>
</html>
