<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/07/29
 * Time: 0:14
 */
namespace Model;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Table extends EloquentModel
{
    protected $guarded = ['id'];
    public function member()
    {
        return $this->hasMany('Model\Member');
    }
    public function role()
    {
        return $this->hasMany('Model\Role');
    }
}