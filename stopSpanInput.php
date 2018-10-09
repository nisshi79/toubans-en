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
var_dump($table);
//processing
var_dump(implode(',',$inputs['spans_list']));
$spans_buf = implode(',',$inputs['spans_list']);
$table->update([
    'stop_span' => $spans_buf
]);