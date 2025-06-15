<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Module;
class Course extends Model
{
    protected $fillable = ['name', 'description', 'category'];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

}
