<section class="page-intro">
    <p class="eyebrow">Hablemos</p>
    <h2>Contacto</h2>
    <p>Déjame un mensaje. Tus datos se guardan en MySQL.</p>
</section>

<?php if ($mensaje_db !== null): ?>
    <p class="alerta alerta--<?= htmlspecialchars($mensaje_db['tipo'], ENT_QUOTES, 'UTF-8') ?>" role="status">
        <?= htmlspecialchars($mensaje_db['texto'], ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<form class="formulario" action="" method="POST">
    <label for="nombre">Tu nombre</label>
    <input type="text" id="nombre" name="nombre" maxlength="100" autocomplete="name" required>

    <label for="correo">Tu correo</label>
    <input type="email" id="correo" name="correo" maxlength="254" autocomplete="email" required>

    <label for="comentario">Comentario</label>
    <textarea id="comentario" name="comentario" rows="6" required></textarea>

    <button class="boton" type="submit">Enviar mensaje</button>
</form>
