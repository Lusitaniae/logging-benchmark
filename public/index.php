<?php
/**
* Benchmark logging solution.
* Standard log file writing vs using Redis to buffer writes to disk.
* Writing to file from Redis not implemented, should not influence conclusions,
*  since it would happen in the background.
*/
define('MILISECOND', 1000);
include 'class.RedisBuffer.php';
include 'class.FileLogger.php';

if(isset($_GET) && count($_GET) === 2)
{
    $driver = $_GET['driver'];
    $nr_tasks = $_GET['nr_tasks'];
    run_benchmark($driver, $nr_tasks);
} else {
    echo 'Missing arguments.<br>';
    echo 'Quick links: <a href="/index.php?driver=redis&nr_tasks=4">redis</a> and <a href="/index.php?driver=fs&nr_tasks=4">filesystem</a>.';
    exit(1);
}



function run_benchmark($driver, $nr_tasks)
{
   for($i=0; $i < $nr_tasks; $i++)
   {
      # simulate random task
      usleep(MILISECOND);
      $request_id = uniqid('bench-job', true);
      log_message($driver, 'task run with success. Request id: ' . $request_id );
   }
}

function log_message($driver, $message)
{
    $message = date("Y-m-d H:i:s") . " 127.0.0.1 job " . $message;

    if ($driver == 'redis') {
        log_redis($message);
    } else {
        log_file($message);
    }

}

function log_redis($message)
{
    RedisBuffer::append($message);
}

function log_file($message)
{
    $logger = new FileLogger('job.log');
    $logger->write('GET', $message);
}
