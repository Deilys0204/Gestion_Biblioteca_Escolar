<?php
require_once '../config/registrobd.php'; // Incluir el archivo de base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="shortcut icon" href="../img/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/registro.css">
</head>
<body>
    <!-- Contenedor principal con altura ajustada -->
    <div class="container-fluid d-flex justify-content-center align-items-center"> 
        <div class="row bg-white shadow rounded overflow-hidden">
            <!-- Lado izquierdo: imagen y título -->
            <div class="col-md-6 d-none d-md-flex flex-column bg-white p-0">
                <div class="title-container">
                    <h1 class="bungee-text">EDUCABIBLIO</h1>
                </div>
                <img src="../img/imagen.png" class="img-fluid" alt="Imagen decorativa">
            </div>
            
            <!-- Lado derecho: formulario de registro -->
            <div class="col-md-6 p-4">
                <div class="text-center mb-4">
                    <h1 class="registrate">Regístrate</h1>
                    <img src="../img/logo.png" alt="Logo" class="logo-institucion">
                </div>

                <!-- Mostrar errores si los hay -->
                <?php if (!empty($errores)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errores as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                 <!-- Mostrar mensaje de éxito si existe -->
                <?php
                if (isset($_SESSION['exito'])):
                ?>
                    <div class="alert alert-success">
                         <?php echo $_SESSION['exito']; ?>
                    </div>
                    <?php unset($_SESSION['exito']); // Borrar el mensaje después de mostrarlo ?>
                <?php endif; ?>

                <!-- Formulario de registro -->
                <form method="POST" action="">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="primer-nombre" class="form-label">Primer Nombre *</label>
                            <input type="text" class="form-control" id="primer-nombre" name="primer-nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label for="segundo-nombre" class="form-label">Segundo Nombre</label>
                            <input type="text" class="form-control" id="segundo-nombre" name="segundo-nombre">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="primer-apellido" class="form-label">Primer Apellido *</label>
                            <input type="text" class="form-control" id="primer-apellido" name="primer-apellido" required>
                        </div>
                        <div class="col-md-6">
                            <label for="segundo-apellido" class="form-label">Segundo Apellido</label>
                            <input type="text" class="form-control" id="segundo-apellido" name="segundo-apellido">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tipo-documento" class="form-label">Tipo de Documento *</label>
                        <select class="form-select" id="tipo-documento" name="tipo-documento" required>
                            <option value="" disabled selected>Seleccione</option>
                            <?php foreach ($tipos_documento as $tipo): ?>
                                <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="numero-documento" class="form-label">Número de Documento *</label>
                        <input type="text" class="form-control" id="numero-documento" name="numero-documento" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail *</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="ejemplo@gmail.com">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña *</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="**********">
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-50">Regístrarse</button>
                    </div>

                    <div class="mt-4 text-center">
                        <p>¿Ya tienes una cuenta? <a href="../php/login.php" class="text-primary fw-bold">Inicia sesión</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
