<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Tweet extends Eloquent {

  /**
  * The database table used by the model.
  *
  * @var string
  */
  protected $table = 'tweets';
  
  function __construct() {
    $config = Config::get('twitter');
    $this->twitter = App::make('Thujohn\Twitter\Twitter');
    $this->twitter->reconfigure($config);
  }

  function getTweets($q = NULL) {

    $q = $q == NULL ? ' "wins the internet" OR "win the internet" OR "won the internet" ' : $q;

    $tweets = array();
    $tweet_data = $this->twitter->getSearch(array('q' => $q, 'lang'=>'en', 'count' => 2000, 'format' => 'object'))->statuses;
  
    foreach($tweet_data as $tweet) {
      $tweets[] = array(
        'tweet_id' => $tweet->id_str,
        'tweet' => $tweet->text,
        'twitter_user_id' => $tweet->user->id_str,
        'screen_name' => $tweet->user->screen_name,
        'tweet_id' => $tweet->id_str,
        'favorite_count' => $tweet->favorite_count ,
        'followers_count' => $tweet->user->followers_count ,
        'retweet_count' => $tweet->retweet_count ,
        'tweet_score' => $this->calculateScore(array(
          'favorites' => $tweet->favorite_count, 
          'retweets' => $tweet->retweet_count, 
          'followers' => $tweet->user->followers_count
          )
        )
      );
    }

  usort($tweets, function($a, $b) {
    if ($a['tweet_score'] == $b['tweet_score']) {
        return 0;
    }
    return ($a['tweet_score'] < $b['tweet_score']) ? 1 : -1;
    }
  );
  return $tweets;    
  }
 
  protected function calculateScore($params) {
    $score = 500;
    $score += $params['favorites'] * 100;
    $score += $params['retweets'] * 100;
    $len = strlen($params['followers']);
    $score +=  50 * $len;

    return $score; 
  }
 
}