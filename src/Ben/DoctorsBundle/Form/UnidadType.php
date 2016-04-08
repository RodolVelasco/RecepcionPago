<?php

namespace Ben\DoctorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UnidadType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {       
        $builder
            ->add('codigo')
            ->add('nombre')
            ->add('anio')
            ->add('estado')
            ->add('lineatrabajos', 'collection', array(
                    'label' => 'Líneas de trabajo',
                    'type' => new LineaTrabajoType(), 
                    'allow_add' => true, 
                    'by_reference' => false, 
                    'allow_delete' => true,
                    'prototype' => true,))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\DoctorsBundle\Entity\Unidad'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ben_unidad';
    }
}