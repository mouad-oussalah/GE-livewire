<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'departement_id',
        'birthdate',
        'date_hired'
    ];


    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
    public function tasks()
{
    return $this->hasMany(Task::class);
}
}    
     