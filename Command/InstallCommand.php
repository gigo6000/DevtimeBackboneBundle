<?php
/*
 * This file is part of the DevtimeBackboneBundle package.
 *
 * (c) Carlos Mafla <gigo6000@hotmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtime\BackboneBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class InstallCommand extends ContainerAwareCommand 
{

    protected function configure()
    {
        $this
            ->setName('backbone:install')
            ->setDescription('Creates basic structure for your backbone.js project')
            ->addArgument('bundle', InputArgument::REQUIRED, 'A bundle name, remember to use full namespace name ex: DevtimeBackboneBundle')
            ->addOption('path', null, InputOption::VALUE_REQUIRED, 'The path where to install backbone when it cannot be guessed')
            ->addOption('no-jquery', null, InputOption::VALUE_NONE, 'Don\'t include jquery lib file')
            ->addOption('no-backbone', null, InputOption::VALUE_NONE, 'Don\'t include backbone.js lib file')
            ->addOption('no-underscore', null, InputOption::VALUE_NONE, 'Don\'t include underscore lib file')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $bundle = $this->getApplication()->getKernel()->getBundle($input->getArgument('bundle'));

        $output->writeln(sprintf('Installing backbone for bundle "<info>%s</info>"', $bundle->getName()));

        if ($path = $input->getOption('path'))
            $public_dir = $path;
        else
            $public_dir = $bundle->getPath(). '/Resources/public/js';

        $filesystem = new Filesystem(); 

        if (!is_dir($public_dir)) {
            $filesystem->mkdir($public_dir, 0777, true);
        } 
     
        // Create empty dirs
        $dirs = array('collections', 'models', 'routers', 'views', 'templates');
        
        foreach ($dirs as $dir)
         {
           if (!is_dir($public_dir. '/' .$dir)) {
             $filesystem->mkdir($public_dir. '/'. $dir);
             $output->writeln('<info>create</info> '. '/Resources/public/js/'. $dir);
           } 
         }

         // Copy files
         $this->copyFile('app.js', $public_dir, $filesystem, $output);

         if (!$input->getOption('no-jquery')) 
            $this->copyFile('jquery.min.js', $public_dir, $filesystem, $output);

         if (!$input->getOption('no-backbone')) 
            $this->copyFile('backbone.js', $public_dir, $filesystem, $output);

         if (!$input->getOption('no-underscore')) 
            $this->copyFile('underscore.js', $public_dir, $filesystem, $output);
      
    }


    /** 
     * Copies a file to the target bundle public dir
     *
     * @param string $file The file name
     * @param string $public_dir The target bundle public dir path
     * @param Filesystem $filesystem The filesystem 
     * @param OutputInterface $output The command output
     */
    private function copyFile($file, $public_dir, Filesystem $filesystem, OutputInterface $output)
    {
         $path= $this->getApplication()->getKernel()->locateResource('@DevtimeBackboneBundle/Resources/files/js/'. $file);
         $filesystem->copy($path, $public_dir. '/'. $file);
         $output->writeln('<info>create</info> '. '/Resources/public/js/'. $file);
    }
}
