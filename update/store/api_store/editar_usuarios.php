<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit(0);

require_once '../../config/db.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            echo json_encode(['success' => false, 'error' => 'ID de usuario requerido']);
            exit;
        }

        $id_usuario = intval($_GET['id']);

        $sql = "SELECT 
                    u.*,
                    u.id_rol,
                    r.nombre as nombre_rol,
                    l.nombre_local,
                    l.sector,
                    l.direccion as direccion_local,
                    l.telefono as telefono_local,
                    l.imagen_url as imagen_local,
                    l.id as id_local,
                    tl.nombre as tipo_local,
                    tl.id as id_tipo_local
                FROM usuarios u 
                INNER JOIN roles r ON u.id_rol = r.id 
                LEFT JOIN locales l ON l.id_usuario = u.id
                LEFT JOIN tipo_local tl ON l.id_tipo_local = tl.id
                WHERE u.id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Generar URL absoluta de la imagen para JS
            $usuario['imagen_local'] = (!empty($usuario['imagen_local']) && $usuario['imagen_local'] !== 'null')
                ? "/proyectoComida/" . $usuario['imagen_local']
                : null;

            // Remover la password del resultado por seguridad
            unset($usuario['password']);

            echo json_encode(['success' => true, 'data' => $usuario]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // CORREGIDO: Detectar si es FormData o JSON
        $content_type = $_SERVER['CONTENT_TYPE'] ?? '';
        
        if (strpos($content_type, 'multipart/form-data') !== false) {
            // Es FormData (con posible archivo)
            $input = $_POST;
            $archivo_imagen = $_FILES['imagen'] ?? null;
            error_log("Recibido como FormData");
            error_log("Archivo imagen: " . print_r($archivo_imagen, true));
        } else {
            // Es JSON
            $input = json_decode(file_get_contents('php://input'), true);
            $archivo_imagen = null;
            error_log("Recibido como JSON");
        }
        
        if (!$input) {
            echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
            exit;
        }

        // Debug: mostrar datos recibidos
        error_log("Datos recibidos: " . print_r($input, true));

        // Campos requeridos
        $campos_requeridos = ['id_usuario', 'nombre', 'apellido', 'email', 'direccion', 'telefono', 'id_rol'];
        foreach ($campos_requeridos as $campo) {
            if (!isset($input[$campo]) || trim($input[$campo]) === '') {
                echo json_encode(['success' => false, 'error' => "Campo requerido: $campo"]);
                exit;
            }
        }

        $id_usuario = intval($input['id_usuario']);
        $nombre = trim($input['nombre']);
        $apellido = trim($input['apellido']);
        $email = trim($input['email']);
        $direccion = trim($input['direccion']);
        $telefono = trim($input['telefono']);
        $id_rol = intval($input['id_rol']);

        // Obtener estado activo actual del usuario
        $stmt = $conn->prepare("SELECT activo FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $estado_actual = $stmt->fetchColumn();

        // Usar el valor que llega en JSON o mantener el existente
        $activo = isset($input['activo']) ? (bool)$input['activo'] : (bool)$estado_actual;

        // Campos opcionales para comerciantes
        $sector = isset($input['sector']) ? trim($input['sector']) : null; 
        $nombre_local = isset($input['nombre_local']) ? trim($input['nombre_local']) : '';
        $tipo_local_recibido = isset($input['tipo_local']) ? intval($input['tipo_local']) : 0;

        // Debug
        error_log("Tipo local recibido: " . $tipo_local_recibido);
        error_log("Nombre local: " . $nombre_local);
        error_log("Sector: " . $sector);

        // Validaciones
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'error' => 'Email inválido']);
            exit;
        }

        if (!preg_match('/^[0-9+\-\s]+$/', $telefono)) {
            echo json_encode(['success' => false, 'error' => 'Teléfono inválido']);
            exit;
        }

        // Verificar que el usuario existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        if (!$stmt->fetch()) {
            echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
            exit;
        }

        // Verificar que el email no esté en uso por otro usuario
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = :email AND id != :id");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'error' => 'El email ya está en uso por otro usuario']);
            exit;
        }

        $conn->beginTransaction();

        try {
            // Actualizar usuario
            $sql_usuario = "UPDATE usuarios SET 
                            nombre = :nombre,
                            apellido = :apellido,
                            email = :email,
                            direccion = :direccion,
                            telefono = :telefono,
                            id_rol = :id_rol,
                            activo = :activo
                            WHERE id = :id";

            $stmt = $conn->prepare($sql_usuario);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
            $stmt->bindParam(':activo', $activo, PDO::PARAM_BOOL);
            $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                throw new Exception('Error al actualizar usuario');
            }

            // CORREGIDO: Manejar subida de imagen si existe
            $nueva_imagen_url = null;
            if ($archivo_imagen && $archivo_imagen['error'] === UPLOAD_ERR_OK) {
                error_log("Procesando imagen subida");
                
                // Validar tipo de archivo
                $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($archivo_imagen['type'], $tipos_permitidos)) {
                    throw new Exception('Tipo de archivo no permitido. Use JPG, PNG, GIF o WebP');
                }

                // Validar tamaño (5MB máximo)
                if ($archivo_imagen['size'] > 5 * 1024 * 1024) {
                    throw new Exception('El archivo es demasiado grande. Máximo 5MB');
                }

                // Crear directorio si no existe
                $upload_dir = '../../uploads/locales/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                // Generar nombre único
                $extension = pathinfo($archivo_imagen['name'], PATHINFO_EXTENSION);
                $nombre_archivo = 'local_' . $id_usuario . '_' . time() . '.' . $extension;
                $ruta_completa = $upload_dir . $nombre_archivo;
                $ruta_relativa = 'uploads/locales/' . $nombre_archivo;

                // Mover archivo
                if (move_uploaded_file($archivo_imagen['tmp_name'], $ruta_completa)) {
                    $nueva_imagen_url = $ruta_relativa;
                    error_log("Imagen guardada en: " . $ruta_completa);
                    
                    // Eliminar imagen anterior si existe
                    $stmt = $conn->prepare("SELECT imagen_url FROM locales WHERE id_usuario = :id_usuario");
                    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                    $stmt->execute();
                    $imagen_anterior = $stmt->fetchColumn();
                    
                    if ($imagen_anterior && file_exists('../../' . $imagen_anterior)) {
                        unlink('../../' . $imagen_anterior);
                        error_log("Imagen anterior eliminada: " . $imagen_anterior);
                    }
                } else {
                    throw new Exception('Error al guardar la imagen');
                }
            }

            // Si es comerciante, manejar datos del local
            if ($id_rol === 3) {
                if (empty($nombre_local) || $tipo_local_recibido === 0) {
                     throw new Exception('Para comerciantes son requeridos: nombre del local y tipo de local');
                }

                // Verificar que el tipo de local existe
                $stmt = $conn->prepare("SELECT id FROM tipo_local WHERE id = :id_tipo_local");
                $stmt->bindParam(':id_tipo_local', $tipo_local_recibido, PDO::PARAM_INT);
                $stmt->execute();
                $tipo_local_existe = $stmt->fetchColumn();

                if (!$tipo_local_existe) {
                    throw new Exception('Tipo de local no encontrado: ID ' . $tipo_local_recibido);
                }

                // Verificar si ya existe un local para este usuario
                $stmt = $conn->prepare("SELECT id, imagen_url FROM locales WHERE id_usuario = :id_usuario");
                $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt->execute();
                $local_existente = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($local_existente) {
                    // Actualizar local existente
                    $sql_local = "UPDATE locales SET 
                                  nombre_local = :nombre_local,
                                  id_tipo_local = :id_tipo_local,
                                  direccion = :direccion,
                                  telefono = :telefono,
                                  sector = :sector";
                    
                    // Solo actualizar imagen si se subió una nueva
                    if ($nueva_imagen_url) {
                        $sql_local .= ", imagen_url = :imagen_url";
                    }
                    
                    $sql_local .= " WHERE id_usuario = :id_usuario";

                    $stmt = $conn->prepare($sql_local);
                    $stmt->bindParam(':nombre_local', $nombre_local);
                    $stmt->bindParam(':id_tipo_local', $tipo_local_recibido, PDO::PARAM_INT);
                    $stmt->bindParam(':direccion', $direccion);
                    $stmt->bindParam(':telefono', $telefono);
                    $stmt->bindParam(':sector', $sector);
                    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                    
                    if ($nueva_imagen_url) {
                        $stmt->bindParam(':imagen_url', $nueva_imagen_url);
                    }

                    if (!$stmt->execute()) {
                        throw new Exception('Error al actualizar local: ' . implode(", ", $stmt->errorInfo()));
                    }
                    error_log("Local actualizado correctamente");
                } else {
                    // Crear nuevo local
                    $imagen_para_insertar = $nueva_imagen_url ?: '';
                    
                    $sql_local = "INSERT INTO locales (id_usuario, id_tipo_local, nombre_local, direccion, telefono, sector, imagen_url) 
                                  VALUES (:id_usuario, :id_tipo_local, :nombre_local, :direccion, :telefono, :sector, :imagen_url)";

                    $stmt = $conn->prepare($sql_local);
                    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                    $stmt->bindParam(':id_tipo_local', $tipo_local_recibido, PDO::PARAM_INT);
                    $stmt->bindParam(':nombre_local', $nombre_local);
                    $stmt->bindParam(':direccion', $direccion);
                    $stmt->bindParam(':telefono', $telefono);
                    $stmt->bindParam(':sector', $sector);
                    $stmt->bindParam(':imagen_url', $imagen_para_insertar);

                    if (!$stmt->execute()) {
                        throw new Exception('Error al crear local: ' . implode(", ", $stmt->errorInfo()));
                    }
                    error_log("Local creado correctamente");
                }
            } else {
                // Si no es comerciante, eliminar local si existe
                $stmt = $conn->prepare("SELECT imagen_url FROM locales WHERE id_usuario = :id_usuario");
                $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt->execute();
                $imagen_a_eliminar = $stmt->fetchColumn();
                
                if ($imagen_a_eliminar && file_exists('../../' . $imagen_a_eliminar)) {
                    unlink('../../' . $imagen_a_eliminar);
                }
                
                $stmt = $conn->prepare("DELETE FROM locales WHERE id_usuario = :id_usuario");
                $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
                $stmt->execute();
            }

            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
        } catch (Exception $e) {
            $conn->rollBack();
            // Si hubo error y se subió una imagen nueva, eliminarla
            if ($nueva_imagen_url && file_exists('../../' . $nueva_imagen_url)) {
                unlink('../../' . $nueva_imagen_url);
            }
            error_log("Error en transacción: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // Endpoint para actualizar solo la contraseña
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            echo json_encode(['success' => false, 'error' => 'Datos JSON inválidos']);
            exit;
        }

        if (!isset($input['id_usuario']) || !isset($input['nueva_password'])) {
            echo json_encode(['success' => false, 'error' => 'ID de usuario y nueva contraseña requeridos']);
            exit;
        }

        $id_usuario = intval($input['id_usuario']);
        $nueva_password = trim($input['nueva_password']);

        if (strlen($nueva_password) < 6) {
            echo json_encode(['success' => false, 'error' => 'La contraseña debe tener al menos 6 caracteres']);
            exit;
        }

        // Verificar que el usuario existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        if (!$stmt->fetch()) {
            echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
            exit;
        }

        // Actualizar contraseña
        $password_hash = password_hash($nueva_password, PASSWORD_DEFAULT);

        $sql = "UPDATE usuarios SET password = :password WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Contraseña actualizada correctamente']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al actualizar contraseña']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    }
} catch (PDOException $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    error_log("Error PDO: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Error de base de datos: ' . $e->getMessage()]);
} catch (Exception $e) {
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    error_log("Error general: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Error del servidor: ' . $e->getMessage()]);
}
?>