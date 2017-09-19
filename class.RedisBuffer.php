<?php

class RedisBuffer {

  const BUFFERKEY = "log_buffer";

  private static function get_connection()
  {
      $redis = new Redis();
      // support for docker linked instance
      $redis_host = getenv('REDIS_PORT_6379_TCP_ADDR');
      $redis_host = ($redis_host) ?: '127.0.0.1';
      $redis->pconnect($redis_host, 6379);
      return $redis;
  }

  public static function append($message)
  {
      $redis = self::get_connection();
      $status =  $redis->rPush(self::BUFFERKEY, $message);
      return $status;
  }

  public static function fetch($number_messages)
  {
      $redis = self::get_connection();
      $buffer = [];

      // fetch first 20 log messages queued
      for($i=0; $i < $number_messages; $i++)
      {
          $pop = $redis->lPop(self::BUFFERKEY);
          if(!$pop) {
            break;
          } else {
            $buffer[] = $pop;
          }
      }
      return $buffer;
  }
}

 ?>
