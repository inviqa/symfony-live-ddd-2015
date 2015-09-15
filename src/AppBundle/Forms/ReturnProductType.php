<?php

namespace AppBundle\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ReturnProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', 'money', ['currency' => 'GBP'])
            ->add('sku', 'text')
            ->add('purchaseDate', 'date')
            ->add('Return', 'submit');
    }

    public function getName()
    {
        return 'return_product';
    }
}