<?php

namespace App\Models;

class Role extends BaseModel
{
    protected $fillable = ['code','name','display_name', 'description','all_roles','active'];


    public function users()
    {
        return $this->belongsToMany(User::class)->where('all_roles', 0)->using(RoleUser::class);
    }
}
