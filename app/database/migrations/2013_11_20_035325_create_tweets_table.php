<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTweetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tweets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
      $table->datetime('tweet_created_at');
      $table->string('twitter_user_id');
      $table->string('screen_name');
      $table->string('tweet_id');
      $table->string('tweet');
      $table->string('link');
			$table->integer('favorite_count');
			$table->integer('retweet_count');
			$table->integer('followers_count');
			$table->float('tweet_score');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tweets');
	}

}
