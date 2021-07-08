<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $table = 'sections';
    protected $fillable = [
        'name',
        'parent_id',
    ];
    public function testCases()
    {
        return $this->hasMany(TestCase::class);
    }
    // public function Sections()
    // {
    //     return $this->hasMany(Section::class,'parent_id');
    // }
    // public function children()
    // {
    //     return $this->hasMany(Section::class,'parent_id')->with('Sections');
    // }
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function grandchildren()
    {
        return $this->children()->with('grandchildren');
    }
}
