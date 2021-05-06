<?php

namespace AppBundle\Command;

use AppBundle\Entity\Persona;
use AppBundle\Entity\Rol;
use AppBundle\Entity\Usuario;
use FICH\APIRectorado\Config\WSHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InfofichImportarUsuariosCommand extends ContainerAwareCommand {

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

    const DEFAULT_PWD = '12345678';
    const OP_1 = 'crear-usuarios-prueba';

    protected function configure() {
        
        $op1_msg = 'Crea los usuarios de prueba definidos en getUsuariosPrueba() de la clase ' . self::class;
        
        $this
                ->setName('infofich:importar-usuarios')
                ->setDescription('Importa los usuarios existentes en la tabla sistema_usuarios del infofich viejo.')
        //   ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption(self::OP_1, 'p', InputOption::VALUE_NONE, $op1_msg)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $this->input = $input;
        $this->output = $output;
        
        $this->output->writeln('Importando usuarios desde la base de datos actual de InfoFICH');

        $infofichViejoService = $this->getContainer()->get('infofich_viejo_service');
        $res = $infofichViejoService->importarUsuarios(true);

        if ($res === false) {
            $this->output->writeln($infofichViejoService->getUltimoError());
        } else {

            $this->output->writeln('Se importaron ' . $res['insetados_n'] . ' usuarios');
            $this->output->writeln('Se omitieron ' . $res['rechazados_n'] . ' usuarios,');
            $this->output->writeln('Usuarios omitidos:');

            dump($res['rechazados']);
        }

        $crear_usuarios_prueba = $this->input->hasOption(self::OP_1) 
                ? $this->input->getOption(self::OP_1) : false;
        
        if ($crear_usuarios_prueba) {
            $this->crearUsuariosPrueba();
        }
    }

    private function crearUsuariosPrueba() {
        $this->output->writeln('');
        $this->output->writeln('Creando usuarios de prueba ...');
        
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $repoPersona = $em->getRepository(Persona::class);
        $repoRoles = $em->getRepository(Rol::class);

        $usuarios = $this->getUsuariosPrueba();

        $i = 1;
        foreach ($usuarios as $u_data) {

            $u = new Usuario();
            $u->setUsername($u_data['username']);

            //Contraseña:
            $plain_pwd = self::DEFAULT_PWD;
            $password = password_hash($plain_pwd, PASSWORD_BCRYPT);
            $u->setPassword($password);

            //Persona asociada:
            $u->setPersona($u_data['persona']);

            //Roles:
            foreach ($u_data['roles'] as $r_nom) {
                $rol = $repoRoles->findOneByNombre($r_nom);
                $u->addRole($rol);
            }

            $em->persist($u);

            $this->output->writeln('#' . $i . ' - ' . $u);
            $i++;
        }

        if ($i > 1) {
            $em->flush();
        }
    }

    private function getUsuariosPrueba() {
        $usuarios = array();
        
        $persona = new Persona();
        $persona->setApellidos('Perez');
        $persona->setNombres('Juan Jose');
        $persona->setDocumento(1111111111);
        $persona->setTipoDocumento(WSHelper::TIPO_DOC_DNI);
        $persona->setEmail('jjperez@mail.com');

        $u1 = array(
            'username' => 'docente_grado',
            'persona' => $persona,
            'roles' => array(
                Rol::ROLE_DOCENTE_GRADO
            ),
        );
       
        $usuarios[] = $u1;

        return $usuarios;
    }

}
