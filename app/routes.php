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


Route::get('/', function() {
    return 'nothing to see here... yet.';
});


Route::get('/cron', function() {
    return 'cron';
});


Route::get('/tweets/{q?}', function($q = NULL) {
  
  $tweet_model = App::make('Tweet');
  $twitter_api = $tweet_model->getAPI();

  $q = $q == NULL ? ' "wins the internet" OR "win the internet" OR "won the internet" ' : $q;

  $tweets = $tweet_model->getTweets($q);
var_dump($tweets);
exit;

$tweet = current($tweets);
$info = $twitter_api->getTweet($tweet['tweet_id']);

var_dump($info);
exit;

});


