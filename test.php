<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/07/19
 * Time: 22:19
 */
namespace Models;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model as EloquentModel;


class Test extends EloquentModel {
    protected $table = 'toubantable';
}

