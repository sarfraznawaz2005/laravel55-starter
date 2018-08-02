<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 10/02/2018
 * Time: 9:11 PM
 */

namespace Modules\Core\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CoreCommand extends Command
{
    /**
     * Runs the command.
     *
     * @param  InputInterface $input Input Interface.
     * @param  OutputInterface $output Output Interface.
     * @return void
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        if (!$this->logCompletion) {
            parent::run($input, $output);
        } else {
            $startTime = microtime(true);

            parent::run($input, $output);

            $executionTime = microtime(true) - $startTime;

            $logMessage = $this->getName() . ' finished in ' . round($executionTime, 2);

            Log::info($logMessage);
        }
    }
}
