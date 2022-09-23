<?php

namespace PlanificacionesBundle\Command;

use Doctrine\ORM\EntityManager;
use PlanificacionesBundle\Entity\Asignatura;
use PlanificacionesBundle\Entity\Carrera;
use PlanificacionesBundle\Entity\Planificacion;
use PlanificacionesBundle\Repository\AsignaturaRepository;
use PlanificacionesBundle\Repository\CarreraRepository;
use PlanificacionesBundle\Repository\PlanificacionRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class VincularAsignaturaCommand extends ContainerAwareCommand
{

    /**
     *
     * @var OutputInterface
     */
    private $output;

    /**
     *
     * @var InputInterface
     */
    private $input;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var boolean
     */
    private $force;

    /**
     * @var CarreraRepository
     */
    private $repoCarreras;

    /**
     * @var AsignaturaRepository
     */
    private $repoAsignaturas;

    /**
     * @var PlanificacionRepository
     */
    private $repoPlanificaciones;

    protected function configure()
    {
        $this
            ->setName('infofich:planificaciones:vincular-asignatura')
            ->setDescription('Asocia la planificacion con su asignatura correspondiente.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Impacta los cambios en la base de datos.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->output = $output;
        $this->em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $this->repoCarreras = $this->em->getRepository(Carrera::class);
        $this->repoAsignaturas = $this->em->getRepository(Asignatura::class);
        $this->repoPlanificaciones = $this->em->getRepository(Planificacion::class);

        $this->force = $input->getOption('force');

        if($this->force === true){
            $helper = $this->getHelper('question');
            $msg = "Esta ejecutando el comando con la opción 'force' activada, " .
                "¿esta seguro/a que desea aplicar los cambios en la base de datos? (y/n): ";
            $question = new ConfirmationQuestion($msg, false);
            if (!$helper->ask($this->input, $this->output, $question)) {
                $this->output->writeln('Accion cancelada');
                return;
            }
        }

        $this->actualizar();
    }

    private function actualizar(){

        $planificaciones = $this->repoPlanificaciones->findAll();

        $planif_sin_match = [];

        /* @var $planif Planificacion */
        foreach ($planificaciones as $planif){

            $carrera = $this->repoCarreras->findOneBy([
                'codigoCarrera' => $planif->getCarrera(),
                'planCarrera' => $planif->getPlan(),
                'versionPlan' => $planif->getVersionPlan(),
                'estado' => 'V'
            ]);

            $asignatura = $this->repoAsignaturas->findOneBy([
                'carrera' => $carrera,
                'codigoAsignatura' => $planif->getCodigoAsignatura(),
                'origenWs' => true
            ]);

            if(!$asignatura){
                $planif_sin_match[] = $planif;
            }

            $this->output->writeln('Planificacion: ' . $planif);
            $this->output->writeln('- Datos de la planificacion: ');
            $this->output->writeln("\t Carrera: " . $planif->getCarrera());
            $this->output->writeln("\t Plan: " . $planif->getPlan());
            $this->output->writeln("\t Version plan: " . $planif->getVersionPlan());
            $this->output->writeln("\t Año academico: " . $planif->getAnioAcad());
            $this->output->writeln('- Datos de la asignatura a vincular: ');
            $this->output->writeln("\t Asignatura a vincular: " . ($asignatura ?: ' - '));
            $this->output->writeln("\t Id asignatura: " . ($asignatura ? $asignatura->getId() : ' - '));
            $this->output->writeln("\t Tipo asignatura: " . ($asignatura ? $asignatura->getTipoAsignatura() : ' - '));
            $this->output->writeln("\t Carrera: " . ($carrera ?: ' - '));
            $this->output->writeln("\t Codigo carrera: " . ($carrera ? $carrera->getCodigoCarrera() : ' - '));
            $this->output->writeln("\t Plan carrera: " . ($carrera ? $carrera->getPlanCarrera() : ' - '));
            $this->output->writeln("\t Version plan carrera: " . ($carrera ? $carrera->getVersionPlan() : ' - '));
            $this->output->writeln('');


        }

        $this->output->writeln("\nPlanificaciones sin asignatura en tabla planif_asignaturas: ");
        foreach ($planif_sin_match as $planif){
            $str = "ID: " . str_pad($planif->getId(), 6) . " | " .
                 "Año acad: " . str_pad($planif->getAnioAcad(), 6) . " | " .
                    "Cod asignatura: ". str_pad($planif->getCodigoAsignatura(), 10) . " | " .
                    "NOM: ". str_pad(mb_strtoupper($planif->getNombreAsignatura()), 75, '-') . " | " .
                    "Carrera: " . str_pad($planif->getCarrera(), 5) . " | \t" .
                    "Plan: " . str_pad($planif->getPlan(), 8) . " | ";

            $this->output->writeln($str);
        }


    }

}
