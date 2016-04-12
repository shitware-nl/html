<?php

namespace Rsi\Html;

class Tree extends \Rsi\Html{

  public $items = null; //!<  Array with items (key = caption, value = array with optional 'link', 'class', and 'items').

  public function __construct($items = null){
    $this->items = $items ?: [];
  }
  /**
   *  Render a list of items.
   *  @param array $items
   *  @return string
   */
  protected function tree($items){
    $html = '';
    foreach($items as $caption => $item){
      if(!is_array($item)) $item = ['link' => $item];
      if(array_key_exists('link',$item)) $caption = "<a href='{$item['link']}'>$caption</a>";
      $html .=
        "<li" . (array_key_exists('class',$item) ? " class='{$item['class']}'" : '') . ">" .
        $caption .
        (array_key_exists('items',$item) ? $this->tree($item['items']) : '') .
        "</li>\n";
    }
    return "<ul>\n$html</ul>";
  }

  public function html(){
    return $this->tree($this->items);
  }

}