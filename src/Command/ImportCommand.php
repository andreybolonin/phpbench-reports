<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use PhpBench\Dom\Document;
use App\Domain\Import\Importer;

class ImportCommand extends Command
{
    /**
     * @var Importer
     */
    private $importer;

    public function __construct(Importer $importer)
    {
        $this->importer = $importer;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('phpbench:import');
        $this->addArgument('path', InputArgument::REQUIRED, 'PHPBench XML file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');

        if (!file_exists($path)) {
            throw new RuntimeException(sprintf(
                'File "%s" does not exist',
                $path
            ));
        }

        $document = new Document();
        $document->loadXML(file_get_contents($path));

        $this->importer->import($document);
        $output->writeln('Done');
    }
}
