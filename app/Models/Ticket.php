<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $primaryKey = 'id';
    protected $fillable = [
        'number',
        'title',
        'type',
        'assigned_to',
        'description',
        'label',
        'project',
        'order'
    ];
}
