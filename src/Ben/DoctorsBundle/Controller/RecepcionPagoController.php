<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Ben\DoctorsBundle\Entity\RecepcionPago;
use Ben\DoctorsBundle\Form\RecepcionPago1Type;
use Ben\DoctorsBundle\Form\RecepcionPago2Type;
use Ben\DoctorsBundle\Form\RecepcionPago3Type;
use Ben\DoctorsBundle\Entity\EstaAprobado;

use Ben\DoctorsBundle\Pagination\Paginator;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * RecepcionPago controller.
 *
 */
class RecepcionPagoController extends Controller
{
    private $editForm = array();
    /**
     * Lists all Person entities.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function indexAction()
    {
        // var_dump($this);die;
        $em = $this->getDoctrine()->getManager();
        $entitiesLength = $em->getRepository('BenDoctorsBundle:RecepcionPago')->counter();
        $periodos = $em->getRepository('BenDoctorsBundle:RecepcionPago')->getPeriodos();
        $periodomeses = $em->getRepository('BenDoctorsBundle:RecepcionPago')->getPeriodoMeses();
        $unidades = $em->getRepository('BenDoctorsBundle:RecepcionPago')->getUnidades();
        $tipoContrataciones = $em->getRepository('BenDoctorsBundle:RecepcionPago')->getTipoContrataciones();
        $proveedores = $em->getRepository('BenDoctorsBundle:RecepcionPago')->getProveedores();
        //$estaAprobados = $em->getRepository('BenDoctorsBundle:RecepcionPago')->getEstaAprobados();

        return $this->render('BenDoctorsBundle:RecepcionPago:index.html.twig', array(
            'periodos' => $periodos,
            'periodomeses' => $periodomeses,
            'unidades' => $unidades,
            'tipoContrataciones' => $tipoContrataciones,
            'proveedores' => $proveedores,
            'entitiesLength' => $entitiesLength));
    }
    /**
     * RecepcionPago list using ajax
     * @Secure(roles="ROLE_USER")
     */
    public function ajaxListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $searchParam = $request->get('searchParam');
        $entities = $em->getRepository('BenDoctorsBundle:RecepcionPago')->search($searchParam);
        
        //exit(\Doctrine\Common\Util\Debug::dump($entities));
        
        $pagination = (new Paginator())->setItems(count($entities), $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
        return $this->render('BenDoctorsBundle:RecepcionPago:ajax_list.html.twig', array(
                    'entities' => $entities,
                    'pagination' => $pagination,
                    ));
    }
    /**
     * Creates a new Person entity.
     *
     */
    public function createAction(Request $request)
    {

        $entity = new RecepcionPago();
        $form = $this->createForm(new RecepcionPago1Type(), $entity);
        //exit(\Doctrine\Common\Util\Debug::dump("HOLA"));
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isValid()) {
            $data = $form->getData();
            
            //exit(var_dump($request->get('guardar')));
            //exit(var_dump($data['guardar']));
            if($request->get('guardar') == "1"){
                //exit(\Doctrine\Common\Util\Debug::dump("GUARDAR"));
                $entity->setEstado(3);
                // Setear el estado a 'Sin estado'
                $aprobadoEntity = $em->getRepository('BenDoctorsBundle:EstaAprobado')->find(1);
                //exit(\Doctrine\Common\Util\Debug::dump($aprobadoEntity));
                $entity->setEstaAprobado($aprobadoEntity);
                $entity->getLineaTrabajo()->setCorrelativo($entity->getLineaTrabajo()->getCorrelativo()+1);
                $em->persist($entity);
                $em->flush();
    
                $this->get('session')->getFlashBag()->add('info', "Acta de recepción/pago guardado exitosamente.");
                return $this->redirect($this->generateUrl('recepcion_pago_show', array('id' => $entity->getId())));
            }
            if($request->get('guardar_y_continuar') == "2"){
                //exit(\Doctrine\Common\Util\Debug::dump("GUARDAR Y CONTINUAR"));
                $entity->setEstado(3);
                // Setear el estado a 'Sin estado'
                $aprobadoEntity = $em->getRepository('BenDoctorsBundle:EstaAprobado')->find(1);
                //exit(\Doctrine\Common\Util\Debug::dump($aprobadoEntity));
                $entity->setEstaAprobado($aprobadoEntity);
                $correlativo_mas_uno = $entity->getLineaTrabajo()->getCorrelativo()+1;
                $entity->getLineaTrabajo()->setCorrelativo($correlativo_mas_uno);
                $em->persist($entity);
                $em->flush();
    
                $correlativo_mas_dos = $correlativo_mas_uno + 1;
                $entity->setNumeroReferencia($correlativo_mas_dos);
                $form = $this->createForm(new RecepcionPago1Type(), $entity);
                $em = $this->getDoctrine()->getManager();
                // $cities = $em->getRepository('BenDoctorsBundle:Person')->getCities();
                
                $this->get('session')->getFlashBag()->add('info', "Acta de recepción/pago guardado exitosamente.");
                return $this->render('BenDoctorsBundle:RecepcionPago:new_continue.html.twig', array(
                    'entity' => $entity,
                    'form'   => $form->createView()
                ));
            }
            /*if($form->get('guardar')->isClicked()){
                exit(\Doctrine\Common\Util\Debug::dump("GUARDAR"));
            }
            if($form->get('guardar_y_continuar')->isClicked()){
                exit(\Doctrine\Common\Util\Debug::dump("GUARDAR Y CONTINUAR"));
            }*/
            
        }
        // $cities = $em->getRepository('BenDoctorsBundle:Person')->getCities();

