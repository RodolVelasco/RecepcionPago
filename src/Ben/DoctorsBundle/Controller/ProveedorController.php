<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Ben\DoctorsBundle\Entity\Proveedor;
use Ben\DoctorsBundle\Form\ProveedorType;

use Ben\DoctorsBundle\Pagination\Paginator;

/**
 * Proveedor controller.
 *
 */
class ProveedorController extends Controller
{

    /**
     * Lists all proveedor entities.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function indexAction()
    {
        //var_dump($this);die;
        $em = $this->getDoctrine()->getManager();
        $entitiesLength = $em->getRepository('BenDoctorsBundle:Proveedor')->counter();
        //$proveedores = $em->getRepository('BenDoctorsBundle:Proveedor')->getProveedores();

        return $this->render('BenDoctorsBundle:Proveedor:index.html.twig', array(
            //'proveedores' => $proveedores,
            'entitiesLength' => $entitiesLength));
    }

    /**
     * proveedores list using ajax
     * @Secure(roles="ROLE_USER")
     */
    public function ajaxListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $searchParam = $request->get('searchParam');
        $entities = $em->getRepository('BenDoctorsBundle:Proveedor')->search($searchParam);
        //exit(\Doctrine\Common\Util\Debug::dump($entities));
        $pagination = (new Paginator())->setItems(count($entities), $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
        return $this->render('BenDoctorsBundle:Proveedor:ajax_list.html.twig', array(
                    'entities' => $entities,
                    'pagination' => $pagination,
                    ));
    }
    /**
     * Creates a new Proveedor entity.
     *
     */
    public function createAction(Request $request)
    {

        $entity = new Proveedor();
        $form = $this->createForm(new ProveedorType(), $entity);
        //exit(\Doctrine\Common\Util\Debug::dump("HOLA"));
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();



        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', "Proveedor guardado exitosamente.");
            return $this->redirect($this->generateUrl('proveedor_show', array('id' => $entity->getId())));
        }
        // $cities = $em->getRepository('BenDoctorsBundle:Proveedor')->getCities();

        $this->get('session')->getFlashBag()->add('danger', "Se encontraron errores en el formulario al intentar guardar la información !");
        return $this->render('BenDoctorsBundle:Proveedor:new.html.twig', array(
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
        $entity = new Proveedor();
        $form = $this->createForm(new ProveedorType(), $entity);
        $em = $this->getDoctrine()->getManager();
        // $cities = $em->getRepository('BenDoctorsBundle:Proveedor')->getCities();

        return $this->render('BenDoctorsBundle:Proveedor:new.html.twig', array(
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

        $entity = $em->getRepository('BenDoctorsBundle:Proveedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proveedor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:Proveedor:show.html.twig', array(
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

        $entity = $em->getRepository('BenDoctorsBundle:Proveedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proveedor entity.');
        }
        $editForm = $this->createForm(new ProveedorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        // $cities = $em->getRepository('BenDoctorsBundle:Proveedor')->getCities();

        return $this->render('BenDoctorsBundle:Proveedor:edit.html.twig', array(
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

        $entity = $em->getRepository('BenDoctorsBundle:Proveedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proveedor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ProveedorType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', "El proveedor ha sido modificado exitosamente.");
            return $this->redirect($this->generateUrl('proveedor_edit', array('id' => $id)));
        }
        // $cities = $em->getRepository('BenDoctorsBundle:Proveedor')->getCities();

        $this->get('session')->getFlashBag()->add('danger', "Il y a des erreurs dans le formulaire soumis !");
        return $this->render('BenDoctorsBundle:Proveedor:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            // 'cities' => $cities,
        ));
    }
    /**
     * Deletes a Proveedor entity.
     * @Secure(roles="ROLE_MANAGER")
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BenDoctorsBundle:Proveedor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Proveedor entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', "Proveedor eliminado exitosamente !");
        }

        return $this->redirect($this->generateUrl('proveedor'));
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
        $entities = $em->getRepository('BenDoctorsBundle:Proveedor')->search(array('ids'=>$ids));
        foreach( $entities as $entity) $em->remove($entity);
        $em->flush();

        return new Response('1');
    }
}
