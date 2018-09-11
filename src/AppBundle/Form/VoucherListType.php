<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class VoucherListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codeLength', TextType::class)
            ->add('numCodesToGenerate', TextType::class)
            ->add('fileName', TextType::class)
            ->add('save', SubmitType::class, [
                'label' => 'Generate'
            ])
        ;
    }
}