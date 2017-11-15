<?php

class MyProcess
{
    public static $process = [];

    public static function cmdAsync($name, $cmd)
    {
        //$std_file = './async.txt';
        $descriptorspec = array(
            0 => array('pipe', 'a'),                // stdin
            //1 => array('file', $std_file, 'w'),   // stdout
            1 => array('pipe', 'w'),
            2 => array('pipe', 'w')                  // stderr
        );

        $childProcess = proc_open($cmd, $descriptorspec, $pipes);

        //$std_handler = fopen($std_file, 'a+');
        //stream_set_blocking($std_handler, 0);   //非阻塞

        //proc_close($child_process);
        
        static::$process[$name] = $childProcess;
        echo "Create Process:{$name}\n";
    }

    public static function closeInvalid()
    {
        foreach(static::$process as $proc)
        {

            $status = proc_get_status($proc);
            if(isset($status['running']) && !$status['running'] )
            {
                @proc_close($proc);
            }
            
        }
    }
}

MyProcess::cmdAsync('a', "php echo.php | php read.php");
