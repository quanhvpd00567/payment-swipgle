<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'generate_id',
        'user_id',
        'space',
        'method',
        'payment_id',
        'amount',
        'currency',
    ];

    /**
     * Get the user transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
