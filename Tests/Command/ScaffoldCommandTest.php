<?php
/*
 * This file is part of the DevtimeBackboneBundle package.
 *
 * (c) Carlos Mafla <gigo6000@hotmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtime\Bundle\BackboneBundle\Tests\Command;

use Devtime\BackboneBundle\Command\ScaffoldCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ScaffoldCommandTest extends \PHPUnit_Framework_TestCase 
{


    public function setUp()
    {   
        $this->originDir = __DIR__ . '/../../Resources/files/js/templates';
        $this->targetDir = sys_get_temp_dir();

        $this->kernel = $this->getMock('Symfony\Component\HttpKernel\KernelInterface');

        $this->kernel->expects($this->any())
            ->method('getBundle')
            ->will($this->returnValue($this->getBundle()));

        $this->kernel->expects($this->any())
            ->method('getBundles')
            ->will($this->returnValue(array($this->getBundle())));

        $this->kernel->expects($this->any())
            ->method('locateResource')
            ->will($this->returnValue($this->originDir.'/model.js'));
    }  

    public function testScaffoldCommand()
    {

        $application = new Application($this->kernel);
        $application->add(new ScaffoldCommand());

        $command = $application->find('backbone:scaffold');
        $commandTester = new CommandTester($command);

        $commandTester->execute(
            array('command' => $command->getName(),'bundle' => 'AcmeDemoBundle', 'entity' => 'entry')
        );

        $this->assertRegExp('/create/', $commandTester->getDisplay());

    }

    protected function getBundle()
    {   
        $bundle = $this->getMock('Symfony\Component\HttpKernel\Bundle\BundleInterface');
        $bundle
            ->expects($this->any())
            ->method('getPath')
            ->will($this->returnValue($this->targetDir))
        ;   

        $bundle->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('AcmeDemoBundle'));

        return $bundle;
    }   

}


