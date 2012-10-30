<?php
/*
 * This file is part of the DevtimeBacboneBundle package.
 *
 * (c) Carlos Mafla <gigo6000@hotmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Devtime\BackboneBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Devtime\BackboneBundle\Util\Inflector;

class ScaffoldCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('backbone:scaffold')
            ->setDescription('Generates backbone.js scaffold classes')
            ->addArgument('bundle', InputArgument::REQUIRED, 'A bundle name, remember to use full namespace name ex: DevtimeBackboneBundle')
            ->addArgument('entity', InputArgument::REQUIRED, 'A entity name ex: item')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $bundle = $this->getApplication()->getKernel()->getBundle($input->getArgument('bundle'));
        $entity = $input->getArgument('entity');


        $output->writeln(sprintf('Generating backbone scaffold classes for bundle "<info>%s</info>"', $bundle->getName()));

        $public_dir = $bundle->getPath(). '/Resources/public/js';

        if (!is_dir($public_dir)) {
            mkdir($public_dir, 0777, true);
        } 
     
        $inflector = new Inflector();
        // Copy files
        try {
           $files = array('models' => 'model.js', 'collections' => 'collection.js', 'routers' => 'router.js', 'views' => 'view.js');
           foreach ($files as $dir => $file)
           {   
             //TODO: avoid getting the bundle name manually
             $path= $this->getApplication()->getKernel()->locateResource('@DevtimeBackboneBundle/Resources/files/js/templates/'. $file); 
             $file_content = file_get_contents($path);
             switch ($file) {
               case 'collection.js':
                 $class_name = 'App.Collections.' . ucfirst($inflector->pluralize($entity));
                 $output_content = sprintf($file_content, $class_name,$entity);
                 $file_path = $dir . '/' .$inflector->pluralize($entity). '.js';
                 break;
               case 'model.js':
                 $class_name = 'App.Models.' . ucfirst($inflector->singularize($entity));
                 $output_content = sprintf($file_content, $class_name);
                 $file_path = $dir . '/'  .$inflector->singularize($entity). '.js';
                 break;
               case 'router.js':
                 $class_name = 'App.Routers.' . ucfirst($inflector->pluralize($entity));
                 $output_content = sprintf($file_content, $class_name);
                 $file_path = $dir . '/' .$inflector->pluralize($entity). '_router.js';
                 break;
               case 'view.js':
                 $class_name = 'App.Views.' . ucfirst($inflector->pluralize($entity)) . 'Index';
                 $output_content = sprintf($file_content, $class_name);
                 $view_dir = $public_dir . '/' . $dir . '/' . $inflector->pluralize($entity);
                 if (!is_dir($view_dir)) 
                   mkdir($view_dir, 0777, true);
             
                 $file_path = $dir . '/' . $inflector->pluralize($entity) . '/' .$inflector->pluralize($entity). '_index.js';
                 break;    
               default:
                 $output_content = sprintf($file_content, $entity);

                 break;
               }   

             if (!is_dir($public_dir. '/' .$dir))
                {   
                  $output->writeln("<error>$dir dir not found. Please make sure you ran backbone:install first!</error>");    
                  exit;
                }  
             file_put_contents($public_dir. '/' .$file_path, $output_content);
             $output->writeln('<info>create</info> '.  '/Resources/public/js/' .$file_path);
           }

        } catch (\InvalidArgumentException $e) {
           echo $e;
        } 
      
    }
}
