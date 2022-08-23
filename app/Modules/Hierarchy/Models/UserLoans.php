<?php

namespace App\Modules\Loans\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Sofa\Revisionable\Laravel\Revisionable;

class UserLoans extends Model
{
    use Notifiable;
    protected $table = 'user_loans';
    
}
