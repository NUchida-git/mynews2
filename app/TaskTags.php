<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskTags extends Model
{
    protected $guarded = array('id');

    // 以下を追記
    public static $rules = array(
        'task_id' => 'required',
        'tag_id' => 'required',
    );
}
