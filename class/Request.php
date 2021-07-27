<?php declare(strict_types = 1);

namespace Varilink\Telos;

class Request {

  private static $endpoints = array(
    'get_account'=>array('path'=>'/v1/chain/get_account','method'=>'POST'),
    'get_actions'=>array('path'=>'/v1/history/get_actions','method'=>'POST'),
    'get_currency_balance'=>array('path'=>'/v1/chain/get_currency_balance','method' => 'POST' ) ,
    'get_info' => array (
      'path' => '/v1/chain/get_info' , 'method' => 'GET' ) ,
    'get_producers' => array (
      'path' => '/v1/chain/get_producers' , 'method' => 'POST' ) ,
    'get_table_rows' => array (
      'path' => '/v1/chain/get_table_rows' , 'method' => 'POST' ) ,
  );

  public static $service ;
  public $action ;
  private $node ;

  public function __construct ( $node ) {

    $this -> node = $node ;

  }

  public function send ( ... $args ) {

    if ( $args ) {

      $action = array_shift ( $args ) ;

      if ( gettype ( $action ) != 'string' ) {
        throw new \InvalidArgumentException ( 'action must be a string' ) ;
      }

      if ( ! array_key_exists ( $action , self::$endpoints ) ) {
        throw new \InvalidArgumentException ( 'unknown action' ) ;
      }

      if ( $args ) {

        $data = array_shift ( $args ) ;

      }

    } else {

      throw new \InvalidArgumentException ( 'at least one argument needed' ) ;

    }

    $endpoint = self::$endpoints [ $action ] ;

    $node = $this -> node ;
    $ch = $node -> ch ;

    curl_setopt ( $ch , CURLOPT_URL , $node -> url . $endpoint [ 'path' ] ) ;
    curl_setopt ( $ch , CURLOPT_RETURNTRANSFER , TRUE ) ;

    if ( $endpoint [ 'method' ] === 'POST' && isset ( $data ) ) {
      curl_setopt ( $ch , CURLOPT_POST , TRUE ) ;
      curl_setopt (
        $ch , CURLOPT_HTTPHEADER , array ( 'Content-Type: application/json' )
      ) ;
      $dataEncoded = json_encode ( $data ) ;
      curl_setopt ( $ch ,  CURLOPT_POSTFIELDS , $dataEncoded ) ;
    }

    $body = curl_exec ( $ch ) ;
    if(curl_errno($ch)) {
      die('Curl error: ' . curl_error($ch) . "\n");
    }
    $rc = curl_getinfo ( $ch , CURLINFO_HTTP_CODE ) ;
    if ( $rc === 200 ) {
      return json_decode ( $body, TRUE ) ;
    }

  }

}

?>
