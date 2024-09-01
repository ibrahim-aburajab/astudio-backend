<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Project;
use App\Models\User;

class ProjectUser extends Model
{
    use HasFactory;

    protected $table = 'project_user';
    protected $with = ['users','projects'];


    public function User()
    {
        return $this->belongsTo('Users');
    }

    public function Project()
    {
        return $this->belongsTo('Projects');
    }
}
