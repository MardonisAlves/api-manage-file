<?php
namespace App\Model;
use App\Model\Endress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model {
    protected $table = 'User';
    protected $fillable = ['name', 'email','typeuser', 'password'];

    public function endress(): HasOne{
        return $this->hasOne(Endress::class, 'userId');
    }
}
