<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpectedResult extends Model
{
    use HasFactory;
    protected $fillable = ['result_description', 'test_step_id', 'found_description', 'pass'];

    public function testStep()
    {
        return $this->belongsTo(TestStep::class);
    }

    public function foundResult()
    {
        return $this->hasOne(FoundResult::class);
    }
}
