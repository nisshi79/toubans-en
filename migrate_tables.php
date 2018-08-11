<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/07/27
 * Time: 14:00
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
Capsule::schema()->create('tables', function (Blueprint $table) {
    $table->increments('id');
    $table->string('title');
    $table->integer('block_size');
    $table->string('avaliable_term');
    $table->integer('notification_date');
    $table->time('notification_time');
    $table->dateTime('last_notified_at');
    $table->unsignedBigInteger('sent_count');
    $table->string('group_id');
    $table->timestamps();
});

