<?php
/*
 *
 * @author Carlos Mafla <gigo6000@hotmail.com>
 *
 */

namespace Devtime\BackboneBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('backbone:install')
            ->setDescription('Creates structure for your backbone.js project')
            ->addArgument('bundle_name', InputArgument::REQUIRED, 'A bundle name, remember to use the company+bundlename')
            ->addOption('path', null, InputOption::VALUE_REQUIRED, 'The path where to install backbone when it cannot be guessed')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $bundle = $this->getApplication()->getKernel()->getBundle($input->getArgument('bundle_name'));

        $output->writeln(sprintf('Installing backbone for bundle "<info>%s</info>"', $bundle->getName()));

        $public_dir = $bundle->getPath(). '/Resources/public/js';

        if ($path = $input->getOption('path'))
            $public_dir = $path;

        if (!is_dir($public_dir)) {
            mkdir($public_dir, 0777, true);
        } 
     
        // Create empty dirs
        $dirs = array('collections', 'models', 'routers', 'views', 'templates');
        
        foreach ($dirs as $dir)
         {
           if (!is_dir($public_dir. '/' .$dir)) {
             mkdir($public_dir. '/'. $dir);
             $output->writeln('<info>create</info> '. '/Resources/public/js/'. $dir);

           } 
         }

        // Copy files
        try {
           $files = array('backbone.js', 'underscore.js', 'app.js', 'jquery.min.js');
           foreach ($files as $file)
           {
             $path= $this->getApplication()->getKernel()->locateResource('@DevtimeBackboneBundle/Resources/files/js/'. $file); 
             copy($path, $public_dir. '/'. $file); 
             $output->writeln('<info>create</info> '. '/Resources/public/js/'. $file);
           }

        } catch (\InvalidArgumentException $e) {
           echo $e;
        } 
      
    }
}
