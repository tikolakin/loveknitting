<?php
/**
 * Provide a few tricks to wait for sth.
 */

trait HelpTrait {

  /**
   * Spin right round baby right round.
   */
  public function spin($lambda, $wait = 40) {
    $message = '';
    for ($i = 0; $i < $wait; $i++) {
      try {
        if ($lambda($this)) {
          return TRUE;
        }
      }
      catch (Exception $e) {
        $message = $e->getMessage();
      }
      sleep(1);
    }
    throw new Exception("Timeout exception of $wait sec. $message");
  }  

}
