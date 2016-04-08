<?php

namespace Ben\DoctorsBundle\Form\EventListener;
 
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;

use Ben\DoctorsBundle\Entity\Unidad;
use Ben\DoctorsBundle\Entity\LineaTrabajo;
 
class AddLineaTrabajoFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA  => 'preSetData',
            FormEvents::PRE_SUBMIT    => 'preSubmit'
        );
    }
 
    private function addLineaTrabajoForm($form, $unidad_id)
    {
        $formOptions = array(
            'class'         => 'BenDoctorsBundle:LineaTrabajo',
            'empty_value'   => 'Elija una opción...',
            'property'      => 'nombre',
            'label'         => '',
            'attr'          => array(
                'class' => 'linea_trabajo_selector',
            ),
            'query_builder' => function (EntityRepository $repository) use ($unidad_id) {
                $qb = $repository->createQueryBuilder('lt')
                    ->innerJoin('lt.unidad', 'unidad')
                    ->where('unidad.id = :unidad')
                    ->setParameter('unidad', $unidad_id)
                ;
 
                return $qb;
            }
        );
 
        //$form->add($this->propertyPathToLineaTrabajo, 'entity', $formOptions);
        $form->add('lineaTrabajo', 'entity', $formOptions);
    }
 
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
 
        if (null === $data) {
            return;
        }
 
        $accessor    = PropertyAccess::createPropertyAccessor();
 
        $lineaTrabajo        = $accessor->getValue($data, 'lineaTrabajo');
        $unidad_id = ($lineaTrabajo) ? $lineaTrabajo->getUnidad()->getId() : null;
 
        $this->addLineaTrabajoForm($form, $unidad_id);
    }
 
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
 
        $unidad_id = array_key_exists('unidad', $data) ? $data['unidad'] : null;
 
        $this->addLineaTrabajoForm($form, $unidad_id);
    }
}