<?php

namespace Ben\DoctorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UnidadLineaTrabajoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder
            ->add('codigo')
            ->add('estado', 'choice', array(
                        'label'=>'Estado',
                        'choices' => array('1' => 'Activo','0' => 'Inactivo'),
                        'required' => false,))
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\DoctorsBundle\Entity\LineaTrabajo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ben_linea_trabajo';
    }
}