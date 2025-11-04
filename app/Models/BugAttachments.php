<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BugAttachments extends Model
{
    protected $table = 'bug_attachments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'bug_id',
        'file_path',
        'uploaded_by',
    ];

    public function bugs()
    {
        return $this->belongsTo(Bugs::class, 'bug_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
