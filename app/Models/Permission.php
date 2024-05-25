<?php

namespace App\Models;

class Permission extends BaseModel
{
    protected $fillable = ['code','name','display_name', 'description','module','type','active'];

}
