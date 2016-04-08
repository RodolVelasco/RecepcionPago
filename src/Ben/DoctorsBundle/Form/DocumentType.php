<?php // src/Acme/proveedorBundle/Form/Type/proveedorType.php
namespace Ben\DoctorsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder->add('file','file', array(
					'label' => 'Archivo',
					//'label_attr' => array('style' => 'padding-bottom: 35px;',)
				)
		);
		
		
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ben\DoctorsBundle\Entity\Document',
        ));
    }

    public function getName()
    {
        return 'document';
    }
}
?>