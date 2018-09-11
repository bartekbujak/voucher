<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use AppBundle\Entity\VoucherList;



class GenerateCodesCommand extends ContainerAwareCommand
{
    public $voucherService;

    public $validator;

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
        $this->validator = $this->getContainer()->get('validator');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(['Codes Generator', '============', '']);

        $voucherList = new VoucherList();
        $voucherList->setCodeLength($input->getArgument('codeLength'));
        $voucherList->setNumCodesToGenerate($input->getArgument('numCodesToGenerate'));
        $voucherList->setFileName($input->getArgument('filename'));
        $errors = $this->validator->validate($voucherList);

        if (count($errors)) {
            dump($errors[0]->getPropertyPath() . ': ' . $errors[0]->getMessage());exit;
        }

        $this->voucherService->setVoucherList($voucherList);
        $this->voucherService->generate();

        $output->writeln(['Voucher list successfully created']);
    }
}