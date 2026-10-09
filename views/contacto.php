<h2>Página de Contacto</h2>

<!-- El controlador inyecta esta variable aquí si existe un mensaje -->
<?php echo $mensaje_db; ?>

<form action="" method="POST">
    <label for="nombre">Tu Nombre: </label><br>
    <input type="text" id="nombre" name="nombre" required><br><br>
    <button type="submit">Enviar Mensaje</button>
</form>
