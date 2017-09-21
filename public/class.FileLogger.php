<?php

class FileLogger {

    private const FILE_NAME = 'job.log';

    /*
     *  Saves message to log file
     */
    public static function write($message)
    {
        return file_put_contents(self::FILE_NAME, $message . PHP_EOL, FILE_APPEND);
    }


}
