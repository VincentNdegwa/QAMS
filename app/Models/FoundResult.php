<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoundResult extends Model
{
    use HasFactory;
    protected $fillable = ['result_description', 'expected_result_id'];

    public function expectedResult()
    {
        return $this->belongsTo(ExpectedResult::class);
    }
}
