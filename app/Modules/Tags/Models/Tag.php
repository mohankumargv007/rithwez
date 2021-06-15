<?php

namespace App\Modules\Tags\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Sofa\Revisionable\Laravel\Revisionable;

class Tag extends Model
{
    use Notifiable;
    protected $table = 'tags';
    
}
