<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;

class ReplyPolicy extends Policy {
	public function update(User $user, Reply $reply) {
		return $reply->user_id == $user->id;
		//return true;
	}

	publicfunction destroy(User $user, Reply $reply) {
        //return $reply->user_id == $user->id;
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
		//return true;
	}
}
