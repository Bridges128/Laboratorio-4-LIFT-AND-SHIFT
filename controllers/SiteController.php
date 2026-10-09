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
        $mensaje_db = "";

        // Procesar formulario si es la sección contacto y viene por POST
        if ($url === 'contacto' && $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
            $nombre_contacto = trim($_POST['nombre']);

            if (!empty($nombre_contacto)) {
                $modelo = new ContactoModel($this->conexion);
                $exito = $modelo->guardarContacto($nombre_contacto);

                if ($exito) {
                    $mensaje_db = "<p style='color: green; font-weight: bold;'>¡Mensaje guardado con éxito en la Base de Datos!</p>";
                } else {
                    $mensaje_db = "<p style='color: red;'>Error al guardar en la base de datos.</p>";
                }
            } else {
                $mensaje_db = "<p style='color: red;'>Por favor, escribe un nombre válido.</p>";
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
