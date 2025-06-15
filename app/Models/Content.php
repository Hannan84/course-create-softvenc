<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Module;
class Content extends Model
{
    protected $fillable = ['module_id', 'type', 'value'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

}
