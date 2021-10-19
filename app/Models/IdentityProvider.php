<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class IdentityProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
