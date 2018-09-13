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
$table = \Model\Table::where('group_id', $groupId)
    ->first();

echo 'update!';

switch ($inputs['notification_span']){
    //日
    case 0:
        $notification_date_buf = implode(',',$inputs['notification_dsoW']);

        break;
    //週
    case 1:
        $notification_date_buf = $inputs['notification_doM'];

        break;

    default:
        break;
}


$table->update([
    'top_textarea' => $inputs['top_textarea'],
    'notification_span'=> $inputs['notification_span'],
    'notification_date' => $notification_date_buf,
    'notification_time' => $inputs['notification_time'],
    'sent_count' => '0',
    'lower_textarea' => $inputs['lower_textarea']
]);

$table->role->delete();
$i = 0;
foreach ($inputs['roles_list'] as $roles_list){
    $i++;
    $role = \Model\Role::create([
        'role' => $roles_list,
        'role_id' => $i,
        'table_id' => $table['id']
    ]);
}

$table->member->delete();
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