<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'transfer_id',
        'transferted_files',
        'email_to',
        'email_from',
        'subject',
        'message',
        'password',
        'expiry_time',
        'total_files',
        'spend_space',
        'storage_method',
        'tranfer_status',
        'create_method',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expiry_time' => 'datetime',
    ];

    /**
     * Get the user transfer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
