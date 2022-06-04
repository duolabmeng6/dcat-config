<?php

namespace Ll\DcatConfig\Models;

use Illuminate\Database\Eloquent\Model;

class LlConfig extends Model
{
    protected $table= 'llconfig';
    public function setValueAttribute($value = null)
    {
        $this->attributes['value'] = is_null($value) ? '' : $value;
    }
}
