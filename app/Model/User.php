<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $table = 'User';
    protected $fillable = ['name', 'email'];
}
