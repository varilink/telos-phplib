<?php

namespace Varilink\Telos ;

abstract class AbstractBase
{

  protected $node ;

  public function __construct ( $node )
  {
    if ( ! is_object ( $node ) || ! is_a ( $node , 'Varilink\Telos\Node' ) ) {
      throw new \ErrorException (
        'node object not provided for new chain object'
      ) ;
    }
    $this -> node = $node ;
  }

}
