<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Ben\DoctorsBundle\Entity\Unidad;
use Ben\DoctorsBundle\Form\UnidadType;

use Ben\DoctorsBundle\Pagination\Paginator;

/**
 * Unidad controller.
 *
 */
class UnidadController extends Controller
{

    /**
     * Lists all unidad entities.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function indexAction()
    {
        //var_dump($this);die;
        $em = $this->getDoctrine()->getManager();
        $entitiesLength = $em->getRepository('BenDoctorsBundle:Unidad')->counter();
        //$proveedores = $em->getRepository('BenDoctorsBundle:Proveedor')->getProveedores();

        return $this->render('BenDoctorsBundle:Unidad:index.html.twig', array(
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
        $entities = $em->getRepository('BenDoctorsBundle:Unidad')->search($searchParam);
        //exit(\Doctrine\Common\Util\Debug::dump($entities));
        $pagination = (new Paginator())->setItems(count($entities), $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
        return $this->render('BenDoctorsBundle:Unidad:ajax_list.html.twig', array(
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

        $entity = new Unidad();
        $form = $this->createForm(new UnidadType(), $entity);
        //exit(\Doctrine\Common\Util\Debug::dump("HOLA"));
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', "Unidad guardada exitosamente.");
            return $this->redirect($this->generateUrl('unidad_show', array('id' => $entity->getId())));
        }
        // $cities = $em->getRepository('BenDoctorsBundle:Proveedor')->getCities();

        $this->get('session')->getFlashBag()->add('danger', "Se encontraron errores en el formulario al intentar guardar la información !");
        return $this->render('BenDoctorsBundle:Unidad:new.html.twig', array(
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
        $entity = new Unidad();
        $form = $this->createForm(new UnidadType(), $entity);
        $em = $this->getDoctrine()->getManager();
        // $cities = $em->getRepository('BenDoctorsBundle:Proveedor')->getCities();

        return $this->render('BenDoctorsBundle:Unidad:new.html.twig', array(
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

        $entity = $em->getRepository('BenDoctorsBundle:Unidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Unidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:Unidad:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Proveedor entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Unidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Unidad entity.');
        }
        $editForm = $this->createForm(new UnidadType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        // $cities = $em->getRepository('BenDoctorsBundle:Proveedor')->getCities();

        return $this->render('BenDoctorsBundle:Unidad:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            // 'cities' => $cities,
        ));
    }
    /**
     * Edits an existing Proveedor entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:Unidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Unidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UnidadType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', "La unidad ha sido modificado exitosamente.");
            return $this->redirect($this->generateUrl('unidad_edit', array('id' => $id)));
        }
        // $cities = $em->getRepository('BenDoctorsBundle:Proveedor')->getCities();

        $this->get('session')->getFlashBag()->add('danger', "Se encontraron errores en el formulario !");
        return $this->render('BenDoctorsBundle:Unidad:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            // 'cities' => $cities,
        ));
    }
    /**
     * Deletes a Unidad entity.
     * @Secure(roles="ROLE_MANAGER")
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BenDoctorsBundle:Unidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Unidad entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', "Unidad eliminada exitosamente !");
        }

        return $this->redirect($this->generateUrl('unidad'));
    }

    /**
     * Creates a form to delete a Proveedor entity by id.
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
        $entities = $em->getRepository('BenDoctorsBundle:Unidad')->search(array('ids'=>$ids));
        foreach( $entities as $entity) $em->remove($entity);
        $em->flush();

        return new Response('1');
    }
}
