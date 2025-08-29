<?php

namespace App\Models\Admin;

use App\Enums\FeedbackStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'status',
        'user_id',
    ];

    protected $guarded = [];

    protected $casts = [
        'status' => FeedbackStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}