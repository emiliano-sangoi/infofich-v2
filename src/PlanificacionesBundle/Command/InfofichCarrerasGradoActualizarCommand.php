<?php

namespace PlanificacionesBundle\Command;

use Doctrine\ORM\EntityManager;
use PlanificacionesBundle\Entity\Carrera;
use FICH\APIInfofich\Model\Carrera as CarreraWS;
use PlanificacionesBundle\Repository\CarreraRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use FICH\APIInfofich\Query\Carreras\QueryCarreras;
use FICH\APIRectorado\Config\WSHelper;

class InfofichCarrerasGradoActualizarCommand extends ContainerAwareCommand
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

    protected function configure()
    {
        $this
            ->setName('infofich:carreras-grado:actualizar')
            ->setDescription('Importa/actualiza de los web services las carreras de grado de FICH')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Impacta los cambios en la base de datos.');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $this->repoCarreras = $this->em->getRepository(Carrera::class);

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
        $this->output->writeln( "\n" . 'Actualizando ' . ($this->force ? '(Force activado)' : '(Modo seguro)' . "\n"));

        $query = new QueryCarreras();
        $query->setUnidadAcademica(WSHelper::UA_FICH)
            ->setTipoTitulo(WSHelper::TIPO_TITULO_GRADO)
            ->setWsEnv(WSHelper::ENV_PROD)
            ->setCacheEnabled(false);

        $cn = $cu = 0;

        $todas_las_carreras = $query->getResultado();

        /* @var $carreraWs CarreraWS */
        foreach ($todas_las_carreras as $carreraWs){
            $cod = $carreraWs->getCodigoCarrera();

            $this->output->writeln('Carrera: ' . $cod);
            $this->output->writeln('Nombre: ' . $carreraWs->getNombreCarrera());

            /* @var $carrera Carrera */
            $carrera = $this->repoCarreras->findOneBy([
                'codigoCarrera' => $carreraWs->getCodigoCarrera(),
                'planCarrera' => $carreraWs->getPlanCarrera(),
                'versionPlan' => $carreraWs->getVersionPlan(),
                'estado' => $carreraWs->getEstado(),
            ]);

            if(!$carrera){
                $this->output->writeln('Creando carrera en BD ...');
                $carrera = new Carrera();
                $carrera->setCodigoCarrera($cod);
            }else{
                $f = $carrera->getFechaActualizacion();
                $this->output->writeln('La carrera existe en la base de datos. Fecha última actualización: ' . ($f ? $f->format('d/m/Y H:i') : ' - '));
                $this->output->writeln('Actualizando carrera ...');
            }

            $carrera->setNombreCarrera($carreraWs->getNombreCarrera());
            $carrera->setPlanCarrera($carreraWs->getPlanCarrera());
            $carrera->setVersionPlan($carreraWs->getVersionPlan());
            $carrera->setEstado($carreraWs->getEstado());
            $carrera->setTipoTitulo($carreraWs->getTipoTitulo());
            $carrera->setTipoCarrera($carreraWs->getTipoCarrera());
            $carrera->setAlcanceTitulo($carreraWs->getAlcanceTitulo());

            $carrera->setFechaActualizacion(new \DateTime());

            if($carrera->getId() == null){
                $this->em->persist($carrera);
                $this->output->writeln('Carrera creada.');
                $cn++;
            }else{
                $this->output->writeln('Carrera actualizada.');
                $cu++;
            }

            if($this->force){
                $this->output->writeln('Impactando cambios en la base de datos.');
                $this->em->flush();
            }

            $this->output->writeln('');
            $this->output->writeln('------------------------------------------------------------------------------');
        }


        $this->output->writeln('');
        $this->output->writeln('Resúmen: ');
        $this->output->writeln('Carreras creadas: ' . $cn);
        $this->output->writeln('Carreras actualizadas: ' . $cu);

    }

}
