<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    use HasFactory;
    protected $table  = "testcases";
    protected $fillable = ['module_name', 'title', 'tester_id', 'status', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function testSteps()
    {
        return $this->hasMany(TestStep::class);
    }
}
