<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;
abstract class BaseModel extends History
{
    public $timestamps = true;
    protected $hidden = [];
    protected $appends = ['date_created_working_day', 'date_updated_working_day','date_created'];

    public function DateCreatedWorkingDay(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->createdAt)->locale('es')->isoFormat('MMMM D YYYY, h:mm:ss a')
        );
    }
    public function DateCreated(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->createdAt)->format('Y-m-d')
        );
    }

    protected function updatedAt(): Attribute
    {
        return new Attribute(
            get: fn($value) => Carbon::parse($value, 'UTC') //con function flecha
        );
    }

    public function DateUpdatedWorkingDay(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->updatedAt)->locale('es')->isoFormat('MMMM D YYYY, h:mm:ss a')
        );
    }
    public function history(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(History::class, 'historiable');
    }

    //Mutators
    protected function name(): Attribute
    {
        return new Attribute(
            get: fn($value) => ucfirst($value), //con function flecha
            set: function($value) {
                return mb_strtoupper($value);
            }
        );
    }
    protected function description(): Attribute
    {
        return new Attribute(
            get: fn($value) => ucfirst($value), //con function flecha
            set: function($value) {
                return strtoupper($value);
            }
        );
    }

    protected function createdAt(): Attribute
    {
        return new Attribute(
            get: fn($value) => Carbon::parse($value, 'UTC') //con function flecha
        );
    }


}
