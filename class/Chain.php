<?php

namespace Varilink\Telos;

use Varilink\Telos\Node;
use Varilink\Telos\Request;

class Chain extends AbstractBase
{
  protected $node;
  private $data = [];

  public function __construct($url)
  {
    $this->node = new Node($url);
  }

  public function __get($name)
  {
    if (\array_key_exists($name, $this->data)) {
      return $this->data[$name];
    } elseif (in_array($name,['chain_id'],TRUE)) {
      $request = new Request($this->node);
      $info = $request->send('get_info');
      foreach ($info as $key => $value) {
        $this->data[$key] = $value ;
      }
      return $this->data[$name];
    } elseif ($name === 'producers') {
      $request = new Request($this->node);
      $data['json'] = TRUE ;
      $response = $request->send('get_producers', $data);
      $this->data['producers'] = $response['rows'];
      while ($response['more']) {
        $data['lower_bound'] = $response['more'];
        $response = $request->send('get_producers', $data);
        $this->data['producers'] = array_merge(
          $this->data['producers'], $response['rows']
        );
      }
      return $this->data['producers'];
    } else {
      \trigger_error(
        "Undefined $name property for Varilink\Telos\Chain", E_USER_NOTICE
      );
    }
  }

  public function getTokens ( ) {

    $tokens = array (
      ( object ) array ( 'code' => 'eosio.token' , 'symbol' => 'TLOS' ) ,
      ( object ) array ( 'code' => 'acornaccount' , 'symbol' => 'ACORN' ) ,
      ( object ) array ( 'code' => 'vapaeetokens' , 'symbol' => 'CNT' ) ,
      ( object ) array ( 'code' => 'mailcontract' , 'symbol' => 'MAIL' ) ,
      ( object ) array ( 'code' => 'proxibotstkn' , 'symbol' => 'ROBO' ) ,
      ( object ) array ( 'code' => 'telosdacdrop' , 'symbol' => 'TLOSDAC' ) ,
    ) ;

    $chain = array_search ( $this -> chain_id , self::chains , TRUE ) ;

    if ( $chain === 'mainnet' ) {

    } elseif ( $chain == 'testnet' ) {
    }

    return $tokens ;

  }

}
