<?php

class RedisBuffer {

  private const BUFFERKEY = "log_buffer";

  /*
  * Fetch Redis connection
  */
  private static function get_connection()
  {
      $redis = new Redis();
      // support for docker linked instance
      $redis_host = getenv('REDIS_PORT_6379_TCP_ADDR');
      $redis_host = ($redis_host) ? $redis_host : '127.0.0.1';
      $redis->pconnect($redis_host, 6379);
      return $redis;
  }

  /*
  * Append message to Redis Queue.
  */
  public static function append(String $message)
  {
      $redis = self::get_connection();
      $status =  $redis->rPush(self::BUFFERKEY, $message);
      return $status;
  }

  /*
  * Fetch and remove a number of messages from Redis Queue.
  * Equivelent to calling pop n times.
  */
  public static function fetch(int $number_messages)
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
