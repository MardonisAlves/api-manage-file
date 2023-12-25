<?php
namespace App\Model;
use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Upload extends Model {
    protected $table = 'Upload';
    protected $fillable = ['path', 'url','thumbnailUrl', 'fileId'];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

}
