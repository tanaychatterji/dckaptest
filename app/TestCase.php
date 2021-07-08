<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    protected $table = 'test_cases';
    protected $fillable = [
        'section_id',
        'summary',
        'description',
        'file'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
