<?php

namespace Devtime\Bundle\BackboneBundle\Tests\Command;

use Devtime\BackboneBundle\Command\InstallCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


require_once(__DIR__ . "/../../../../../../../app/AppKernel.php");

class InstallCommandTest extends WebTestCase 
{
    private $path;
    private $bundle_name;
    private $application;


    protected function setUp()
    {  
        $this->path = sys_get_temp_dir();
        $this->bundle_name = 'DevtimeBackboneBundle';

    }

    public function testExecute()
    {

        $kernel = new \AppKernel("test",true); 
        $kernel->boot();
        $application = new Application($kernel);

        $command = $application->find('backbone:install');
        $commandTester = new CommandTester($command);

        $commandTester->execute(
            array('command' => $command->getName(),'bundle_name' => $this->bundle_name, '--path' => $this->path)
        );

        $this->assertRegExp('/create/', $commandTester->getDisplay());

    }

}


