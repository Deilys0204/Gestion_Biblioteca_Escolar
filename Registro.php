<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educabiblio</title>
    <link rel="stylesheet" href="Registro.css">
</head>
<body>
    <div class="container">
        <div class="lado-izquierdo"> 
            <div class="title">EDUCABIBLIO</div>
            <img src="img/Imagen.png" alt="">
        </div>
        <div class="lado-derecho"> 
            <div class="form-container">
                <div class="header">
                <img src="img/logo.png" alt="Logo" class="logo">
                </div>
                <h2>Regístrate</h2>
                <!-- Formulario de registro -->
                <form method="POST" action="Registro.php">
                    <div class="form-group">
                        <label for="nombre">Nombre Completo</label>
                        <input type="text" id="nombre" name="nombre">
                    </div>
                    <div class="form-group">
                        <label for="tipo-documento">Tipo de Documento</label>
                        <input type="text" id="tipo-documento" name="tipo-documento">
                    </div>
                    <div class="form-group">
                        <label for="numero-documento">Número de Documento</label>
                        <input type="text" id="numero-documento" name="numero-documento">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password">
                    </div>
                    <button type="submit">Regístrate</button>
                </form>
                <p class="login-link">¿Ya tienes una cuenta? <a href="#">Inicia sesión</a></p>
            </div>
        </div>
    </div>
</body>
</html>