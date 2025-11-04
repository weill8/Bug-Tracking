<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BugLogs extends Model
{
    protected $table = 'bug_logs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'bug_id',
        'changed_by',
        'new_status',
    ];

    public function bugs()
    {
        return $this->belongsTo(Bugs::class, 'bug_id');
    }

    public function changed()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
