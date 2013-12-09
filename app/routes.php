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

  $tweet_model = App::make('Tweet');
  $tweets = $tweet_model->getTweets('"wins the internet" OR "win the internet" OR "won the internet"');
  var_dump($tweets);

});

Route::get('/cron-daily', function() {

  // Only run once per day, after 11:30pm

  /*
if (date('H:i') < '23:00') {
    return;
  }
*/

  $top_tweet = Tweet::orderBy('total_score', 'DESC')
    ->where(DB::raw('DATE(tweet_created_at)'), '=', DB::raw('DATE(NOW())'))
    ->groupBy('link')
    ->take(1)
    ->get(array('link', DB::raw('sum(tweet_score) as total_score')));

  // Save top tweet to winner table

  // Not sure why this isn't working:

/*
  $day = DB::table('winners')->where('date', date('Y-m-d'))->first();
  $eloquent_winner = $day != NULL ? Day::find($day->id) : App::make('Day');
  $eloquent_winner->link = $top_tweet->link;
  $eloquent_winner->date = date('Y-m-d');
  $eloquent_winner->save();
*/

  return $top_tweet;

});


Route::get('/tweets/{q?}', function($q = NULL) {
  $tweet_model = App::make('Tweet');
  $tweets = $tweet_model->getTweets($q);
  var_dump($tweets);
});


