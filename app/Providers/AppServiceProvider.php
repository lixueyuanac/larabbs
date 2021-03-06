<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {
		//
		\Carbon\Carbon::setLocale('zh');

		\App\Models\Topic::observe(\App\Observers\TopicObserver::class);
		\App\Models\Reply::observe(\App\Observers\ReplyObserver::class);
		\App\Models\User::observe(\App\Observers\UserObserver::class);
		\App\Models\Link::observe(\App\Observers\LinkObserver::class);
		Schema::defaultStringLength(191);


	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
		if (app()->isLocal()) {
			$this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
		}
//		\API::error(function (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
//			abort(404);
//		});
//		\API::error(function (\Illuminate\Auth\Access\AuthorizationException $exception) {
//			abort(403, $exception->getMessage());
//		});
	}
}
