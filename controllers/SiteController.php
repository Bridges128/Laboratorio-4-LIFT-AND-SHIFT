<?php
// controllers/SiteController.php
require_once 'models/ContactoModel.php';

class SiteController {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function manejarPeticion() {
        // Capturar sección actual
        $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'inicio';
        $mensaje_db = null;

        if ($url === 'contacto' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_contacto = trim($_POST['nombre'] ?? '');
            $correo_contacto = trim($_POST['correo'] ?? '');
            $comentario_contacto = trim($_POST['comentario'] ?? '');

            if ($nombre_contacto === '' || $correo_contacto === '' || $comentario_contacto === '') {
                $mensaje_db = [
                    'tipo' => 'error',
                    'texto' => 'Completa todos los campos para enviar tu mensaje.',
                ];
            } elseif (!filter_var($correo_contacto, FILTER_VALIDATE_EMAIL)) {
                $mensaje_db = [
                    'tipo' => 'error',
                    'texto' => 'Escribe una dirección de correo válida.',
                ];
            } else {
                $modelo = new ContactoModel($this->conexion);
                $exito = $modelo->guardarContacto(
                    $nombre_contacto,
                    $correo_contacto,
                    $comentario_contacto
                );

                if ($exito) {
                    $mensaje_db = [
                        'tipo' => 'exito',
                        'texto' => '¡Gracias! Tu mensaje quedó guardado en la base de datos.',
                    ];
                } else {
                    $mensaje_db = [
                        'tipo' => 'error',
                        'texto' => 'No se pudo guardar el mensaje. Inténtalo de nuevo.',
                    ];
                }
            }
        }

        // Cargar los componentes visuales (Vistas)
        require_once 'views/header.php';

        switch ($url) {
            case 'inicio':
                require_once 'views/inicio.php';
                break;
            case 'servicios':
                require_once 'views/servicios.php';
                break;
            case 'gustos':
                require_once 'views/gustos.php';
                break;
            case 'contacto':
                require_once 'views/contacto.php';
                break;
            default:
                require_once 'views/404.php';
                break;
        }

        require_once 'views/footer.php';
    }
}
