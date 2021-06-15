<?php

namespace App\Modules\Questions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Sofa\Revisionable\Laravel\Revisionable;

class Question extends Model
{
    use Notifiable;
    protected $table = 'questions';
    
}
