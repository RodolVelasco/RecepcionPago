<?php

namespace Ben\DoctorsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Ben\DoctorsBundle\Entity\RecepcionPago;
use Ben\DoctorsBundle\Form\RecepcionPagoType;

use Ben\DoctorsBundle\Entity\RecepcionTecnico;
use Ben\DoctorsBundle\Form\RecepcionTecnicoType;

use Ben\DoctorsBundle\Entity\RecepcionTecnicoRepository;

use Ben\DoctorsBundle\Entity\TipoContratacion;

use Ben\DoctorsBundle\Pagination\Paginator;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * RecepcionTecnico controller.
 *
 */
class RecepcionTecnicoController extends Controller
{

    /**
     * Lists all Person entities.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function indexAction()
    {
        // var_dump($this);die;
        $em = $this->getDoctrine()->getManager();
        $entitiesLength = $em->getRepository('BenDoctorsBundle:RecepcionPago')->counterTecnico();
        $periodos = $em->getRepository('BenDoctorsBundle:RecepcionPago')->getPeriodos();
        $unidades = $em->getRepository('BenDoctorsBundle:RecepcionPago')->getUnidades();
        $tipoContrataciones = $em->getRepository('BenDoctorsBundle:RecepcionPago')->getTipoContrataciones();
        $proveedores = $em->getRepository('BenDoctorsBundle:RecepcionPago')->getProveedores();
        
        return $this->render('BenDoctorsBundle:RecepcionTecnico:index.html.twig', array(
            'periodos' => $periodos,
            'unidades' => $unidades,
            'tipoContrataciones' => $tipoContrataciones,
            'proveedores' => $proveedores,
            'entitiesLength' => $entitiesLength));
    }

    /**
     * persons list using ajax
     * @Secure(roles="ROLE_USER")
     */
    public function ajaxListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $searchParam = $request->get('searchParam');
        //exit(\Doctrine\Common\Util\Debug::dump($searchParam));
        $estado = 1;
        $entities = $em->getRepository('BenDoctorsBundle:RecepcionPago')->searchTecnico($searchParam, $estado);
        $pagination = (new Paginator())->setItems(count($entities), $searchParam['perPage'])->setPage($searchParam['page'])->toArray();
        return $this->render('BenDoctorsBundle:RecepcionTecnico:ajax_list.html.twig', array(
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
        $form = $this->createForm(new RecepcionPagoType(), $entity);
        
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        
        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', "Acta de recepción/pago guardado exitosamente.");
            return $this->redirect($this->generateUrl('recepcion_pago_show', array('id' => $entity->getId())));
        }

        $this->get('session')->getFlashBag()->add('danger', "Se encontraron errores en el formulario al intentar guardar la información !");
        return $this->render('BenDoctorsBundle:RecepcionPago:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Person entity.
     * @Secure(roles="ROLE_USER")
     *
     */
    public function newAction(Request $request)
    {
        $data = array();
    	$form = $this->createFormBuilder($data)->add('info','textarea', array(
    	        'label' => 'Información',
                'attr' => array('class' => 'tinymce',
                                'cols' => '120',
                                'rows' => '20'
                            ),))->getForm();
                            
        $form->handleRequest($request);
        if($form->isValid()){
            $data = $form->getData();
            $info_splitted_primer_nivel = explode('|', $data['info']);
            
            $conta_primer_nivel = 0;
            foreach ($info_splitted_primer_nivel as $item_primer_nivel){
                $conta_primer_nivel++;
                $info_splitted = explode('--', $item_primer_nivel);
                
    			$info_splitted_array = array();
    			$item_splitted_array = array();
    			$conta = 0;
    			foreach ($info_splitted as $item){
            	    $conta++;
            	    if($conta == 3 || $conta == 4){
            	        //exit(\Doctrine\Common\Util\Debug::dump($item));
    				    //$item_splitted = explode(' ', $item);
    				    $item_splitted_array[] = ltrim(rtrim(strtok($item,' '))); //id de unidad presu, id linea trabajo
    				    //exit(\Doctrine\Common\Util\Debug::dump());
            	    }else{
            	        $info_splitted_array[] = ltrim(rtrim($item));
            	    }
            	    
    			}
    			/*
    			$info_splitted_array[0] = proveedor
    			$info_splitted_array[1] = periodo
    			$info_splitted_array[2] = valorFactura
    			$info_splitted_array[3] = numeroReferencia
    			
    			$item_splitted_array[0] = codigoUnidad
    			$item_splitted_array[1] = codigoLineaTrabajo
    			*/
    			//exit(\Doctrine\Common\Util\Debug::dump($info_splitted_array[0]));
    			
    			if(count($info_splitted_array) != 4 AND (count($item_splitted_array) != 2))
    			{
    		        throw $this->createNotFoundException('Se encontraron errores en los parámetros enviados en el formulario.');	
    			}
    		    
    		    $em = $this->getDoctrine()->getManager();
    			$query = $em->createQuery(
    					    'SELECT P
    					    FROM BenDoctorsBundle:Proveedor P
    						WHERE P.razonSocial like :razonSocial'
    				);
    			$query->setParameter("razonSocial", '%'.$info_splitted_array[0].'%');
    			$proveedor = $query->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    			//exit(\Doctrine\Common\Util\Debug::dump($proveedor));
    			
    			$em = $this->getDoctrine()->getManager();
    			$query = $em->createQuery(
    					    'SELECT P
    					    FROM BenDoctorsBundle:Periodo P
    						WHERE P.periodo = :periodo'
    				);
    			$query->setParameter("periodo", $info_splitted_array[1]);
    			$periodo = $query->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    		    //exit(\Doctrine\Common\Util\Debug::dump($periodo));
    		    
    		    $em = $this->getDoctrine()->getManager();
    			$query = $em->createQuery(
    					    'SELECT U
    					    FROM BenDoctorsBundle:Unidad U
    						WHERE U.estado = 1 AND
    							  U.codigo = :codigoUnidad'
    				);
    			$query->setParameter("codigoUnidad", $item_splitted_array[0]);
    			$unidad = $query->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    		    //exit(\Doctrine\Common\Util\Debug::dump($unidad));
    		    //exit(\Doctrine\Common\Util\Debug::dump($item_splitted_array));
    		    
    		    $em = $this->getDoctrine()->getManager();
    			$query = $em->createQuery(
    					    'SELECT LT
    					    FROM BenDoctorsBundle:LineaTrabajo LT
    					         INNER JOIN LT.unidad U
    						WHERE U.estado = 1 AND
    						      LT.estado = 1 AND
    						      U.codigo = :codigoUnidad AND
    							  LT.codigo = :codigoLineaTrabajo'
    				);
    			$query->setParameter("codigoUnidad", $item_splitted_array[0])
    			      ->setParameter("codigoLineaTrabajo", $item_splitted_array[1]);
    			$lineaTrabajo = $query->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    			//exit(\Doctrine\Common\Util\Debug::dump($lineaTrabajo));
    			
    			$entity = new RecepcionPago();
    			$entity->setProveedor($proveedor[0]);
    			$entity->setUnidad($unidad[0]);
    			$entity->setLineaTrabajo($lineaTrabajo[0]);
    			$entity->setPeriodo($periodo[0]);
    			$entity->setValorFactura($info_splitted_array[2]);
    			$entity->setNumeroReferencia($info_splitted_array[3]);
    			    $tipoContratacion = new TipoContratacion();
    			    $em = $this->getDoctrine()->getManager();
    			    $tipoContratacion = $em->getRepository('BenDoctorsBundle:TipoContratacion')->find(2);
    			$entity->setTipoContratacion($tipoContratacion);
    			$entity->setEstado(1);
    			//exit(\Doctrine\Common\Util\Debug::dump($entity));
    			
    			$em->persist($entity);
    			$em->flush();
    			
            }// FIN foreach info_splitted_primer_nivel
            $this->get('session')->getFlashBag()->add('info', $conta_primer_nivel." acta(s) de recepción/pago fue(ron) guardada(s) exitosamente.");
            //return $this->redirect($this->generateUrl('recepcion_tecnico_show', array('id' => $entity->getId())));
            return $this->redirect($this->generateUrl('recepcion_tecnico'));
        }

        return $this->render('BenDoctorsBundle:RecepcionTecnico:new.html.twig', array(
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

        return $this->render('BenDoctorsBundle:RecepcionTecnico:show.html.twig', array(
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
        $editForm = $this->createForm(new RecepcionTecnicoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BenDoctorsBundle:RecepcionTecnico:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
        $editForm = $this->createForm(new RecepcionTecnicoType(), $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', "El acta de recepción y pago fue modificada exitosamente.");
            return $this->redirect($this->generateUrl('recepcion_tecnico_edit', array('id' => $id)));
        }
        
        $this->get('session')->getFlashBag()->add('danger', "Se encontraron errores en el formulario presentado !");
        return $this->render('BenDoctorsBundle:RecepcionTecnico:edit.html.twig', array(
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
            $this->get('session')->getFlashBag()->add('info', "Acta de recepción y pago fue eliminada exitosamente !");
        }

        return $this->redirect($this->generateUrl('recepcion_tecnico'));
    }

    /**
     * Creates a form to delete a RecepcionPago entity by id.
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
}
