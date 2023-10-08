<?php
namespace App\Model;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Endress extends Model {
    protected $table = 'Endress';
    protected $fillable = ['rua'];

    public function endress(){
        return $this->hasOne(User::class );
    }
}
