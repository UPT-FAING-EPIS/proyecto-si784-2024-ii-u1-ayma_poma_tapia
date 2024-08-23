<%-- 
    Document   : registrar
    Created on : 1 jul 2024, 11:42:23
    Author     : mario
--%>

<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<%@ page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
<head>
    <title>Registrarse</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>La Granja Bull</h1>
        <nav>
            <ul>
                <li><a href="index_principal.jsp">Inicio</a></li>
                <li><a href="login.jsp">Reservas</a></li>
                <li><a href="login.jsp">Servicios</a></li>
                <li><a href="login.jsp">Mascotas</a></li>
                <li><a href="login.jsp">Iniciar Sesión</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="register-container">
            <h2>Registrarse</h2>
            <div class="profile-picture">
                <img alt="" id="profileImage">
            </div>
            
            <form action="ControladorCliente" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <input type="hidden" name="action" value="registrar">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion" id="direccion" required>
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" name="telefono" id="telefono" required>
                </div>
                <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" name="usuario" id="usuario" required>
                </div>
                <div class="form-group">
                    <label for="clave">Clave:</label>
                    <input type="password" name="clave" id="clave" required>
                </div>
                <div class="form-group">
                    <label for="confirmar_clave">Confirmar Clave:</label>
                    <input type="password" name="confirmar_clave" id="confirmar_clave" required>
                </div>
                <div class="form-group">
                    <label for="img_usuario">Imagen:</label>
                    <input type="file" name="img_usuario" required id="img_usuario" onchange="previewImage(event)">
                </div>
                <div class="form-group">
                    <button type="submit">Registrarse</button>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <div class="footer-content">
            <div class="footer-section contact">
                <h3>Contáctanos</h3>
                <p>Pocollay:</p>
                <p>Teléfono: (01) 3635937</p>
                <p>WhatsApp: +51 991 328 751</p>
                <p>Dirección: Av.los Angeles 756, Tacna, Perú</p>
                <p>Pocollay:</p>
                <p>Teléfono: (01) 7682864</p>
                <p>WhatsApp: +51 970 307 676</p>
                <p>Dirección: Av.los Angeles 765, Tacna, Perú</p>
            </div>
            <div class="footer-section hours">
                <h3>Horario de atención</h3>
                <p>Informacion</p>
                <p>Lunes a domingos de 9 am a 9 pm</p>
                <p>Emergencias 24 horas (Pocollay)</p>
            </div>
            <div class="footer-section social">
                <h3>Síguenos</h3>
                <div class="social-icons">
                    <a href="#"><img src="images/facebook.png" alt="Facebook"></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Hotel para Perros. Todos los derechos reservados. Developed by [EPIS]</p>
        </div>
    </footer>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('profileImage');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function validateForm() {
            const telefono = document.getElementById('telefono').value;
            const telefonoPattern = /^[1-9]\d{8}$/;

            if (!telefonoPattern.test(telefono)) {
                alert('Por favor, ingrese un número de teléfono válido (solo dígitos del 1 al 9).');
                return false;
            }

            return true;
        }

        document.getElementById('telefono').addEventListener('input', function() {
            const telefono = this.value;
            this.value = telefono.replace(/[^1-9]/g, '');
        });
    </script>
</body>
</html>
