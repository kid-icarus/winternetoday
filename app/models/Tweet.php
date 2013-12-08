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
  protected $guarded = array('id');
  
  public static $max_id = 0;

  
  function __construct() {
  }

  function getAPI() {
    if ($this->twitter == NULL) {
      $config = Config::get('tweet');
      $this->twitter = App::make('Thujohn\Twitter\Twitter');
      $this->twitter->reconfigure($config);
    }
    return $this->twitter;
  }

  function getTweets($q = NULL) {
    $this->getAPI();

    $tweets = array();
    $tweet_data = $this->twitter->getSearch(array('q' => $q, 'lang'=>'en', 'count' => 2000, 'format' => 'object'))->statuses;

    foreach($tweet_data as $tweet) {
      Tweet::$max_id = $tweet->id_str;
      $tweets[] = array(
        'tweet_id' => $tweet->id_str,
        'tweet_created_at' => date('Y-m-d H:i:s', strtotime($tweet->created_at)),
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
    });

    foreach($tweets as $tweet) {
      $t = DB::table($this->table)->where('tweet_id', $tweet['tweet_id'])->first();
      $eloquent_tweet = $t != NULL ? Tweet::find($t->id) : new Tweet();
      foreach($tweet as $k => $v) {
        $eloquent_tweet->{$k} = $v;  
      }
      $eloquent_tweet->save(); 
    }
    return $tweets;
  }

  protected function removeDupes(&$tweets) {
    foreach($tweets as $key_outer => $tweet_outer) {
      foreach($tweets as $key_inner => $tweet_inner) {
        if ($tweet_outer['tweet_id'] == $tweet_inner['tweet_id']) {
          continue;
        }
        $str_outer = $tweet_outer['tweet'];
        $str_inner = $tweet_inner['tweet'];
        if ($str_outer == $str_inner) {
          if ($tweet_outer['created_at'] > $tweet_inner['created_at']) {
            unset($tweets[$key_outer]);
          }
          else {
            unset($tweets[$key_inner]);
          }
        }
      }
    }
  }

  protected function calculateScore($params) {
    $score = 500;
//    $score += $params['favorites'] * 100;
    $score += $params['retweets'] * 100;
    $len = strlen($params['followers']);
    $score +=  50 * $len;
    return $score; 
  }
 
}