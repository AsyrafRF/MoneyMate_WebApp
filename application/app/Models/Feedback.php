<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'rating',
        'feature_score',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function setCommentAttribute($value)
    {
        $this->attributes['comment'] = strip_tags($value);
    }
}
