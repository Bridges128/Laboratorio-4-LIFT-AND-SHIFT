<?php
// index.php

require_once 'conexion.php'; // Tu archivo de conexión existente
require_once 'controllers/SiteController.php';

// Instanciamos el controlador pasándole la conexión
$controlador = new SiteController($conexion);

// Ejecutamos la lógica de la aplicación
$controlador->manejarPeticion();
