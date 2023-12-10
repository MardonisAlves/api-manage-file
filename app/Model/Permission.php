<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permission extends Model{

        protected $table = 'Permission';
        protected $fillable = [ 'permission', 'description'];


        public function user(): BelongsTo{
                return $this->belongsTo(User::class);
            }
}
