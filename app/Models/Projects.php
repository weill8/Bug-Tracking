<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Projects extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $fillable = [
        'project_name',
        'description',
    ];

    public $timestamps = true;

        public function bugs()
    {
        return $this->hasMany(Bugs::class);
    }
}
