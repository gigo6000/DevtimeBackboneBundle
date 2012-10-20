<?php
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
            ->setDescription('Generate backbone.js scaffold classes')
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
           $files = array('model.js', 'collection.js', 'router.js', 'view.js');
           foreach ($files as $file)
           {
             //TODO: avoid getting the bundle name manually
             $path= $this->getApplication()->getKernel()->locateResource('@DevtimeBackboneBundle/Resources/files/js/templates/'. $file); 
             $file_content = file_get_contents($path);
             switch ($file) {
               case 'collection.js':
                 $output_content = sprintf($file_content, $entity,$entity);
                 $file_path = "collections/".$inflector->pluralize($entity). '.js';
                 break;
               case 'model.js':
                 $output_content = sprintf($file_content, $entity);
                 $file_path = "models/".$inflector->singularize($entity). '.js';
                 break;
               case 'router.js':
                 $output_content = sprintf($file_content, $entity);
                 $file_path = "routers/".$inflector->pluralize($entity). '_router.js';
                 break;
               case 'view.js':
                 $output_content = sprintf($file_content, $entity);
                 $file_path = "views/".$inflector->pluralize($entity). '.js';
                 break;
               
               default:
                 $output_content = sprintf($file_content, $entity);

                 break;
             }
             file_put_contents($public_dir. '/' .$file_path, $output_content);
             //copy($path, $public_dir. '/'. $file); 
             $output->writeln('<info>create</info> '.  '/Resources/public/js/' .$file_path);
           }

        } catch (\InvalidArgumentException $e) {
           echo $e;
        } 
      
    }
}
