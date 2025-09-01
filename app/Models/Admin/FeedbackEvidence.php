<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class FeedbackEvidence extends Model
{
    protected $table = 'feedback_evidences';

    protected $fillable = [
        'feedback_id',
        'type',
        'content',
        'original_name',
        'size',
        'user_id',
    ];

    /**
     * Feedback ao qual a evidência pertence
     */
    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }

    /**
     * Usuário que enviou a evidência
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
