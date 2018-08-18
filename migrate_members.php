<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/07/27
 * Time: 15:04
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
Capsule::schema()->create('members', function (Blueprint $table) {
    $table->increments('id');
    $table->string('member');
    $table->unsignedBigInteger('table_id');
    $table->unsignedBigInteger('member_id');
    $table->timestamps();

    $table->foreign('table_id')
        ->references('id')
        ->on('tables')
        ->onDelete('cascade');
});