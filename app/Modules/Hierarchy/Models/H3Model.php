<?php

namespace App\Modules\Hierarchy\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Sofa\Revisionable\Laravel\Revisionable;

class H3Model extends Model
{
    use Notifiable;
    protected $table = 'h3_table';
    
}
