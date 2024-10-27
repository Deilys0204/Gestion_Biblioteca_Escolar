<!-- 
     PROYECTO PRACTICA PROFESIONAL
     Dev: Deily Catherine Soto Rodríguez
     Universidad Surcolombiana
-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "EducaBiblio"; ?></title>
    <link rel="shortcut icon" href="img/icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Encabezado con Menú de Navegación -->
<header class="header py-3 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Imagen del logotipo -->
        <a href="#" class="navbar-brand">
            <img src="img/logo.png" alt="<?php echo $biblioteca; ?>" class="logo-image">
        </a>

        <!-- Menú de Navegación -->
        <nav class="menu">
            <ul class="nav">
                <li class="nav-item">
                    <a href="#inicio" class="nav-link">INICIO</a>
                </li>
                <li class="nav-item">
                    <a href="#caracteristicas" class="nav-link">CARACTERÍSTICAS</a>
                </li>
                <li class="nav-item">
                    <a href="#contacto" class="nav-link">CONTACTO</a>
                </li>
                <li class="nav-item">
                    <a href="php/Registro.php" class="btn btn-primary btn-unique">REGISTRARSE</a>
                </li>
            </ul>
        </nav>
    </div>
</header>

    <!-- Sección Principal de Información -->
<section class="main-info py-3" id="inicio">
    <div class="container">
        <div class="row align-items-center">
            <!-- Columna Izquierda: Texto y Botón -->
            <div class="col-md-6 text-section">
                <div class="titulo-container text-center mb-4">
                    <h1 class="titulo">EDUCABIBLIO</h1>
                </div>
                <p>Tu sistema de gestión de biblioteca escolar es fundamental para organizar y mantener en orden todos los recursos educativos disponibles para los estudiantes y docentes. Con un sistema eficiente, podrás clasificar los libros, revistas, material audiovisual y demás elementos de manera sencilla y accesible para todos. Además, te permitirá llevar un registro detallado de los préstamos realizados, facilitando así el control de la disponibilidad de cada recurso. <br><br> ¡No subestimes la importancia de una buena gestión bibliotecaria en el proceso educativo!</p>
                <button class="btn btn-primary btn-ingresar" onclick="window.location.href='php/login.php';">INGRESAR</button>
            </div>
            
            <!-- Columna Derecha: Imagen Circular -->
            <div class="col-md-6 text-center">
                <img src="img/foto_index.png" alt="Imagen Circular" class="img-fluid rounded-circle circular-image">
            </div>
        </div>
    </div>
</section>

<!-- Sección de Título de Características -->
<section class="features-title py-3" id="caracteristicas">
    <div class="container">
        <h1 class="titulo text-center">CARACTERÍSTICAS</h1>
    </div>
</section>

<!-- Sección de Detalles de Características -->
<section class="features py-5">
    <div class="container">
        <div class="row text-center">
            <!-- Tarjeta 1 -->
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="img/ubicacion.png" alt="Ubicación Icono" class="mb-3">
                        <h3 class="card-title">Usa la página en cualquier lugar</h3>
                        <p class="card-text">Esta herramienta versátil y fácil de usar se adapta a tus necesidades en cualquier lugar, con acceso desde cualquier dispositivo para mayor comodidad.</p>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 2 -->
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="img/sincronizacion.png" alt="Sincronización Icono" class="mb-3">
                        <h3 class="card-title">Sincroniza tus datos con tu cuenta</h3>
                        <p class="card-text">Tu historial se sincroniza automáticamente con tu cuenta institucional para un acceso flexible y cómodo en cualquier dispositivo, optimizando la productividad.</p>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 3 -->
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="img/disponibilidad.png" alt="Disponible 24/7" class="mb-3">
                        <h3 class="card-title">Disponible 24/7</h3>
                        <p class="card-text">La página web permite consultar el catálogo, reservar libros y acceder a recursos digitales, fomentando la lectura y el aprendizaje en la comunidad escolar.</p>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 4 -->
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="img/red.png" alt="Compartir Icono" class="mb-3">
                        <h3 class="card-title">Comparte los datos con tus compañeros</h3>
                        <p class="card-text">Comparte tus libros favoritos para inspirar a otros a leer y disfrutar juntos del mundo literario.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Sección de Título de Contacto -->
<section class="contact-title py-3" id="contacto">
    <div class="container">
        <h1 class="title text-center">CONTACTO</h1>
    </div>
</section>

<!-- Mensaje Justificado -->
<div class="container">
    <p class="mensaje text-justify">Descubre nuestra ubicación, horarios de atención y datos de contacto para realizar tus solicitudes y trámites. 
    Contáctanos para informarte sobre las diversas secciones de la Biblioteca de la Institución Educativa La Merced y cómo acceder a material didáctico, autores o temas de forma presencial.</p>
