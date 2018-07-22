<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/07/22
 * Time: 16:12
 */

require_once 'bootstrap.php';

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('users', function ($table) {
    $table->increments('id');
    $table->string('email');
    $table->timestamps();
});