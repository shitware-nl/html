<?php

namespace Rsi;

abstract class Html{

  /**
   *  Outputs the HTML of the block.
   *  @return string
   */
  public abstract function html();

  public function __toString(){
    return $this->html();
  }

}