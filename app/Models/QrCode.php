<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'image',
        'app_url',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
