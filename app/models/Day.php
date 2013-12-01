<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Day extends Eloquent {

  /**
  * The database table used by the model.
  *
  * @var string
  */
  protected $table = 'tweets';
  
  public function post() {
    return $this->belongsTo('Day');
  }
 
}