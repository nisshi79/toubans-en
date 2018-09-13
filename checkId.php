<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/09/10
 * Time: 17:31
 */
require_once ('vendor/autoload.php');
require_once ('bootstrap.php');
require_once ('Table.php');
require_once ('Role.php');
require_once ('Member.php');

$groupId = filter_input(INPUT_GET, 'groupId');
$foundTouban = \Model\Table::where('group_id', $groupId)
    ->first();

header('Content-Type: application/json');

$jsonBuf = array(
    'table' => $foundTouban,
    'role' => $foundTouban->role,
    'member' => $foundTouban->member
);



echo json_encode($jsonBuf);