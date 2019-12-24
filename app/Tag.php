<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = array('id');

    // 以下を追記
    public static $rules = array(
        'tag_id' => 'required',
    );
}
