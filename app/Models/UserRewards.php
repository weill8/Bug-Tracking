<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRewards extends Model
{
    protected $table = 'user_rewards';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'bugs_resolved',
        'date',
        'total_bonus',
    ];

    public $timestamps = true;

        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
