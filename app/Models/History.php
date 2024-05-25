<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = ['historiable_id','historiable_type', 'value', 'new_value', 'user_id','active'];
    use HasFactory;

    public function historiable()
    {
        return $this->morphTo();
    }
    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeGetActive($query, $active = 1)
    {
        $query->where('active', $active);
    }
}
