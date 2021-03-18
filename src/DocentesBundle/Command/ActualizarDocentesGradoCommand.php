<?php

namespace DocentesBundle\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use DocentesBundle\Service\DocenteService;

class ActualizarDocentesGradoCommand extends ContainerAwareCommand {

    /**
     *
     * @var EntityManager 
     */
    private $em;

    /**
     *
     * @var InputInterface 
     */
    private $input;

    /**
     *
     * @var OutputInterface 
     */
    private $output;

    /**
     *
     * @var boolean
     */
    private $force = false;

    /**
     *
     * @var boolean
     */
    private $print = false;

    /**
     *
     * @var DocenteService 
     */
    private $docenteService;
    private $sep1;
    private $sep2;

    const OPT_FORCE = 'force';
    const OPT_PRINT = 'print';

    protected function configure() {
        $this
                ->setName('infofich:docentes-grado:actualizar')
                ->setDescription('Carga/Actualiza la tabla de docentes_grado del sistema.')
                ->addOption(self::OPT_FORCE, 'f', InputOption::VALUE_NONE, 'Ejecuta el comando sin impactar cambios en base de datos.')
                ->addOption(self::OPT_PRINT, 'p', InputOption::VALUE_NONE, 'Imprime la información de los docentes actualizados.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $this->sep1 = '===========================================================================================================';
        $this->sep2 = '-----------------------------------------------------------------------------------------------------------';

        $this->input = $input;
        $this->output = $output;
        $this->em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $this->docenteService = $this->getContainer()->get('docentes_grado.docentes');

        $this->force = $input->getOption(self::OPT_FORCE);
        $this->print = $input->getOption(self::OPT_PRINT);

        if ($this->force) {
            $this->output->writeln('Force!!!!');
            $res = $this->docenteService->actualizar();
            if ($res === false) {
                $this->output->writeln('Ocurrieron errores al actualizar: ');
                $this->output->writeln($this->docenteService->getUltimoError());
                return;
            } else {
                $this->output->writeln($this->sep2);
                $this->output->writeln('Cambios realizados correctamente en la base de datos.');
                $this->output->writeln($this->sep2);
                $this->output->writeln('');
            }
        } else {
            $this->docenteService->generarReporte();
            //dump($reporte);exit;
            //$this->output->writeln('sin force');
        }

        $reporte = $this->docenteService->getReporte();
        $this->imprimirReporte($reporte);
    }

    private function imprimirReporte($reporte) {

        $this->output->writeln($this->sep1);
        $this->output->writeln('RESULTADOS');
        $this->output->writeln($this->sep1);
        $this->output->writeln('Nuevos docentes: ' . $reporte['nuevos_cant'] . ' / (Docentes que actualmente no existen en la base de datos)');
        //$this->output->writeln('Docentes que actualmente no existen en la base de datos.');

        if ($this->print) {
            $i = 1;
            foreach ($reporte['nuevos'] as $docente) {
                $this->output->writeln("#$i - " . $docente->__toString());
                $i++;
            }
        }


        $this->output->writeln($this->sep2);


        $this->output->writeln('Actualizados: ' . $reporte['actualizados_cant'] . ' / (Docentes cuyos datos fueron actualizados)');
        if ($this->print) {
            $i = 1;
            foreach ($reporte['actualizados'] as $docente) {
                $this->output->writeln("#$i - " . $docente->__toString());
                $i++;
            }
        }
        $this->output->writeln($this->sep2);

        $this->output->writeln('Inactivos: ' . $reporte['inactivos_cant'] . ' / (Docentes que serán dados de baja por no venir en el web service.)');

        if ($this->print) {
            $i = 1;
            foreach ($reporte['inactivos'] as $docente) {
                $this->output->writeln("#$i - " . $docente->__toString());
                $i++;
            }
        }
        $this->output->writeln($this->sep2);

        $this->output->writeln('');
    }

}
