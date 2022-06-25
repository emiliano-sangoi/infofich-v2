<?php

namespace PlanificacionesBundle\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use PlanificacionesBundle\Entity\Bibliografia;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BibliografiaType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        /*$this->addTitulo($builder, $options);
        $this->addAutores($builder, $options);

        $builder
                ->add('editorial', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'Editorial',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                    )
        ));


        $builder
                ->add('anioEdicion', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', array(
                    'label' => 'Año de edición',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                        'min' => 1800,
                        'max' => date("Y"),
                    )
        ));


        $builder
                ->add('nroEdicion', 'Symfony\Component\Form\Extension\Core\Type\IntegerType', array(
                    'label' => 'N° de edición',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                        'min' => 1,
                        'max' => 32000,
                    )
        ));


        $builder
                ->add('issnIsbn', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                    'label' => 'ISSN o ISBN',
                    'required' => false,
                    'attr' => array(
                        'class' => 'form-control'
                    )
        ));


        $this->addDisponibleBiblioteca($builder, $options);
        $this->addDisponibleOnline($builder, $options);

        $builder
                ->add('fechaConsultaOnline', "Symfony\Component\Form\Extension\Core\Type\DateType", array(
                    'attr' => array('class' => 'form-control', 'placeholder' => 'dd/mm/AAAA'),
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => false,
                    'label' => 'Fecha consulta online',
                    'label_attr' => array('class' => 'font-weight-bold requerido', 'title' => 'Este campo es obligatorio.')));


        $builder
                ->add('enlaceOnline', 'Symfony\Component\Form\Extension\Core\Type\UrlType', array(
                    'label' => 'Enlace',
                    'required' => false,
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'http://www.mipagina.com'
                    )
        ));*/

        $builder
                ->add('infoCompleta', TextareaType::class, array(
                    'label' => 'Referencia bibliográfica',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                        'rows' => 5
                    )
        ));

        $builder->add('posicion', HiddenType::class, array(
            'attr' => array(
                'class' => 'posicion',
            )
        ));

        $this->addTipo($builder, $options);

    }

    public function addTipo(FormBuilderInterface $builder, array $options) {

        $config = array(
            'label' => 'Tipo bibliografía',
            'class' => 'PlanificacionesBundle:TipoBibliografia',
            'choice_label' => 'nombre',
            'expanded' => true,
            'required' => true,
        );

//        $bp = $builder->getData();
//        dump($bp);exit;
//        if ($bp instanceof BibliografiaPlanificacion && is_null($bp->getTipoBibliografia())) {
//            $default = $this->repoTipos->findOneBy(array(
//                'codigo' => TipoBibliografia::BASICA
//            ));
//
//            $config['data'] = $default;
//        }

        $builder->add('tipoBibliografia', EntityType::class, $config);
    }

    public function addTitulo(FormBuilderInterface $builder, array $options) {

        $builder->add('titulo', TextType::class, array(
            'label' => 'Título',
            'required' => true,
            'attr' => array(
                'class' => 'form-control'
            )
        ));
    }

    public function addAutores(FormBuilderInterface $builder, array $options) {
        $builder->add('autores', TextType::class, array(
            'label' => 'Autores',
            'required' => true,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Apellido, NOMBRE'
            )
        ));
    }

    public function addDisponibleBiblioteca(FormBuilderInterface $builder, array $options) {

        $config = array(
            'label' => '¿Disponible en biblioteca?',
            'choices' => array(
                'Si' => true,
                'No' => false,
            ),
            'choices_as_values' => true,
            'required' => true,
            'expanded' => true
        );

        $builder->add('disponibleBiblioteca', ChoiceType::class, $config);
    }

    public function addDisponibleOnline(FormBuilderInterface $builder, array $options) {

        $config = array(
            'label' => '¿Disponible online?',
            'choices' => array(
                'Si' => true,
                'No' => false,
            ),
            'choices_as_values' => true,
            'required' => true,
            'expanded' => true
        );

        $builder->add('disponibleOnline', ChoiceType::class, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Bibliografia::class
        ));
    }

}
