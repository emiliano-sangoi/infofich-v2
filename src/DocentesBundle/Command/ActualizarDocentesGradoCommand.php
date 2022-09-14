<?php

namespace DocentesBundle\Command;

use DocentesBundle\Entity\AudDocenteGrado;
use DocentesBundle\Entity\LogActualizacionDocentesGrado;
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

    /**
     * @var string
     */
    private $logDir;

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
        $this->logDir = $this->getContainer()->getParameter('kernel.root_dir') . '/logs';
        $this->docenteService = $this->getContainer()->get('docentes_grado.docentes');

        $this->force = $input->getOption(self::OPT_FORCE);
        $this->print = $input->getOption(self::OPT_PRINT);

        if ($this->force) {
            $this->output->writeln('Impactando cambios en la base de datos ...');
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
        }

        $reporte = $this->docenteService->getReporte();
        $log = $this->imprimirReporte($reporte);

        //Guardar un registro en el log
        if ($this->force) {
            $audDG = new LogActualizacionDocentesGrado();
            $audDG->setCantNuevos($reporte['nuevos_cant']);
            $audDG->setCantActualizados($reporte['actualizados_cant']);
            $audDG->setCantDesactivados($reporte['inactivos_cant']);
            $audDG->setLogTxt($log);
            $this->em->persist($audDG);
            $this->em->flush();
        }

    }

    private function imprimirReporte($reporte) {

        $log = $this->sep1 . "\n" . 'RESULTADOS' . "\n" . $this->sep1 . "\n";
        $aux = 'Nuevos docentes: ' . $reporte['nuevos_cant'] . ' / (Docentes que actualmente no existen en la base de datos)';
        $log .= $aux . "\n";

        if ($this->print) {
            $i = 1;
            foreach ($reporte['nuevos'] as $docente) {
                $linea = "#$i - " . $docente->__toString();
                $log .= $linea. "\n";
                $i++;
            }
        }

        $log .= $this->sep2 . "\n";

        $aux = 'Actualizados: ' . $reporte['actualizados_cant'] . ' / (Docentes cuyos datos fueron actualizados)';
        $log .= $aux . "\n";

        if ($this->print) {
            $i = 1;
            foreach ($reporte['actualizados'] as $docente) {
                $linea = "#$i - " . $docente->__toString();
                $log .= $linea. "\n";
                $i++;
            }
        }

        $log .= $this->sep2 . "\n";

        $aux = 'Inactivos: ' . $reporte['inactivos_cant'] . ' / (Docentes que serán dados de baja por no venir en el web service.)';
        $log .= $aux . "\n";

        if ($this->print) {
            $i = 1;
            foreach ($reporte['inactivos'] as $docente) {
                $linea = "#$i - " . $docente->__toString();
                $log .= $linea. "\n";
                $i++;
            }
        }

        $log .= $this->sep2 . "\n\n";

        $this->output->write($log);

        //Guardar log en un archivo
        if(!file_exists($this->logDir) || !is_writable($this->logDir)){
            $this->output->writeln('No se pudo guardar el log porque el directorio ' . $this->logDir . ' no existe o no posee permisos de escritura.');
        }else{
            $log_path = $this->logDir . '/' . date('Ymd_Hi') . '_log_actualizar_docentes.txt';
            file_put_contents($log_path, $log);
            $this->output->writeln('Log guardado en ' . $log_path);
        }

        $this->output->writeln('');

        return $log;
    }

}
