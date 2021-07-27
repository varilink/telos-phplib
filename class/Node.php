<?php

namespace Varilink\Telos;

class Node
{

  public $ch;
  public $url;

  public function __construct($url)
  {
    $this->url = $url;
    $this->ch = \curl_init();
    \curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 3);
    \curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, TRUE);
    \curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
  }

}
