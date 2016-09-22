<?php

namespace phmLabs\MaintenanceBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MaintenanceCommand extends ContainerAwareCommand
{
    const MAINTENANCE_FILE = 'app.php.maintenance';

    protected function configure()
    {
        $this
            ->setName('phmlabs:maintenance')
            ->addArgument('action', InputArgument::REQUIRED, 'start|stop')
            ->setDescription('Starts and stops the maintenance mode.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $webDir = $this->getContainer()->get('kernel')->getRootDir() . '/../web/';
        $appFile = $webDir . 'app.php';

        if ($input->getArgument('action') == 'start') {
            $output->writeln('<info>Starting maintenance mode ... </info>');
            $content = $this->getContainer()->get('templating')->render('phmLabsMaintenanceBundle:Default:index.html.twig');
            rename($appFile, $webDir . self::MAINTENANCE_FILE);
            file_put_contents($appFile, $content);
        } elseif ($input->getArgument('action') == 'stop') {
            if (file_exists($webDir . self::MAINTENANCE_FILE)) {
                $output->writeln('<info>Stopping maintenance mode ... </info>');
                unlink($appFile);
                rename($webDir . self::MAINTENANCE_FILE, $appFile);
            }
        } else {
            $output->writeln("\n  <error> Action not found. Try start|stop </error>\n");
        }
    }
}