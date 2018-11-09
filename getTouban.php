<?php
/**
 * Created by IntelliJ IDEA.
 * User: yui
 * Date: 2018/11/06
 * Time: 21:58
 */
require_once ('vendor/autoload.php');
require_once ('bootstrap.php');
require_once ('Table.php');
require_once ('Role.php');
require_once ('Member.php');

$tableId = filter_input(INPUT_GET, 'tableId');
$foundTouban = \Model\Table::find($tableId);

header('Content-Type: application/json');

$jsonBuf = array(
    'table' => $foundTouban,
    'role' => $foundTouban->role,
    'member' => $foundTouban->member
);


echo json_encode($jsonBuf);