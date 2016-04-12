<?php

namespace Rsi\Html;

class Paginator extends \Rsi\Html{

  public $count = null; //!<  Number of items (true = infinite).
  public $index = null; //!<  Current page (base = 1).
  public $size = null; //!<  Page size.
  public $range = null; //!<  Maximum number of pages before/after the current one.

  public $class = 'paginator';
  public $link = '?page=*'; //!<  Link for the page ('*' will be replaced by page number).

  public $prev = '«'; //!<  Caption for 'previous page'.
  public $next = '»'; //!<  Caption for 'next page'.
  public $break = '…'; //!<  Caption for a 'break' between page numbers.

  public function __construct($count = true,$index = 1,$size = 1,$range = 5){
    $this->count = $count;
    $this->index = $index;
    $this->size = $size;
    $this->range = $range;
  }
  /**
   *  Count in pages (not items).
   *  @return int
   */
  protected function count(){
    return $this->count === true ? true : (int)ceil($this->count / $this->size);
  }
  /**
   *  Index checked against limits.
   *  @return int
   */
  protected function index(){
    $index = max(1,$this->index);
    return ($count = $this->count()) === true ? $index : min($count,$index);
  }
  /**
   *  Item offset (first item on current page; base 0).
   *  return int
   */
  public function offset(){
    return ($this->index() - 1) * $this->size;
  }
  /**
   *  Render single item.
   *  @param int $index  Page number (false = break).
   *  @param string $caption  Item caption (empty = page number).
   *  @param string $class  Item class.
   *  @eturn string
   */
  protected function item($index = false,$caption = null,$class = null){
    if(($index === $this->index) && !$class) $class = 'active';
    return
      "<li" . ($class ? " class='$class'" : '') . ">" .
      ($index === false ? $this->break : "<a href='" . str_replace('*',$index,$this->link) . "'>" . ($caption ?: $index) . "</a>") .
      "</li>\n";
  }

  public function html(){
    $index = $this->index();
    if($infinite = ($count = $this->count()) === true) $count = $index + $this->range + 3;
    if($count <= 0) return null;
    $html = '';
    if($count == 1) $html .= $this->item(0);
    else{
      if($index > 1) $html .= $this->item($index - 1,$this->prev,'prev');
      $html .= $this->item(1);
      $from = max(2,$index - $this->range);
      if($from == 3) $from--; //no single-page break
      elseif($from > 2) $html .= $this->item(); //break
      $to = min($count - 1,$index + $this->range);
      for($i = $from; $i <= $to; $i++) $html .= $this->item($i);
      if(!$infinite){
        if($to == $count - 2) $html .= $this->item($count - 1); //no single-page break
        elseif($to < $count - 1) $html .= $this->item(); //break
        $html .= $this->item($count);
        if($this->index < $count) $html .= $this->item($index + 1,$this->next,'next');
      }
    }
    return "<ul class='{$this->class}'>\n$html</ul>";
  }

}