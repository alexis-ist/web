<?php
require_once '../config/db.php';

// Incluir la configuración de la base de datos
session_start();

// Variables para almacenar errores
$email_error = '';
$local_error = '';
$show_register_form = false;

// INICIO DE SESIÓN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $contrasena = $_POST['contrasena'];

    try {
        $sql = "SELECT * FROM usuarios WHERE email = ? AND activo = 1 LIMIT 1";
        $stmt = ejecutarConsulta($sql, [$email]);
        $usuarioData = $stmt->fetch();

        if (!$usuarioData) {
            $emailLogin_error = "Usuario no encontrado o inactivo";
        } elseif (!password_verify($contrasena, $usuarioData['password'])) {
            $clave_error = "Contraseña incorrecta. Intente denuevo";
        } else {
            // Autenticación exitosa
            $_SESSION['email'] = $usuarioData['email'];
            $_SESSION['nombre'] = $usuarioData['nombre'];
            $_SESSION['id_rol'] = $usuarioData['id_rol'];
            $_SESSION['id'] = $usuarioData['id'];


            echo "<script>window.top.location.href='pageStore/store.php';</script>";
            exit;
        }
    } catch (Exception $e) {
        echo "<script>alert('Error al iniciar sesión: " . $e->getMessage() . "');</script>";
    }
}

