<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestStep extends Model
{
    use HasFactory;
    protected $fillable = ['step_description', 'step_status', 'testcase_id'];

    public function testCase()
    {
        return $this->belongsTo(TestCase::class);
    }

    public function expectedResult()
    {
        return $this->hasOne(ExpectedResult::class);
    }
}
