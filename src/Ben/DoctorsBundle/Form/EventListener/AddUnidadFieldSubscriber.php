<?php

namespace Ben\DoctorsBundle\Form\EventListener;
 
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;
 
class AddUnidadFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT   => 'preSubmit'
        );
    }
 
    private function addUnidadForm($form, $unidad = null)
    {
        $formOptions = array(
            'class'         => 'BenDoctorsBundle:Unidad',
            'mapped'        => true,
            'label'         => 'Unidad',
            'empty_value'   => 'Elija una opción...',
            'attr'          => array(
                'class' => 'unidad_selector',
            ),
        );
 
        if ($unidad) {
            $formOptions['data'] = $unidad;
        }
 
        $form->add('unidad', 'entity', $formOptions);
    }
 
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
 
        if (null === $data) {
            return;
        }
 
        $accessor = PropertyAccess::getPropertyAccessor();
 
        $lineaTrabajo    = $accessor->getValue($data, 'lineaTrabajo');
        $unidad = ($lineaTrabajo) ? $lineaTrabajo->getUnidad() : null;
 
        $this->addUnidadForm($form, $unidad);
    }
 
    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();
 
        $this->addUnidadForm($form);
    }
}