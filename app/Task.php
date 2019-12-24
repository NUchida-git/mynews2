<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'name' => 'required',
    );
    
    const PRIORITY_LIST = [
        1 => '最低',
        2 => '低',
        3 => '中',
        4 => '高',
        5 => '最高'
    ];

    public function category()
    {
      return $this->belongsTo('App\Category')->withDefault();
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'task_tags')->withTimestamps();
    }

}
