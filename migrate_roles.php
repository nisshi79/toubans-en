<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/07/27
 * Time: 14:58
 */
require_once ('bootstrap.php');

/*use Illuminate\Support\Facades\Schema;*/
use Illuminate\Database\Schema\Blueprint;
/*use Illuminate\Database\Migrations\Migration;*/

use Illuminate\Database\Capsule\Manager as Capsule;
/**
 * マイグレーション実行
 *
 * @return void
 */
Capsule::schema()->create('roles', function (Blueprint $table) {
    $table->increments('id');
    $table->string('role');
    $table->foreign('table_id')
        ->references('id')
        ->on('tables');
});