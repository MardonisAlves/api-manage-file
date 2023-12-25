<?php
namespace App\Model;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Pathkit extends Model {
    protected $table = 'Pathkit';
    protected $fillable = ['path_file'];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

}
