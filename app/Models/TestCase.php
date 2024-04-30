<?php

namespace App\Models;

use App\Models\User;
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
        return $this->hasMany(TestStep::class, "testcase_id");
    }

    public function tester()
    {
        return $this->belongsTo(User::class, 'tester_id');
    }
}
