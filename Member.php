<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/07/29
 * Time: 0:23
 */
namespace Model;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Member extends EloquentModel
{
    protected $guarded = ['id'];
    public function table()
    {
        return $this->belongsTo('Model\Table');
    }
}