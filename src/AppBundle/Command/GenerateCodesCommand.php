<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


class GenerateCodesCommand extends ContainerAwareCommand
{
    public $voucherService;

    protected function configure()
    {
        $this
            ->setName('app:generate-codes')
            ->setDescription('Creates a new codes list.')
            ->setHelp('This command allows you to create voucher codes')
            ->addArgument('codeLength', InputArgument::REQUIRED, 'length of code.')
            ->addArgument('numCodesToGenerate', InputArgument::REQUIRED, 'codes amount.')
            ->addArgument('filename', InputArgument::REQUIRED, 'filename');

    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->voucherService = $this->getContainer()->get('app.voucher_generator');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Codes Generator',
            '============',
            '',
        ]);

        $this->voucherService->setNumCodesToGenerate($input->getArgument('numCodesToGenerate'));
        $this->voucherService->setCodeLength($input->getArgument('codeLength'));
        $this->voucherService->setFileName($input->getArgument('filename'));
        $this->voucherService->generate();
    }
}