// REGISTRO DE USUARIO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $show_register_form = true;

    $nombre     = trim($_POST['nombre']);
    $apellido   = trim($_POST['apellido']);
    $email      = trim($_POST['email']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $direccion  = trim($_POST['direccion']);
    $telefono   = trim($_POST['telefono']);
    $id_rol     = $_POST['id_rol'];
    

    try {
        // 1. Verificar si el email ya existe
        $sqlCheckEmail = "SELECT id FROM usuarios WHERE email = ?";
        $stmtCheckEmail = ejecutarConsulta($sqlCheckEmail, [$email]);
        $existingUser = $stmtCheckEmail->fetch();
        if ($existingUser) {
            $email_error = "Este correo ya está registrado";
        }

        // 2. Si es comerciante, verificar si el nombre del local ya existe
        

        // 3. Solo insertar si NO HAY errores
        if (empty($email_error) && empty($telefono_error)) {
            // Registrar usuario
            $sql = "INSERT INTO usuarios (id_rol,nombre, apellido, email, password, direccion, telefono,activo) 
                    VALUES (?, ?, ?, ?, ?, ?, ?,1)";
            ejecutarConsulta($sql, [$id_rol, $nombre, $apellido, $email, $contrasena, $direccion, $telefono]);

            $sqlLastId = "SELECT LAST_INSERT_ID() as id";
            $stmt = ejecutarConsulta($sqlLastId, []);
            $newUser = $stmt->fetch();
            $id_usuario = $newUser['id'];
            
            echo "<script>alert('¡Tu registro fue exitoso! Ingresa y descubre nuestras ofertas.');</script>";
            // Limpiar variables después del éxito
            $email_error = '';
            $telefono_error = '';
            $show_register_form = false;
        }

    } catch (Exception $e) {
        echo "<script>alert('Error al registrar: " . $e->getMessage() . "');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticación</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="container <?php echo $show_register_form ? 'active' : ''; ?>">

        <!-- Formulario de Login -->
        <div class="form-container">
            <form class="form login-form" action="" method="POST">
                <input type="hidden" name="login" value="1">
                <h2 class="titulo">Iniciar Sesión</h2>
                <div class="social-networks">
                    <a href="https://www.facebook.com/profile.php?id=61581635670315" title="Facebook" target="_blank"><ion-icon name="logo-facebook"></ion-icon></a>
                    <ion-icon name="logo-tiktok"></ion-icon>
                    <a href="https://wa.me/593983412281?text=Hola%2C%20quiero%20ordenar%20comida" title="WhatsApp" target="_blank"><ion-icon name="logo-whatsapp"></ion-icon></a>
                </div>
                <div class="input-group <?php echo !empty($emailLogin_error) ? 'emailLogin-error' : ''; ?>">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="email" name="email" placeholder="E-mail" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    <?php if (!empty($emailLogin_error)): ?>
                        <small class="error-message email"><?php echo $emailLogin_error; ?></small>
                    <?php endif; ?>
                </div>
                <div class="input-group <?php echo !empty($clave_error) ? 'has-error' : ''; ?>">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="contrasena" placeholder="Password" required>
                    <?php if (!empty($clave_error)): ?>
                        <small class="error-message clave"><?php echo $clave_error; ?></small>
                    <?php endif; ?>
                </div>

                <div class="form-button">
                    <button class="btn-iniciar" type="submit">Entrar y Comprar</button>
                </div>
            </form>
        </div>

        <!-- Formulario de Registro -->
        <div class="form-container">
            <form class="form register-form" action="" method="POST" enctype="multipart/form-data">
                <h2 class="title_resgister">Crea tu cuenta</h2>
                <input type="hidden" name="register" value="1">
                <div class="social-networks icon">
                    <a href="https://www.facebook.com/profile.php?id=61581635670315" title="Facebook" target="_blank"><ion-icon name="logo-facebook"></ion-icon></a>
                    <ion-icon name="logo-tiktok"></ion-icon>
                    <a href="https://wa.me/593983412281?text=Hola%2C%20quiero%20ordenar%20comida" title="WhatsApp" target="_blank"><ion-icon name="logo-whatsapp"></ion-icon></a>
                </div>

                <input type="hidden" name="id_rol" value="4">


                <div class="input-group nombre">
                    <ion-icon name="person-outline"></ion-icon>
                    <input type="text" name="nombre" placeholder="Nombre"
                        value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" required>
                </div>

                <div class="input-group apellido">
                    <ion-icon name="person-outline"></ion-icon>
                    <input type="text" name="apellido" placeholder="Apellido"
                        value="<?php echo isset($_POST['apellido']) ? htmlspecialchars($_POST['apellido']) : ''; ?>" required>
                </div>

                <div class="input-group email <?php echo !empty($email_error) ? 'has-error' : ''; ?>">
                    <ion-icon name="mail-outline"></ion-icon>
                    <input type="email" name="email" placeholder="E-mail"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                    <?php if (!empty($email_error)): ?>
                        <small class="error-message email"><?php echo $email_error; ?></small>
                    <?php endif; ?>
                </div>

                <div class="input-group clave">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password" name="contrasena" placeholder="Password" required>
                </div>

                <div class="input-group direccion">
                    <ion-icon name="location-outline"></ion-icon>
                    <input type="text" name="direccion" placeholder="Dirección"
                        value="<?php echo isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : ''; ?>" required>
                </div>

                <div class="input-group telefono">
                    <ion-icon name="call-outline"></ion-icon>
                    <input type="text" name="telefono" id="telefono" placeholder="Teléfono (10 dígitos)"
                        value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>" maxlength="10" required>
                    <small class="error-telefono"></small>
                </div>
                

                <div class="form-button btnregistarr">
                    <button class="btn-guardar" type="submit">Crear Cuenta</button>
                </div>
            </form>
        </div>

        <div class="container-welcome">
            <div class="welcome-register welcome">
                <h2>¿Eres nuevo?</h2>
                <p>Regístrate gratis y empieza a comprar en minutos.</p>
                <button class="btn-guardar" id="btn-register">Quiero registrarme</button>
            </div>

            <div class="welcome-login welcome">
                <h2>¿Ya tienes cuenta?</h2>
                <p>Accede a tu perfil y disfruta de todas las ofertas disponibles.</p>
                <button class="btn-iniciar" id="btn-iniciar">Entrar a mi cuenta</button>
            </div>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../js/login.js"></script>
</body>

</html>