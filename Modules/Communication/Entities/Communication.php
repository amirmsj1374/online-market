<?php

namespace Modules\Communication\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Communication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'communicationable_id',
        'communicationable_type',
        'approved',
        'is_response',
        'parent_id',
        'comment'
    ];

    protected static function newFactory()
    {
        return \Modules\Communication\Database\factories\CommunicationFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Communication::class, 'id', 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(Communication::class, 'parent_id', 'id');
    }

    public function communicationable()
    {
        return $this->morphTo();
    }
}
