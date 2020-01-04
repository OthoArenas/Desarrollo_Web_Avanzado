<?php
date_default_timezone_set('America/Mexico_City');
session_start();

/* Inicio de Sesión */
if (isset($_POST['login-submit'])) {

    if (empty($_POST['email'])) {
        $errors[] = "<li>Correo electrónico / Nombre de usuario vacío</li>";
    }
    if (empty($_POST['password'])) {
        $errors[] = "<li>Contraseña vacía</li>";
    }
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        /* Función strip_tags para elimitar etiquetas HTML y PHP */
        $email = strip_tags($_POST["email"], ENT_QUOTES);
        $password = strip_tags($_POST['password'], ENT_QUOTES);
        $encriptedPassword = sha1($password);

        $fileName = "../registros.txt";
        $loop = 0;
        $archivo = fopen($fileName, "r");
        $count = 0;
        while (!feof($archivo)) {
            $loop++;
            $line = fgets($archivo);
            $data[$loop] = explode(',', $line);
            $archivo++;
            if ($email == $data[$loop][0] || $email == $data[$loop][1]) {
                $count++;
            }
            /* Función de cadenas de texto sttcmp() para comparar dos strings */
            $passCmp = strcmp($encriptedPassword,$data[$loop][2]);
            if (($email == $data[$loop][0] && $passCmp==0) || ($email == $data[$loop][1] && $passCmp == 0)) {
                $username = $data[$loop][0];
                $_SESSION['user_id'] = $username;
                header("location: ../home.php");
            } else if ($count == 0) {
                $errors[0] = 'El correo electrónico o nombre de usuario ingresados no se encuentran registrados. Por favor, diríjase a la Sección "Registrarse"';
            } else {
                $errors[0] = "Correo Electrónico / Contraseña inválidos. Intente nuevamente.";
            }
        }
    }
    if (isset($errors)) {

?>
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Error!</strong>
            <?php
            /* Ciclo Foreach */
            foreach ($errors as $error) {
                echo $error;
            }
            ?>
        </div>
    <?php
    }
    if (isset($messages)) {

    ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Bien hecho!</strong>
            <?php
            foreach ($messages as $message) {
                echo $message;
            }
            ?>
        </div>
    <?php
    }
}

/* Registro de usuario */
if (isset($_POST['register-submit'])) {
    /*Inicia validacion del lado del servidor*/
    /* Array que contiene los errores de validación */
    if (empty($_POST['username'])) {
        $errors[] = "<li>Nombre de usuario vacío</li>";
    }
    if (empty($_POST['email'])) {
        $errors[] = "<li>Correo vacío</li>";
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "<li>Correo Electrónico no válido.</li>";
    }
    if (empty($_POST['password'])) {
        $errors[] = "<li>Contraseña vacía</li>";
    }
    if (empty($_POST['password_validation'])) {
        $errors[] = "<li>Valida la contraseña</li>";
    }
    if (($_POST['password']) != ($_POST['password_validation'])) {
        $errors[] = "<li>Las contraseñas no coinciden";
    } else if (strlen($_POST['password']) < 6) {
        $errors[] = "<li>El password debe tener al menos 6 caracteres.</li>";
    } else if (strlen($_POST['password']) > 16) {
        $errors[] = "<li>El password no puede tener más de 16 caracteres.</li>";
    } else if (!preg_match('`[a-z]`', $_POST['password'])) {
        $errors[] = "<li>El password debe tener al menos una letra minúscula.</li>";
    } else if (!preg_match('`[A-Z]`', $_POST['password'])) {
        $errors[] = "<li>El password debe tener al menos una letra mayúscula.</li>";
    } else if (!preg_match('`[0-9]`', $_POST['password'])) {
        $errors[] = "<li>El password debe tener al menos un número.</li>";
        /* En caso de que todos los datos sean correctos. Inicia el registro en archivo */
    } else {
        $username = strip_tags($_POST["username"], ENT_QUOTES);
        $email = strip_tags($_POST["email"], ENT_QUOTES);
        $password = strip_tags($_POST['password'], ENT_QUOTES);
        $encriptedPassword = sha1($password);
        $created_at = date("d/m/Y g:ia");
        $active = 0;

        $token = 'qwertzuiopasdfghjklyxcvbnmQWERTZUIOPASDFGHJKLYXCVBNM0123456789!$/()*';
        $token .= $email . time();
        /* Ciclo For para generar número aleatorios para el Token */
        for ($i=0; $i < 2; $i++) { 
            $token.=rand(0,9);
        }
        $token = str_shuffle($token);
        /* Función substr para devolver una subcadena */
        $token = substr($token, 0, 10);

        $fileName = "../registros.txt";
        $loop = 0;
        $archivo = fopen($fileName, "r");
        while (!feof($archivo)) {
            $loop++;
            $line = fgets($archivo);
            $data[$loop] = explode(',', $line);
            $archivo++;
            if (($username == $data[$loop][0] || $email == $data[$loop][1]) && !$registered) {
                $errors[] = "<li>El nombre de usuario o correo electrónico ingresados ya se encuentran registrados.</li>";
                $registered = true;
            }
        }

        $registerData = "$username,$email,$encriptedPassword,$created_at,$token,$active";

        if (file_exists($fileName) && $registered != true) {
            if ($archivo = fopen($fileName, "a")) {
                fwrite($archivo, $registerData . "\n");
                fclose($archivo);
                $messages[] = "El usuario ha sido registrado exitosamente. <br> Un correo de verificación será enviado al correo: <strong>$email</strong>";
                $activationUrl = "<a href='https://test.dsignstudio.com.mx/confirmation.php?email=$email&token=$token'>Haz Click</a>";
                $to = $email;
                $subject = "Código de Activación de su cuenta";
                $message = "<p>Bienvenid@ $username.</p>";
                $message .= "<p>A continuación se muestra un link para la Activación de tu cuenta. </p></br>";
                $message .= $activationUrl;

                $headers = "From: Support <support@support.com>\r\n";
                $headers .= "Reply-To: support@support.com\r\n";
                $headers .= "Content-type: text/html\r\n";

                mail($to, $subject, $message, $headers);

                header("location: ../index.php");
            }
        }
    }
    if (isset($errors)) {

    ?>
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Error!</strong>
            <?php
            foreach ($errors as $error) {
                echo $error;
            }
            ?>
        </div>
    <?php
    }
    if (isset($messages)) {

    ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Bien hecho!</strong>
            <?php
            foreach ($messages as $message) {
                echo $message;
            }
            ?>
        </div>
<?php
    }
}

/* Cerrar sesión */
if (isset($_POST['logout-btn'])) {
    if (isset($_SESSION['user_id'])) {
        session_destroy();
        header("location: ../index.php"); //Redirije a index.php
    }
}

/* Función para crear el archivo de registros en caso de no existir. */
function createFile(){
    date_default_timezone_set('America/Mexico_City');
    
    $fileName = "registros.txt";
    if (!file_exists($fileName)) {
        $mensaje = "El Archivo $fileName se ha creado correctamente.";
        if ($archivo = fopen($fileName, "a")) {
            fwrite($archivo, date("d/m/Y g:ia") . " " . $mensaje . "\n");
            fclose($archivo);
        }
    }
}
?>