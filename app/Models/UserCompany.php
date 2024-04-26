<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    use HasFactory;
    protected $table = 'user_company';
    protected $fillable = ['company_id', 'user_id', 'role'];

    public function users()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function company()
    {
        return $this->belongsTo(Company::class, "company_id");
    }
}
