<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}

// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Validate new password
  if (empty(trim($_POST["new_password"]))) {
    $new_password_err = "Please enter the new password.";
  } elseif (strlen(trim($_POST["new_password"])) < 6) {
    $new_password_err = "La contraseña al menos debe tener 6 caracteres.";
  } else {
    $new_password = trim($_POST["new_password"]);
  }

  // Validate confirm password
  if (empty(trim($_POST["confirm_password"]))) {
    $confirm_password_err = "Por favor confirme la contraseña.";
  } else {
    $confirm_password = trim($_POST["confirm_password"]);
    if (empty($new_password_err) && ($new_password != $confirm_password)) {
      $confirm_password_err = "Las contraseñas no coinciden.";
    }
  }

  // Check input errors before updating the database
  if (empty($new_password_err) && empty($confirm_password_err)) {
    // Prepare an update statement
    $sql = "UPDATE tbl_users SET password = ? WHERE id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

      // Set parameters
      $param_password = password_hash($new_password, PASSWORD_DEFAULT);
      $param_id = $_SESSION["id"];

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Password updated successfully. Destroy the session, and redirect to login page
        session_destroy();
        header("location: login.php");
        exit();
      } else {
        echo "Algo salió mal, por favor vuelva a intentarlo.";
      }
    }

    // Close statement
    mysqli_stmt_close($stmt);
  }

  // Close connection
  mysqli_close($link);
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="E-Commerce Website" />
  <meta name="author" content="Alejandro Medrano" />
  <meta name="generator" content="PHP, MySQL" />
  <link rel="shortcut icon" href="../images/A.jpg" />
  <title>Cambiar contraseña</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">



  <!-- Bootstrap core CSS -->
  <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="../assets/dist/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">

  <main class="form-signin">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <img class="mb-4" style="width:150px;
    height:150px;
    border-radius:150px;" src="../assets/images/user_pics/<?php echo $_SESSION['username'] . ".jpg" ?>" alt="" width="72" height="57">
      <h1 class="h3 mb-3 fw-normal">Cambia tu contraseña</h1>

      <div class="form-floating <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
        <input type="password" name="new_password" class="form-control" id="floatingInput" placeholder="name@example.com" value="<?php echo $new_password; ?>">
        <label for="floatingInput">Nueva contraseña</label>
        <span class="help-block"><?php echo $new_password_err; ?></span>
      </div>
      <div class="form-floating <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
        <input type="password" name="confirm_password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Repetir contraseña</label>
        <span class="help-block"><?php echo $confirm_password_err; ?></span>
      </div>
      <div class="form-group">
        <button class="btn btn-lg btn-primary" type="submit">Enviar</button>
        <a class="btn btn-lg btn-secondary" href="../">Cancelar</a>
      </div>
      <p class="mt-5 mb-3 text-muted">&copy;
        <script>
          document.write(new Date().getFullYear())
        </script> Desarrollo Web Profesional.
      </p>
    </form>
  </main>



</body>

</html>