<?php
/**
 * Created by PhpStorm.
 *
 * Gibbon-Responsive
 *
 * (c) 2018 Craig Rayner <craig@craigrayner.com>
 *
 * User: craig
 * Date: 16/12/2018
 * Time: 08:20
 */
namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class EnvironmentInstallCommand
 * @package App\Command
 */
class DatabaseCreateCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'gibbon:database:create';

    /**
     * execute
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $kernel = $this->getApplication()->getKernel();
        if ($_ENV['APP_ENV'] === 'test')
        {
            $application = new Application($kernel);
            $application->setAutoExit(false);

            $input = new ArrayInput(
                [
                    'command' => 'doctrine:database:drop',
                    // (optional) define the value of command arguments
                    '--env' => 'test',
                    '--if-exists' => '--if-exists',
                    '--no-interaction' => '--no-interaction',
                    '--force' => '--force',
                ]
            );

            // You can use NullOutput() if you don't need the output
            $output = new BufferedOutput();
            $result = $application->run($input, $output);

            // return the output, don't use if you used NullOutput()
            if ($result !== 0) {
                dump($output);
                return $result;
            }

            $input = new ArrayInput(
                [
                    'command' => 'doctrine:database:create',
                    // (optional) define the value of command arguments
                    '--env' => 'test',
                    '--if-not-exists' => '--if-not-exists',
                    '--no-interaction' => '--no-interaction',
                ]
            );

            // You can use NullOutput() if you don't need the output
            $output = new BufferedOutput();
            $result = $application->run($input, $output);

            // return the output, don't use if you used NullOutput()
            if ($result !== 0) {
                dump($output);
                return $result;
            }

            $input = new ArrayInput(
                [
                    'command' => 'doctrine:migrations:migrate',
                    '--no-interaction' => '--no-interaction',
                ]
            );

            // You can use NullOutput() if you don't need the output
            $output = new BufferedOutput();
            $result = $application->run($input, $output);

            if ($result !== 0) {
                dump($output);
                return $result;
            }
        }
        return 0;
    }
}