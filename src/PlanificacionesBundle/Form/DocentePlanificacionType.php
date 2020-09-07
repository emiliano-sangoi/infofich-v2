<?php

namespace PlanificacionesBundle\Form;

use FICH\APIInfofich\Query\Docentes\QueryDocentes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class DocentePlanificacionType extends AbstractType {

    /**
     *
     * @var \Doctrine\ORM\EntityManager 
     */
    protected $em;

    /**
     *
     * @var PlanificacionesBundle\Repository\DocenteRepository 
     */
    protected $repoDocente;

    /**
     *
     * @var AppBundle\Repository\PersonaRepository  
     */
    protected $repoPersona;

    /**
     *
     * @var array 
     */
    protected $options;

    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
        $this->repoDocente = $em->getRepository('\PlanificacionesBundle\Entity\Docente');
        $this->repoPersona = $em->getRepository('\AppBundle\Entity\Persona');
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $this->options = $options;

        //dump($options['planificacion']);exit;

        $builder->add('nomape', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Nombre y apellido',
            'mapped' => false,
            'required' => true,
            'choices' => $this->getDocentes(),
            'attr' => array('class' => 'form-control js-select2')
        ));

        $builder->add('docente', 'PlanificacionesBundle\Form\DocenteType', array(
            'label' => false
        ));

       // dump($builder->getData());exit;

        $builder->get('nomape')->addEventListener(
                FormEvents::SUBMIT, array($this, 'onSubmitData')
        );
        
       
    }

    public function onSubmitData(FormEvent $event) {
//        function () {                
        //$sport = $event->getForm()->getData();
        $pos = $event->getData();
        $docentes = $this->getDocentes();
        $docente = isset($docentes[$pos]) ? $docentes[$pos] : null;
        if (!$docente) {
            throw new Exception('Ocurrio un error al intentar recuperar el docente.');
        }


        // Buscar si el docente existe
        $oDocente = $this->repoDocente->findOneBy(array(
            'nroLegajo' => $docente->getNumeroLegajo()
        ));

        if (!$oDocente) {
            //$oDocente = new \PlanificacionesBundle\Entity\Docente();
            $oDocente = new \PlanificacionesBundle\Entity\Docente();


            $persona = $this->repoPersona->findOneBy(array(
                'documento' => $docente->getNumeroDocumento()
            ));

            if (!$persona) {
                $persona = new \AppBundle\Entity\Persona();
                $persona->setApellidos(ucwords(strtolower($docente->getApellido())));
                $persona->setNombres(ucwords(strtolower($docente->getNombre())));
                $persona->setDocumento($docente->getNumeroDocumento());
                $cod_tipo_doc = \FICH\APIRectorado\Config\WSHelper::getCodigoTipoDocPorDesc($docente->getTipoDocumento());
                $persona->setTipoDocumento($cod_tipo_doc);
                $persona->setCuil($docente->getCuil());

                $this->em->persist($persona);
                $this->em->flush();
            }


            $oDocente->setPersona($persona);
            $oDocente->setNroLegajo($docente->getNumeroLegajo());
            $this->em->persist($oDocente);
            $this->em->flush();
        }

        $oDocente->setEmail($docente->getEmail() ?: null );

        // Si no existe se crea
        //Buscar si existe la persona
        //$docente = $docentes[ $pos ];
        //$dataForm = $event->getForm()->getData();
//dump($oDocente);exit;
//        $o = $event->getForm()->getParent()->getData();

        $event->getForm()->getParent()->get('docente')->setData($oDocente);

        //dump($oDocente, $o, );
//        dump($event->getForm()->getParent()->get('docente')->getData(), $pos, $docente, $sport);
        //exit;
//                $formModifier($event->getForm(), $data->getSport());
//            }
    }
    
//    public function onPreSetData(FormEvent $event) {
//        
//        //$sport = $event->getForm()->getData();
//        $dataForm = $event->getData();
//        
//        dump($dataForm);exit;
//    }

    public function getDocentes() {

        $q = new QueryDocentes();
        $docentes = $q->setCacheEnabled(true)
                ->getDocentes();
//dump($docentes);exit;
        return $docentes;
    }

}
