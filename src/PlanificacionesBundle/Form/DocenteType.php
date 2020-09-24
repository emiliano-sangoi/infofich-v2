<?php

namespace PlanificacionesBundle\Form;

use FICH\APIInfofich\Query\Docentes\QueryDocentes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocenteType extends AbstractType {
    
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

        $builder->add('persona', 'PlanificacionesBundle\Form\PersonaType', array(
//            'label' => 'Nombre y apellido',
            
            //IMPORTANTE. 
            //Este campo no debe estar mapeado al campo de la base de datos ya que se debe aplicar cierta logica a la persona.
            //Si la persona existe se busca y actualiza
            //caso contrario se inserta.
            'mapped' => false,
//            'required' => false,
//            'choices' => $this->getDocentes(),
//            'attr' => array('class' => 'form-control js-select2')
        ));

        $builder->add('nroLegajo', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
            'label' => 'Nombre y apellido',
            //'mapped' => false,
            'required' => true,
            'choices' => $this->getDocentes(),
            'attr' => array('class' => 'form-control js-select2')
        ));


//        $builder->get('nroLegajo')->addEventListener(
//                FormEvents::SUBMIT, array($this, 'onSubmitData')
//        );



//        $builder->add('nomape', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
//            'label' => 'Nombre y apellido',
//            'mapped' => false,
//            'required' => false,
//            'choices' => $this->getDocentes(),
//            'attr' => array('class' => 'form-control js-select2')
//        ));
//        
//        
//        $builder->add('nroLegajo', 'Symfony\Component\Form\Extension\Core\Type\HiddenType', array(
//            'attr' => array('class' => '')
//        ));
//        
//        $builder->add('telefono', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
//            'label' => 'Teléfono',
//            'mapped' => false,
//            'attr' => array('class' => 'form-control telefono', 'disabled' => 'disabled')
//        ));
//        
//        $builder->add('email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', array(
//            'label' => 'Correo electrónico',
//            'mapped' => false,
//            'attr' => array('class' => 'form-control email', 'disabled' => 'disabled')
//        ));

        $f = function() {

            // obtener 
        };

        //TODO: se debe buscar e instanciar una persona
//        $builder->get('nomape')->addEventListener(
//            FormEvents::SUBMIT,
//            function (FormEvent $event) {                
//                $pos = $event->getData();
//                $docentes = $this->getDocentes();
//                //$docente = $docentes[ $pos ];
//                
//                
//                
//                //$dataForm = $event->getForm()->getData();
//                
//                
//                dump($pos, $docentes);exit;
//
////                $formModifier($event->getForm(), $data->getSport());
//            }
//        );
//        
//        $builder->addEventListener(
//            FormEvents::SUBMIT,
//            array($this, 'onSubmitData')            
//        );
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
        
        dump($docente, $pos);


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

        //$event->getForm()->getParent()->get('docente')->setData($oDocente);

        //dump($oDocente, $o, );
//        dump($event->getForm()->getParent()->get('docente')->getData(), $pos, $docente, $sport);
        //exit;
//                $formModifier($event->getForm(), $data->getSport());
//            }
    }

//    public function onSubmitData(FormEvent $event) {
////        function () {                
//        $sport = $event->getForm()->getData();
//        $pos = $event->getData();
//        $docentes = $this->getDocentes();
//
//
//        //Buscar si existe la persona
//        //$docente = $docentes[ $pos ];
//        //$dataForm = $event->getForm()->getData();
//
//
//        dump($pos, $sport);
//        exit;
//
////                $formModifier($event->getForm(), $data->getSport());
////            }
//    }

    public function getDocentes() {

        $q = new QueryDocentes();
        $docentes = $q->setCacheEnabled(true)
                ->getDocentes();

        return $docentes;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'PlanificacionesBundle\Entity\Docente'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'planificacionesbundle_docente';
    }

}