        $this->get('session')->getFlashBag()->add('danger', "Se encontraron errores en el formulario al intentar guardar la información !");
        return $this->render('BenDoctorsBundle:RecepcionPago:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }
    /**
     * Displays a form to create a new Person entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function newAction()
    {
        $entity = new RecepcionPago();
        $form = $this->createForm(new RecepcionPago1Type(), $entity);
        $em = $this->getDoctrine()->getManager();
        // $cities = $em->getRepository('BenDoctorsBundle:Person')->getCities();

        return $this->render('BenDoctorsBundle:RecepcionPago:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    /**
     * Finds and displays a Person entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:RecepcionPago')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecepcionPago entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:RecepcionPago:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Displays a form to edit an existing Person entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:RecepcionPago')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecepcionPago entity.');
        }
        
        /*$webpath="";
        if($entity->getArchivo())
        {
            $webpath = $entity->getArchivo()->getWebPath();
        }*/
        
        $editForm = $this->createForm(new RecepcionPago1Type(), $entity);
        if($entity->getEstado() == 1)
            $editForm = $this->createForm(new RecepcionPago1Type(), $entity);
        if($entity->getEstado() == 2)
            $editForm = $this->createForm(new RecepcionPago1Type(), $entity);
            $editForm = $this->createForm(new RecepcionPago1Type(), $entity);
        if($entity->getEstado() == 3)
            $editForm = $this->createForm(new RecepcionPago2Type(), $entity);
        if($entity->getEstado() == 4)
            $editForm = $this->createForm(new RecepcionPago3Type(), $entity);
        if($entity->getEstado() == 10 and $entity->getEstaAprobado() == 'Rechazado')
            $editForm = $this->createForm(new RecepcionPago3Type(), $entity);
        
        
        
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:RecepcionPago:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            //'file_url' => $webpath,
        ));
    }
    /**
     * Edits an existing Person entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BenDoctorsBundle:RecepcionPago')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RecepcionPago entity.');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        if($entity->getEstado() == 1)
            $editForm = $this->createForm(new RecepcionPago1Type(), $entity);
        if($entity->getEstado() == 2)
            $editForm = $this->createForm(new RecepcionPago1Type(), $entity);
        if($entity->getEstado() == 3)
            $editForm = $this->createForm(new RecepcionPago2Type(), $entity);
        if($entity->getEstado() == 4)
            $editForm = $this->createForm(new RecepcionPago3Type(), $entity);
        if($entity->getEstado() == 10)
            $editForm = $this->createForm(new RecepcionPago3Type(), $entity);
        
        //$editForm = $this->createForm(new RecepcionPagoType, $entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $data = $editForm->getData();
            //exit(\Doctrine\Common\Util\Debug::dump($data->getEstaAprobado()->getNombre()));
            //exit(\Doctrine\Common\Util\Debug::dump($editForm->get('imageFile')));
            if($editForm->get('estado')->getData() == 1)// VER SI TODOS LOS CAMPOS ESTAN LLENOS
                $entity->setEstado(3);
            if($editForm->get('estado')->getData() == 2)
                $entity->setEstado(3);
            if($editForm->get('estado')->getData() == 3 AND $data->getEstaAprobado()->getNombre() == 'Sin estado')
                $entity->setEstado(3);
            if($editForm->get('estado')->getData() == 3 AND $data->getEstaAprobado()->getNombre() == 'Aprobado')
                $entity->setEstado(4);
            if($editForm->get('estado')->getData() == 3 AND $data->getEstaAprobado()->getNombre() == 'Rechazado')
                $entity->setEstado(10);
            
            /*if($editForm->get('estado')->getData() == 4 AND $data->getEstaAprobado()->getNombre() == 'Aprobado' AND
               $editForm->get('imageFile_delete')->getData() != true AND $editForm->get('imageFile')->getData != "")
                $entity->setEstado(10);*/
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', "La recepción de acta y pago fue editada exitosamente.");
            return $this->redirect($this->generateUrl('recepcion_pago_edit', array('id' => $id)));
        }
        
        $this->get('session')->getFlashBag()->add('danger', "Hay errores en el formulario enviado !");
        return $this->render('BenDoctorsBundle:RecepcionPago:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Person entity.
     * @Secure(roles="ROLE_MANAGER")
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BenDoctorsBundle:RecepcionPago')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RecepcionPago entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', "El acta de recepción y pago ha sido eliminado exitosamente !");
        }

        return $this->redirect($this->generateUrl('recepcion_pago'));
    }
    /**
     * Creates a form to delete a Person entity by id.
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
        $entities = $em->getRepository('BenDoctorsBundle:RecepcionPago')->search(array('ids'=>$ids));
        foreach( $entities as $entity) $em->remove($entity);
        $em->flush();

        return new Response('1');
    }
    /**
     * Deletes multiple entities
     * @Secure(roles="ROLE_ADMIN")
     */
    public function lineaTrabajoAction(Request $request)
    {
        $unidad_id = $request->get('unidad_id');
     
        $em = $this->getDoctrine()->getManager();
        $lineaTrabajos = $em->getRepository('BenDoctorsBundle:LineaTrabajo')->findByUnidadId($unidad_id);
        //exit(\Doctrine\Common\Util\Debug::dump("HOLA"));
        /*$lineaTrabajos = array(
                            'number' => array('1','2','3'),
                            'alfabeth' => array('a','b','c'),
                            'alfa' => array('$','&','#'));}*/
        return new JsonResponse($lineaTrabajos);
    }
    /**
     * Deletes multiple entities
     * @Secure(roles="ROLE_ADMIN")
     */
    public function correlativoLineaTrabajoAction(Request $request)
    {
        $linea_trabajo_id = $request->get('linea_trabajo_id');
     
        $em = $this->getDoctrine()->getManager();
        $correlativo = $em->getRepository('BenDoctorsBundle:LineaTrabajo')
                            ->findByCorrelativoLineaTrabajoId($linea_trabajo_id);
        
        //exit(\Doctrine\Common\Util\Debug::dump("HOLA"));
        /*$lineaTrabajos = array(
                            'number' => array('1','2','3'),
                            'alfabeth' => array('a','b','c'),
                            'alfa' => array('$','&','#'));}*/
        return new JsonResponse($correlativo);
    }
    public function aprobarAction(Request $request, $users)
    {
        //exit(\Doctrine\Common\Util\Debug::dump(array("APROBAR",$users)));
        $em = $this->getDoctrine()->getManager();
        $security = $this->container->get('security.context');
        if(!$security->isGranted('ROLE_MANAGER'))
            $ids = array($security->getToken()->getUser()->getId());
        elseif($users !== 'nothing')$ids = explode(',', $users);
        else $ids = null;
        
        $entities = $em->getRepository('BenDoctorsBundle:RecepcionPago')->search(array('ids'=>$ids));
        
        //exit(\Doctrine\Common\Util\Debug::dump(array("IDS",$ids)));
        foreach ($entities as $entity){
            // verificando si el estado es 3. Es decir si las RP están listas para ser APROBADAS.
            if($entity->getEstado() == 3){
                $entity->setEstado(4);
                $entity->setEstaAprobado($em->getReference('BenDoctorsBundle:EstaAprobado', 2));
                $em->persist($entity);
            }
        }
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('info', "Acta de recepción/pago aprobadas exitosamente.");
        return $this->redirect($this->generateUrl('recepcion_pago'));
    }
    public function generarNotaEnvioPdfAction(Request $request, $users)
    {
        //exit(\Doctrine\Common\Util\Debug::dump(array("NOTA ENVIO",$users)));
        $em = $this->getDoctrine()->getManager();

        $security = $this->container->get('security.context');
        if(!$security->isGranted('ROLE_MANAGER'))
            $ids = array($security->getToken()->getUser()->getId());
        elseif($users !== 'nothing')$ids = explode(',', $users);
        else $ids = null;
        
        $entities = $em->getRepository('BenDoctorsBundle:RecepcionPago')
                       ->search(
                            array('ids'=>$ids,'estadoDesdeNotaEnvio'=>4,'estaAprobadoDesdeNotaEnvio'=>'Aprobado o Rechazado')
                        );
        
        //exit(\Doctrine\Common\Util\Debug::dump(count($entities)));
        $unidad = '';
        $lineaDeTrabajo = '';
        foreach($entities as $entity){
            $unidad = $entity->getUnidad();
            $lineaTrabajo = $entity->getLineaTrabajo();
            break;
        }
        
        $now = (new \DateTime)->format('d-m-Y_H-i');
        $pagina = 'BenDoctorsBundle:RecepcionPago:nota_envio.html.twig';
        
       /*return $this->render($pagina, array('entities'=>$entities,'unidad'=>$unidad,'lineaTrabajo'=>$lineaTrabajo));*/
        
        $html = $this->renderView($pagina, 
                                  array(
                                    'entities'      =>  $entities,
                                    'unidad'        =>  $unidad,
                                    'lineaTrabajo'  =>  $lineaTrabajo
                                ));
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="carte'.$now.'.pdf"'
            )
        );
    }
}