<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "EducaBiblio"; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Encabezado con Menú de Navegación -->
    <header class="header">
        <div class="logo">
            <!-- Imagen del logotipo -->
            <img src="img/logo.png" alt="Institución Educativa La Merced" class="logo-image">
        </div>
        <nav class="menu">
            <ul>
                <li><a href="#inicio">INICIO</a></li>
                <li><a href="#caracteristicas">CARACTERÍSTICAS</a></li>
                <li><a href="#contacto">CONTACTO</a></li>
                <li><a href="#" class="btn-unique">REGISTRARSE</a></li>
            </ul>
        </nav>
    </header>

    <!-- Sección Principal de Información -->
    <section class="main-info" id="inicio">
        <div class="info-container">
            <!-- Columna Izquierda: Texto y Botón -->
            <div class="text-section">
                <div class="titulo-container">
                    <h1 class="titulo"><?php echo "EDUCABIBLIO"; ?></h1>
                </div>
                <p><?php echo "Tu sistema de gestión de biblioteca escolar es fundamental para organizar y mantener en orden todos los recursos educativos disponibles para los estudiantes y docentes. Con un sistema eficiente, podrás clasificar los libros, revistas, material audiovisual y demás elementos de manera sencilla y accesible para todos. Además, te permitirá llevar un registro detallado de los préstamos realizados, facilitando así el control de la disponibilidad de cada recurso. ¡No subestimes la importancia de una buena gestión bibliotecaria en el proceso educativo!"; ?></p>
                <button class="btn-ingresar"><?php echo "INGRESAR"; ?></button>
            </div>
            
            <!-- Columna Derecha: Imagen Circular -->
            <div class="image-section">
                <img src="img/foto_index.png" alt="Imagen Circular" class="circular-image">
            </div>
        </div>
    </section>

    <!-- Sección de Título de Características -->
    <section class="features-title" id="caracteristicas">
        <h1 class="titulo"><?php echo "CARACTERÍSTICAS"; ?></h1>
    </section>

    <!-- Sección de Detalles de Características -->
    <section class="features">
        <?php
        // Aquí puedes usar PHP para cargar características desde una base de datos o archivo.
        $caracteristicas = [
            ["img" => "ubicacion.png", "titulo" => "Usa la página en cualquier lugar", "descripcion" => "Esta herramienta versátil y fácil de usar se adapta a tus necesidades en cualquier lugar, con acceso desde cualquier dispositivo para mayor comodidad."],
            ["img" => "sincronizacion.png", "titulo" => "Sincroniza tus datos con tu cuenta", "descripcion" => "Tu historial se sincroniza automáticamente con tu cuenta institucional para un acceso flexible y cómodo en cualquier dispositivo, optimizando la productividad."],
            ["img" => "disponibilidad.png", "titulo" => "Disponible 24/7", "descripcion" => "La página web permite consultar el catálogo, reservar libros y acceder a recursos digitales, fomentando la lectura y el aprendizaje en la comunidad escolar."],
            ["img" => "red.png", "titulo" => "Comparte los datos con tus compañeros", "descripcion" => "Comparte tus libros favoritos para inspirar a otros a leer y disfrutar juntos del mundo literario."]
        ];
        ?>
    </section>

    <!-- Sección de Título de Contacto -->
    <section class="contact-title" id="contacto">
        <h1 class="title"><?php echo "CONTACTO"; ?></h1>
    </section>
    <p class="mensaje"><?php echo "Descubre nuestra ubicación, horarios de atención y datos de contacto para realizar tus solicitudes y trámites. Contáctanos para informarte sobre las diversas secciones de la Biblioteca de la Institución Educativa La Merced y cómo acceder a material didáctico, autores o temas de forma presencial."; ?></p>

    <!-- Sección de Información de Contacto con Mapa -->
    <section class="contact">
        <div class="contact-container">
            <!-- Información de Contacto -->
            <div class="contact-info">
                <?php
                // Datos de contacto, que también puedes obtener dinámicamente.
                $biblioteca = "Biblioteca de la Institución Educativa La Merced";
                $direccion = "Km 1 Vía Garzón, El Agrado, Huila.";
                $codigopostal = "414047";
                $horario = "Lunes a viernes: 8:00 a. m. a 4:00 p. m."; 
                $telefono = "(+57 312) 4778545";
                $correo = "XXXXXXXX@XXXXXXXX.gov.co";

                echo "<p><strong>$biblioteca</strong><br>$direccion</p>";
                echo "<p><strong>Código Postal:</strong> $codigopostal</p>";
                echo "<p><strong>Horario de atención:</strong> $horario</p>";
                echo "<p><strong>Teléfono:</strong> $telefono</p>";
                echo "<p><strong>Correo institucional:</strong> $correo</p>";
                ?>
            </div>

            <!-- Mapa de Google Maps -->
            <div class="contact-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.4959064202695!2d-74.08175318557873!3d4.609710643098556!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f99e9b2c65b29%3A0x7f912c0412e80cae!2sBogotá%2C%20Colombia!5e0!3m2!1ses!2sco!4v1616702747864!5m2!1ses!2sco" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <!-- Pie de Página -->
    <footer class="footer">
        <p><?php echo "© EducaBiblio. All Rights Reserved 2024 | <a href='#'>Terms & Conditions</a>"; ?></p>
    </footer>
</body>
</html>
