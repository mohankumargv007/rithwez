<?php

namespace App\Modules\Answers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Sofa\Revisionable\Laravel\Revisionable;

class Answers extends Model
{
    use Notifiable;
    protected $table = 'answers';
    
}
