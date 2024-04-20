<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    use HasFactory;
    protected $fillable = ['module_name', 'title', 'tester_name', 'status', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function testSteps()
    {
        return $this->hasMany(TestStep::class);
    }
}
