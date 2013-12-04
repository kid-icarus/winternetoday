<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/data/{date?}', function($date = NULL) {

  // Load winner from yesterday

  $data = array(
    'link' => 'http://qwerqwer.com',
    'twitter_ids' => array('402987048086142976', '402982981067104256'),
  );
  return json_encode($data);
});


Route::get('/cron', function() {

  // Load latest tweets

  return 'cron';

});

Route::get('/cron-daily', function() {

  // Only run once per day, after 11:30pm

  $top_tweet = Tweet::orderBy('link', 'DESC')
    ->where(DB::raw('DATE(tweet_created_at)'), '=', DB::raw('DATE(NOW())'))
    ->groupBy('link')
    ->take(1)
    ->get(array('link', DB::raw('sum(tweet_score) as total_score')));

  // Save top tweet to winner table

  return $top_tweet;

});


Route::get('/tweets/{q?}', function($q = NULL) {
  $tweet_model = App::make('Tweet');
  $tweets = $tweet_model->getTweets($q);
  var_dump($tweets);
});


