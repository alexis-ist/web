document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const id = params.get("id");
    const preview = document.getElementById("preview");

    if (id) {
        fetch(`../api_store/editar_usuarios.php?id=${id}`)
            .then(res => res.json())
            .then(data => {
                console.log("Respuesta del servidor:", data);
                if (data.success) {
                    const usuario = data.data;
                    document.getElementById("id_usuario").value = usuario.id;
                    document.getElementById("nombre").value = usuario.nombre;
                    document.getElementById("apellido").value = usuario.apellido || '';
                    document.getElementById("email").value = usuario.email;
                    document.getElementById("direccion").value = usuario.direccion || '';
                    document.getElementById("telefono").value = usuario.telefono || '';
                    document.getElementById("nombre_local").value = usuario.nombre_local || '';
                    document.getElementById("sector").value = usuario.sector || '';
                    document.getElementById("tipo_local").value = usuario.id_tipo_local || '';
                    document.getElementById("id_rol").value = usuario.id_rol;
                    console.log("Respuesta verifica q rol es:",usuario)
                    // Llamar a la función para mostrar u ocultar campos al cargar la página
                    // Vista previa de imagen
                    if (usuario.imagen_local) {
                        preview.src = usuario.imagen_local;
                        preview.onerror = () => {
                            console.warn("No se pudo cargar la imagen:", usuario.imagen_local);
                            preview.style.display = "none";
                        };
                        preview.style.display = "block";
                        preview.style.maxWidth = "200px";
                        preview.style.maxHeight = "200px";
                        preview.style.marginBottom = "10px";
                    } else {
                        preview.style.display = "none";
                    }
                    mostrarOcultarCanpos(parseInt(usuario.id_rol));

                } else {
                    alert("Error al cargar el id: " + data.error);
                }
            })
            .catch(err => console.error("Error cargando usuario:", err));
    }

    // Enviar datos con POST
    const form = document.getElementById("formUsuarios");
    form.addEventListener("submit", e => {
        e.preventDefault();
console.log("Tipo de local enviado:", document.getElementById("tipo_local").value);
        const formData = new FormData(form);
        formData.append("id_usuario", id);
        // Debug: mostrar todos los datos del FormData
        console.log("Datos del FormData:");
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
        // Verificar si hay archivo de imagen
        const imagenFile = formData.get('imagen');
        console.log("Archivo de imagen:", imagenFile);
        console.log("¿Hay archivo?", imagenFile && imagenFile.size > 0);

        fetch("../api_store/editar_usuarios.php", {
            method: "POST",
            body: formData  // Enviar FormData directamente, NO JSON
            // NO agregar Content-Type header, el navegador lo establecerá automáticamente
            // body: JSON.stringify(Object.fromEntries(formData)),
            // headers: { "Content-Type": "application/json" }
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Usuario actualizado correctamente");
                    cerrarEditar();
                } else {
                    alert("Error: " + data.error);
                }
            })
            .catch(err => console.error("Error guardando usuario:", err));
    });

    // Función para mostrar u ocultar campos según el rol
    function mostrarOcultarCanpos(selecionarRol) {
        console.log("Rol recibido:", selecionarRol); // Verifica el valor del rol recibido
        const localFields = document.querySelectorAll('.input-group.hidden');
        if (parseInt(selecionarRol) === 3) { // Comerciante
            console.log("Rol es Comerciante, mostrando campos");
            localFields.forEach(field => {
                field.style.display = 'flex';
                const inputs = field.querySelectorAll('input, select, label');
                inputs.forEach(input => {
                    if (input.name === 'nombre_local' || input.name === 'tipo_local' || input.name === 'sector') {
                        input.required = true;
                    }
                    // Marca como obligatorio el campo de imagen si no hay imagen cargada previamente
                    if (input.name === 'imagen' && !document.getElementById('preview').src) {
                        input.required = true;
                    }
                });
            });
        } else {
            console.log("Rol no es Comerciante, ocultando campos");
            localFields.forEach(field => {
                field.style.display = 'none';
                const inputs = field.querySelectorAll('input, select, label');
                inputs.forEach(input => {
                    input.required = false;
                });
            });
        }
    }

    // Manejar el cambio manual del rol
    const rolSelect = document.getElementById("id_rol");
    if (rolSelect) {
        rolSelect.addEventListener("change", () => {
            console.log("Rol seleccionado manualmente:", rolSelect.value); // Verifica el valor aquí
            mostrarOcultarCanpos(rolSelect.value);
        });
    }

    // Vista previa cuando se selecciona una nueva imagen
    // Vista previa cuando se selecciona una nueva imagen
    const imagenInput = document.getElementById("imagen");
    if (imagenInput) {
        imagenInput.addEventListener("change", function () {
            const file = this.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                    preview.style.maxWidth = "200px";
                    preview.style.maxHeight = "200px";
                    preview.style.marginBottom = "10px";
                };
                reader.readAsDataURL(file);
            } else {
                alert("Selecciona un archivo de imagen válido");
                this.value = '';
            }
        });
    }

});

// envio un mensaje para que escuche el otro js
function cerrarEditar() {
    // Enviar el mensaje al padre (la ventana que contiene el iframe)
    window.parent.postMessage({ action: 'cerrarModalEditar' }, '*');
}

