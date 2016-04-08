<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Ben\DoctorsBundle\Entity\LineaTrabajo;
use Ben\DoctorsBundle\Form\LineaTrabajoType;

use Ben\DoctorsBundle\Pagination\Paginator;

/**
 * LineaTrabajo controller.
 *
 */
class LineaTrabajoController extends Controller
{

    /**
     * Lists all lineaTrabajo entities.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function indexAction()
    {
        //var_dump($this);die;
        $em = $this->getDoctrine()->getManager();
        $entitiesLength = $em->getRepository('BenDoctorsBundle:LineaTrabajo')->counter();
        //$proveedores = $em->getRepository('BenDoctorsBundle:Proveedor')->getProveedores();

        return $this->render('BenDoctorsBundle:LineaTrabajo:index.html.twig', array(
            //'proveedores' => $proveedores,
            'entitiesLength' => $entitiesLength));
    }

    /**
     * unidades list using ajax
     * @Secure(roles="ROLE_USER")
     */
    public function ajaxListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $searchParam = $request->get('searchParam');
        $entities = $em->getRepository('BenDoctorsBundle:LineaTrabajo')->search($searchParam);
        //exit(\Doctrine\Common\Util\Debug::dump($entities));
        $pagination = (new Paginator())->setItems(count($entities), $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
        return $this->render('BenDoctorsBundle:LineaTrabajo:ajax_list.html.twig', array(
                    'entities' => $entities,
                    'pagination' => $pagination,
                    ));
    }
    /**
     * Creates a new Unidad entity.
     *
     */
    public function createAction(Request $request)
    {

        $entity = new LineaTrabajo();
        $form = $this->createForm(new LineaTrabajoType(), $entity);
        //exit(\Doctrine\Common\Util\Debug::dump("HOLA"));
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', "Línea de trabajo guardada exitosamente.");
            return $this->redirect($this->generateUrl('linea_trabajo_show', array('id' => $entity->getId())));
        }
        // $cities = $em->getRepository('BenDoctorsBundle:Proveedor')->getCities();

        $this->get('session')->getFlashBag()->add('danger', "Se encontraron errores en el formulario al intentar guardar la información !");
        return $this->render('BenDoctorsBundle:LineaTrabajo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            // 'cities' => $cities,
        ));
    }

    /**
     * Displays a form to create a new Proveedor entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function newAction()
    {
        $entity = new LineaTrabajo();
        $form = $this->createForm(new LineaTrabajoType(0), $entity);
        $em = $this->getDoctrine()->getManager();
        // $cities = $em->getRepository('BenDoctorsBundle:Proveedor')->getCities();

        return $this->render('BenDoctorsBundle:LineaTrabajo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            // 'cities' => $cities,
        ));
    }

    /**
     * Finds and displays a Proveedor entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:LineaTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Línea de Trabajo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:LineaTrabajo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing LineaTrabajo entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:LineaTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Línea de trabajo entity.');
        }
        
        $em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				    'SELECT P
				    FROM BenDoctorsBundle:Periodo P
					WHERE P.periodo = :anio'
				);
		$query->setParameter('anio', $entity->getAnio());
		$periodos = $query->getResult();
		$periodoId = 0;
        foreach($periodos as $periodo){
            $periodoId = $periodo->getId();
        }
        
        $editForm = $this->createForm(new LineaTrabajoType($periodoId), $entity);
        $deleteForm = $this->createDeleteForm($id);
        // $cities = $em->getRepository('BenDoctorsBundle:Proveedor')->getCities();

        return $this->render('BenDoctorsBundle:LineaTrabajo:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            // 'cities' => $cities,
        ));
    }
    /**
     * Edits an existing LineaTrabajo entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:LineaTrabajo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LineaTrabajo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new LineaTrabajoType($entity->getAnio()), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', "La Línea de trabajo ha sido modificado exitosamente.");
            return $this->redirect($this->generateUrl('linea_trabajo_edit', array('id' => $id)));
        }
        // $cities = $em->getRepository('BenDoctorsBundle:Proveedor')->getCities();

        $this->get('session')->getFlashBag()->add('danger', "Se encontraron errores en el formulario !");
        return $this->render('BenDoctorsBundle:LineaTrabajo:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            // 'cities' => $cities,
        ));
    }
    /**
     * Deletes a LineaTrabajo entity.
     * @Secure(roles="ROLE_MANAGER")
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BenDoctorsBundle:LineaTrabajo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find LineaTrabajo entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', "Línea de trabajo eliminada exitosamente !");
        }

        return $this->redirect($this->generateUrl('linea_trabajo'));
    }

    /**
     * Creates a form to delete a LineaTrabajo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Deletes multiple entities
     * @Secure(roles="ROLE_ADMIN")
     */
    public function removeAction(Request $request)
    {
        $ids = $request->get('entities');
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BenDoctorsBundle:LineaTrabajo')->search(array('ids'=>$ids));
        foreach( $entities as $entity) $em->remove($entity);
        $em->flush();

        return new Response('1');
    }
}
