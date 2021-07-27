<?php

spl_autoload_register( function($class_name) {

  if ( preg_match('/^Varilink\\\\Telos\\\\(\w+)$/', $class_name, $matches) ) {
    include dirname ( __FILE__ ) . "/class/$matches[1].php" ;
  }

});
