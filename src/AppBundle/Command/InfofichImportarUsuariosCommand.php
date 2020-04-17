<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InfofichImportarUsuariosCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('infofich:importar-usuarios')
                ->setDescription('Importa los usuarios existentes en la tabla sistema_usuarios del infofich viejo.')
                ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
                ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        
        $output->writeln('Importando usuarios desde la base de datos actual de InfoFICH');

        $infofichViejoService = $this->getContainer()->get('infofich_viejo_service');
        $res = $infofichViejoService->importarUsuarios(true);

        if ($res === false) {
            $output->writeln($infofichViejoService->getUltimoError());
        } else {
 
            $output->writeln('Se importaron ' . $res['insetados_n'] . ' usuarios');
            $output->writeln('Se omitieron ' . $res['rechazados_n'] . ' usuarios,');
            $output->writeln('Usuarios omitidos:');
            
            dump($res['rechazados']);
                        
        }
    }

}
