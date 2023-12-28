<?php
namespace App\Model;
use App\Model\Endress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Model {
    protected $table = 'User';
    protected $fillable = ['name', 'email','typeuser', 'password'];

    public function endress(): HasOne{
        return $this->hasOne(Endress::class, 'userId');
    }

    public function permission(): HasOne{
        return $this->hasOne(Permission::class);
    }

    public function uploads(): HasMany{
        return $this->hasMany(Upload::class);
    }

    // public function paths(): HasMany{
    //     return $this->hasMany(Paths::class);
    // }

}