</div>

<?php
    // Datos dinámicos que podrías cargar desde una base de datos
    $biblioteca = "Biblioteca de la Institución Educativa La Merced";
    $direccion = "Km 1 Vía Garzón, El Agrado, Huila";
    $codigopostal = "414047";
    $horario = "Lunes a viernes: 8:00 a. m. a 4:00 p. m.";
    $telefono = "(+57) 3124778545";
    $correo = "biblioteca@lamerced.edu.co";
?>

<!-- Sección de Información de Contacto con Mapa -->
<section class="contact py-5">
    <div class="container">
        <div class="row">
            <!-- Columna Izquierda: Información de Contacto -->
            <div class="col-md-6 contact-info">
                <p><strong><?php echo $biblioteca; ?></strong><br>
                <?php echo $direccion; ?> <br>
                Código postal: <?php echo $codigopostal; ?>.</p>
                <p><strong>Horario de atención</strong><br><?php echo $horario; ?></p>
                <p><strong>Teléfono</strong><br><?php echo $telefono; ?></p>
                <p><strong>Correo institucional</strong><br><?php echo $correo; ?></p>
                <p>Se permite el ingreso hasta 30 minutos antes del cierre</p>
            </div>

            <!-- Columna Derecha: Mapa de Google Maps -->
            <div class="col-md-6 contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.7254288405584!2d-75.77119861517558!3d2.2561681918554366!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e2528f6ab49071b%3A0x9347b7b5369fbe03!2sInstituci%C3%B3n%20Educativa%20La%20Merced!5e0!3m2!1ses!2sco!4v1729719727005!5m2!1ses!2sco" width="600" height="310" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>
    
<!-- Inicio del footer -->
<footer class="footer pt-5" id="tempaltemo_footer">
    <div class="container">
        <div class="row justify-content-between text-center text-md-start">
            <!-- Columna 1: Información de contacto y suscripción -->
            <div class="col-md-4 footer-column mb-4 text-center">
                <h2 class="h2 pb-3 border-dark logo">
                    <img src="img/logofooter.png" alt="<?php echo $biblioteca; ?>" class="logofooter">&nbsp;EDUCABIBLIO
                </h2>
                <ul class="list-unstyled footer-link-list mb-4 text-center">
                    <li>
                        <i class="fas fa-map-marker-alt fa-fw"></i>
                        <?php echo $direccion; ?>
                    </li>
                    <li>
                        <i class="fa fa-phone fa-fw"></i>
                        <a class="text-decoration-none" href="tel:<?php echo $telefono; ?>"><?php echo $telefono; ?></a>
                    </li>
                </ul>
                <h6><strong>Suscríbete a nuestro boletín</strong></h6>
                <div class="input-group mb-2">
                    <input type="email" class="form-control border-darj" id="subscribeEmail" placeholder="Email address">
                    <button class="input-group-text btn-success text-light">Suscribirse</button>
                </div>
            </div>

            <!-- Columna 2: Menú rápido -->
            <div class="col-md-4 footer-column mb-4">
                <h3 class="h3 border-bottom pb-3 border-dark text-center logo">Menú Rápido</h3>
                <ul class="list-unstyled footer-link-list text-center">
                    <li><a class="text-decoration-none" href="#inicio">Inicio</a></li>
                    <li><a class="text-decoration-none" href="#caracterisitcas">Características</a></li>
                    <li><a class="text-decoration-none" href="#contacto">Contacto</a></li>
                    <li><a class="text-decoration-none" href="php/Registro.php">Registrarse</a></li>
                    <li><a class="text-decoration-none" href="php/login.php">Ingresar</a></li>
                </ul>
            </div>

            <!-- Columna 3: Redes sociales -->
            <div class="col-md-4 footer-column mb-4">
                <h2 class="h2 border-bottom pb-3 border-dark text-center logo">Síguenos</h2>
                <p>Encuéntranos en nuestras redes sociales para recibir las últimas actualizaciones y noticias.</p>
                <ul class="list-unstyled footer-icons text-center">
                    <li class="d-inline-block">
                        <a href="https://www.facebook.com/lamerced.institucioneducativa" class="text-decoration-none">
                            <i class="fab fa-facebook fa-2x"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="w-100 py-3 mt-4">
        <div class="container-fluid">
            <div class="row pt-2">
                <div class="col-12 text-center">
                    <p class="text-dark mb-0">
                        &copy; 2024 EducaBiblio. All Rights Reserved
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</html>
