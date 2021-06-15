<?php

namespace App\Modules\Votes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Sofa\Revisionable\Laravel\Revisionable;

class UserVotes extends Model
{
    use Notifiable;
    protected $table = 'votes';
    
}