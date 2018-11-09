<?php
/**
 * Created by IntelliJ IDEA.
 * User: yui
 * Date: 2018/10/31
 * Time: 12:41
 */
require_once ('vendor/autoload.php');
require_once ('bootstrap.php');
require_once ('Table.php');
require_once ('Role.php');
require_once ('Member.php');

$groupId = filter_input(INPUT_GET, 'groupId');
$foundToubans = \Model\Table::where('group_id', $groupId)
->orderBy('id')
->get();

header('Content-Type: application/json');

$jsonBuf = array();

foreach($foundToubans as $foundTouban){
    $toubanBuf = array(
        'table' => $foundTouban,
        'role' => $foundTouban->role,
        'member' => $foundTouban->member
    );
    array_push($jsonBuf, $toubanBuf);
}

echo json_encode($jsonBuf);
