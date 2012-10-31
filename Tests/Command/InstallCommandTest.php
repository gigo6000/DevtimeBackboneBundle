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

class InstallCommandTest extends \PHPUnit_Framework_TestCase 
{


    public function setUp()
    {   
        $this->originDir = __DIR__ . '/../../Resources/files/js/';
        $this->targetDir = sys_get_temp_dir();

        $this->kernel = $this->getMock('Symfony\Component\HttpKernel\KernelInterface');

        $bundle = $this->getMock('Symfony\Component\HttpKernel\Bundle\Bundle');
        $bundle->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('AcmeDemoBundle'));

        $bundle->expects($this->any())
            ->method('getPath')
            ->will($this->returnValue($this->targetDir));

        $this->kernel->expects($this->any())
            ->method('getBundle')
            ->will($this->returnValue($bundle));

    }  

    public function testInstallCommandExecute()
    {

        $this->kernel->expects($this->any())
            ->method('locateResource')
            ->will($this->returnValue($this->originDir.'/backbone.js'));

        $application = new Application($this->kernel);
        $application->add(new InstallCommand());

        $command = $application->find('backbone:install');
        $commandTester = new CommandTester($command);

        $commandTester->execute(
            array('command' => $command->getName(),'bundle_name' => 'AcmeDemoBundle')
        );

        $this->assertRegExp('/create/', $commandTester->getDisplay());

        //$this->assertTrue(true);
    }

}


