<?php
/**
 * Created by IntelliJ IDEA.
 * User: yui
 * Date: 2018/11/13
 * Time: 13:32
 */

require_once ('vendor/autoload.php');
require_once ('bootstrap.php');
require_once ('Table.php');
require_once ('Role.php');
require_once ('Member.php');
$toubanId = filter_input(INPUT_GET, 'toubanId');
$groupId = filter_input(INPUT_GET, 'groupId');

use Carbon\Carbon;

$targetTouban = \Model\Table::find($toubanId);

if($groupId == $targetTouban['group_id'])\Model\Table::destroy($toubanId);

$foundToubans = \Model\Table::where('group_id', $groupId)
    ->orderBy('id')
    ->get();

header('Content-Type: application/json');


if(isset($foundToubans)){
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
}
