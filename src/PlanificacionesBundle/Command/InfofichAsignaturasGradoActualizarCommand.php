<?php

namespace PlanificacionesBundle\Command;

use Doctrine\ORM\EntityManager;
use PlanificacionesBundle\Entity\Asignatura;
use PlanificacionesBundle\Entity\Carrera;
use PlanificacionesBundle\Repository\AsignaturaRepository;
use PlanificacionesBundle\Repository\CarreraRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use FICH\APIInfofich\Query\Carreras\QueryMateriasCarrera;
use FICH\APIInfofich\Model\Materia;
use FICH\APIRectorado\Config\WSHelper;


class InfofichAsignaturasGradoActualizarCommand extends ContainerAwareCommand
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


    protected function configure()
    {
        $this
            ->setName('infofich:asignaturas-grado:actualizar')
            ->setDescription('Importa/actualiza de los web services las asignaturas de grado de FICH')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Impacta los cambios en la base de datos.');;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $this->repoCarreras = $this->em->getRepository(Carrera::class);
        $this->repoAsignaturas = $this->em->getRepository(Asignatura::class);

        $this->force = $input->getOption('force');

        if ($this->force === true) {
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

    private function actualizar()
    {


        $carreras = $this->repoCarreras->findAll();

        $c = [];

        /* @var $carrera Carrera */
        foreach ($carreras as $carrera) {

            //Contadores de registros nuevos y actualizados por carrera:
            $c[$carrera->getId()] = [
                'cn' => 0,
                'cu' => 0,
            ];

            $this->output->writeln('Carrera: ' . $carrera->__toString2());
            $this->output->writeln('====================================================================================');

            $query = new QueryMateriasCarrera();
            $query->setUnidadAcademica(WSHelper::UA_FICH)
                ->setTipoTitulo(WSHelper::TIPO_TITULO_GRADO) // <- Si se quiere hacer dinamico deberia guardarse el codigo en la bd en lugar de "Grado"
                ->setCarrera($carrera->getCodigoCarrera())
                ->setPlan($carrera->getPlanCarrera())
                ->setVersion($carrera->getVersionPlan())
                ->setWsEnv(WSHelper::ENV_PROD)
                ->setCacheEnabled(true);

            $todas_las_asignaturas = $query->getResultado();

            /* @var $asignaturaWs Materia */
            foreach ($todas_las_asignaturas as $asignaturaWs) {

                $this->output->writeln('Asignatura: ' . $asignaturaWs->getCodigoMateria() . ' - ' . $asignaturaWs->getNombreMateria());

                //Buscar solo en las asignaturas cargadas desde WS:
                $asignatura = $this->repoAsignaturas->findOneBy([
                    'carrera' => $carrera,
                    'codigoAsignatura' => $asignaturaWs->getCodigoMateria(),
                    'origenWs' => true
                ]);

                if (!$asignatura) {
                    $this->output->writeln('Creando asignatura en BD ...');
                    $asignatura = new Asignatura();
                    $asignatura->setCarrera($carrera);
                    $asignatura->setOrigenWs(true);
                }else{
                    $f = $carrera->getFechaActualizacion();
                    $this->output->writeln('La asignatura existe en la base de datos. Fecha última actualización: ' . ($f ? $f->format('d/m/Y H:i') : ' - '));
                    $this->output->writeln('Actualizando asignatura ...');
                }


                $asignatura->setNombreAsignatura(mb_strtoupper($asignaturaWs->getNombreMateria()));
                $asignatura->setCodigoAsignatura($asignaturaWs->getCodigoMateria());
                $asignatura->setTipoAsignatura($asignaturaWs->getTipoMateria());
                $asignatura->setHsSemanales($asignaturaWs->getHorasSemanales());
                $asignatura->setCargaHoraria($asignaturaWs->getCargaHoraria());
                $asignatura->setValorAsignatura($asignaturaWs->getValorMateria());
                $asignatura->setPromediable($asignaturaWs->getPromediable());
                $asignatura->setObligatoria($asignaturaWs->getObligatoria());
                $asignatura->setAnioCursada($asignaturaWs->getAnioCursada());
                $asignatura->setPeriodoCursada($asignaturaWs->getPeriodoCursada());
                $asignatura->setTipoCursada($asignaturaWs->getTipoCursada());

                $asignatura->setFechaActualizacion(new \DateTime());

                if($asignatura->getId() == null){
                    $this->em->persist($asignatura);
                    $this->output->writeln('Asignatura creada.');
                    $c[$carrera->getId()]['cn']++;
                }else{
                    $this->output->writeln('Asignatura actualizada.');
                    $c[$carrera->getId()]['cu']++;
                }

                $this->output->writeln('------------------------------------------------------------------------------');

            }
        }

        if($this->force){
            $this->output->writeln('Impactando cambios en la base de datos.');
            $this->em->flush();
        }

        $this->output->writeln('');
        $this->output->writeln('Resúmen: ');
        $this->output->writeln('Asignaturas creadas(cn) y actualizadas(cu): ');
        print_r($c);


    }

// =============================================================================================


}
