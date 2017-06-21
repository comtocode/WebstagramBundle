<?php

/**
 * Import your RSS Feed using webstagram
 *
 * Example :
 * php app/console ctc:webstagram --id="comtocode"
 */
namespace CTC\WebstagramBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class WebstagramImportCommand extends ContainerAwareCommand
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {

        $this
            ->setName('ctc:webstagram')
            ->setDescription('Import instagram RSS Feed from ID with web stagram')
            ->addOption('id', null, InputOption::VALUE_OPTIONAL, 'Your ID (prioritized)', null);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<fg=white;bg=green>Execute ctc:webstagram_import_command</>');


        $container = $this->getContainer();
        $webstagramUrlPrefix = $container->getParameter('webstagram.urlPrefix');

        $options                = array();
        $options["id"]          = $input->getOption("id");

        $parsedValue = "";
        if(!empty($options['id'])){
            $parsedValue = $options['id'];
        }else{
            $webstagramDefaultID = $container->getParameter('webstagram.defaultID');

            $output->writeln('<fg=white;bg=red> id option is not mentioned - Default ID is used : '.$webstagramDefaultID.' !');

            $parsedValue = $webstagramDefaultID;
        }

        // Use bundle Ressource folder to write your XML file
        $ressourcePath = $container->get('kernel')->locateResource("@CTCWebstagramBundle/Resources");

        if(!empty($ressourcePath)){

            // Retrieve content on your RSS feed with file_get_contents()
            $feed_url = $webstagramUrlPrefix . $parsedValue;
            $content    = file_get_contents($feed_url);

            $fs = new Filesystem();

            // Create folder $ressourcePath if needed
            $ressourcePath .= '/public/xml';
            try {
                $fs->mkdir($ressourcePath);
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating your directory at ".$e->getPath();
            }

            // Import RSS Content on file
            $xmlPath = $ressourcePath.'/'.$parsedValue.'.xml';
            $fs->dumpFile($xmlPath, $content);

        }

    }
}
