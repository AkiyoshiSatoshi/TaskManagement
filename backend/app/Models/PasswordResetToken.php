<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use HasFactory, Timestamp;

    public $timestamps = false;

    protected $primaryKey = 'email';

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];
}
