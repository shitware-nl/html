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
      $html .= '<li';
      foreach($item as $key => $value) if($value) switch($key){
        case 'link': $caption = "<a href='{$item['link']}'>$caption</a>"; break;
        case 'items': $caption .= $this->tree($value); break;
        default: $html .= " $key='" . htmlspecialchars($value) . "'";
      }
      $html .= ">$caption</li>\n";
    }
    return "<ul>\n$html</ul>";
  }

  public function html(){
    return $this->tree($this->items);
  }

}