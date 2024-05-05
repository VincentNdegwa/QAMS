<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'user_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_company')->withPivot('role');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function userCompany()
    {
        return $this->hasMany(UserCompany::class, "company_id");
    }
}
