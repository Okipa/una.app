<?php

namespace App\Helpers;

use Illuminate\Console\Command;

class ConsoleHelper
{
    public function execWithOutput(string $cmd, Command $console)
    {
        // Setup the file descriptors
        $descriptors = [
            0 => ['pipe', 'w'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        // Start the script
        $proc = proc_open($cmd, $descriptors, $pipes);

        // Read the stdin
        $stdin = stream_get_contents($pipes[0]);
        fclose($pipes[0]);

        // Read the stdout
        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        // Read the stderr
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        // Close the script and get the return code
        $return_code = proc_close($proc);

        if ($stdin) {
            $console->line($stdin);
        }
        if ($stdout) {
            $console->line($stdout);
        }
        if ($stderr) {
            $console->line($stderr);
        }

        if (strpos($stdout, 'continue?')) {
            $console->error('A confirmation has been asked during the shell command execution.');
            $console->error('Please manually execute the command "' . $cmd . '" to treat that particular case.');
            return exit();
        }

        if ($return_code) {
            $console->error('Error exit code : ' . $return_code);
            if (!$console->ask('Do you want continue the script execution ? [Y/n]', true)) {
                return exit();
            }
        }
    }

}