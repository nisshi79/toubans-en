<?php
/**
 * Created by PhpStorm.
 * User: yui
 * Date: 2018/07/22
 * Time: 16:15
 */


namespace Models;
/*require_once 'bootstrap.php';*/

use Illuminate\Database\Eloquent\Model;

class User extends Model{
    protected $fillable = ['email'];
}