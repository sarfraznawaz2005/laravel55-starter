<?php

namespace Modules\Core\Traits;

/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 2/8/2018
 * Time: 11:04 PM
 */

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait CoreCommand
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

            out($logMessage);
        }
    }
}