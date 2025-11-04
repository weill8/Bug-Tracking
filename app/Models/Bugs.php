<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bugs extends Model
{
    protected $table = 'bugs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'priority',
        'status',
        'reported_by',
        'assigned_to',
    ];

    public $timestamps = true;

    public function projects()
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }

    public function reported()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function attachments()
    {
        return $this->hasMany(BugAttachments::class);
    }

    public function logs()
    {
        return $this->hasMany(BugLogs::class);
    }
}
