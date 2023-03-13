<?php

namespace AppBundle\Command;

use Doctrine\ORM\EntityManager;
use PlanificacionesBundle\Entity\Carrera;
use PlanificacionesBundle\Repository\CarreraRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class InfofichAlumnosPorCarreraCommand extends ContainerAwareCommand
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
            ->setName('infofich:alumnos-por-carrera')
            ->setDescription('Carga y/o actualiza los alumnos de grado de fich por carrera')
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

    }

}
