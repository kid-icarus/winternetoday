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
  
  protected $touches = array('day');
  
  public function post() {
    return $this->belongsTo('Day');
  }

  public function day() {
    return $this->hasOne('Day');
  }
 
}