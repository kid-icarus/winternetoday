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
  $data = array(
    'link' => 'http://qwerqwer.com',
    'twitter_ids' => array('402987048086142976', '402982981067104256'),
  );
  return json_encode($data);
});


Route::get('/cron', function() {
    return 'cron';

});


Route::get('/tweets/{q?}', function($q = NULL) {

  

  $tweet_model = App::make('Tweet');
$tweets = $tweet_model->getTweets($q);
  
var_dump($tweets);
  

});


