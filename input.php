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
if($inputs['notification_timing_number_sign']=='-1') {
    $notification_timing_buffer = $inputs['notification_timing_avsolute_value'] * $inputs['notification_timing_number_sign'];
}elseif($inputs['notification_timing_number_sign']=='0'){
    $notification_timing_buffer = $inputs['notification_timing_number_sign'];
}

switch ($inputs['block_size_radio']){
    case 0:
        $avaliable_buffer = implode(',',$inputs['avaliable_days_of_week']);
        break;

    case 1:
        break;

    case 2:
        $avaliable_buffer = implode(',',$inputs['avaliable_months_of_year']);
        break;

    default:
        break;
}

$table = \Model\Table::create([
    'title' => $inputs['title'],
    'block_size' => $inputs['block_size_radio'],
    'avaliable' => $avaliable_buffer,
    'notification_date' => $notification_timing_buffer,
    'notification_time' => $inputs['notification_time'],
    'group_id' => $inputs['group_id']
]);

$i = 0;
foreach ($inputs['roles_list'] as $roles_list){
    $i++;
    $role = \Model\Role::create([
        'role' => $roles_list,
        'roles_id' => $i,
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