<?php

namespace App\Models;

use App\Models\Topic;
use App\Models\User;

class Reply extends Model {
	protected $fillable = ['content', 'topic_id', 'user_id'];
	public function topic() {
		return $this->belongsTo(Topic::class);
	}

	public function user() {
		return $this->belongsTo(User::class);
	}
}
