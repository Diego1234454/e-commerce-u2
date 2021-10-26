<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
  header("location: ../");
  exit;
}

// Include config file
//require_once "../config.php";
$config = include '../config.php';

// Define variables and initialize with empty values
$username = $name = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Validate username
  if (empty(trim($_POST["username"]))) {
    $username_err = "Por favor ingrese un usuario.";
  } else {
    // Prepare a select statement
    $sql = "SELECT id FROM tbl_users WHERE username = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "s", $param_username);

      // Set parameters
      $param_username = trim($_POST["username"]);
      $param_name = trim($_POST["name"]);
      $param_roleid = "2";

      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        /* store result */
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 1) {
          $username_err = "Este usuario ya fue tomado.";
        } else {
          $username = trim($_POST["username"]);
          $name = trim($_POST["name"]);

          if (($_FILES['foto']['name'] != "")) {
            // Where the file is going to be stored
            $target_dir = "../Assets/user_pics";
            $file = $_FILES['foto']['name'];
            $path = pathinfo($file);
            $filename = $username;
            $ext = "jpg"; //$path['extension'];
            $temp_name = $_FILES['foto']['tmp_name'];
            $path_filename_ext = $target_dir . $filename . "." . $ext;

            // Check if file already exists
            if (file_exists($path_filename_ext)) {
              unlink($path_filename_ext);
              move_uploaded_file($temp_name, $path_filename_ext);
            } else {
              move_uploaded_file($temp_name, $path_filename_ext);
            }
          }
        }
      } else {
        echo "Al parecer algo salió mal.";
      }
    }

    // Close statement
    mysqli_stmt_close($stmt);
  }

  // Validate password
  if (empty(trim($_POST["password"]))) {
    $password_err = "Por favor ingresa una contraseña.";
  } elseif (strlen(trim($_POST["password"])) < 6) {
    $password_err = "La contraseña al menos debe tener 6 caracteres.";
  } else {
    $password = trim($_POST["password"]);
  }

  // Validate confirm password`
  if (empty(trim($_POST["confirm_password"]))) {
    $confirm_password_err = "Confirma tu contraseña.";
  } else {
    $confirm_password = trim($_POST["confirm_password"]);
    if (empty($password_err) && ($password != $confirm_password)) {
      $confirm_password_err = "No coincide la contraseña.";
    }
  }

  // Check input errors before inserting in database
  if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

    // Prepare an insert statement
    $sql = "INSERT INTO tbl_users (username, name, password, role_id) VALUES (?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($link, $sql)) {
      // Set parameters
      $param_username = $username;
      $param_name = $name;
      $param_password = password_hash($password, PASSWORD_DEFAULT);

      // Bind variables to the prepared statement as parameters
      mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_name, $param_password, $param_roleid);


      // Attempt to execute the prepared statement
      if (mysqli_stmt_execute($stmt)) {
        // Redirect to login page
        header("location: login.php");
      } else {
        echo "Algo salió mal, por favor inténtalo de nuevo.";
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
  <meta name="description" content="All-Games E-Commerce Website />
  <meta name="author" content="Alejandro - Medrano" />
  <meta name="generator" content="PHP, MySQL" />
  <link rel="shortcut icon" href="../images/A.jpg" />
  <title>Registrar</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">



  <!-- Bootstrap core CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">

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
  <link href="../css/signin.css" rel="stylesheet">
</head>

<body class="text-center">

  <main class="form-signin">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
      <img class="mb-4" src="../images/register.png" width="100">
      <h1 class="h3 mb-3 fw-normal"><b>Create Account</b></h1>
      <div class="form-floating <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
        <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Username" value="<?php echo $username; ?>">
        <label for="floatingInput">Username</label>
        <span class="help-block"><?php echo $username_err; ?></span>
      </div>
      <p></p>
      <div class="form-floating ">
        <input type="text" name="name" class="form-control" id="floatingInput" placeholder="Name">
        <label for="floatingInput">Name</label>
      </div>
      <p></p>
      <div class="form-floating">
        <input type="file" name="foto" class="form-control" id="floatingInput" placeholder="Foto">
        <label for="floatingInput">Photo</label>
      </div>
      <p>
        
      </p>
      <div class="form-floating <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" value="<?php echo $password; ?>">
        <label for="floatingPassword">Password</label>
        <span class="help-block"><?php echo $password_err; ?></span>
      </div>
      <p>

      </p>
      <div class="form-floating <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
        <input type="password" name="confirm_password" class="form-control" id="floatingPassword" placeholder="Repeat password" value="<?php echo $confirm_password; ?>">
        <label for="floatingPassword">Confirm Password</label>
        <span class="help-block"><?php echo $confirm_password_err; ?></span>
      </div>
      <p></p>
      <div class="form-group">
        <button class="btn btn-lg btn-success" type="submit"><b>Register</b></button>
        <button class="btn btn-lg btn-dark" type="reset"><b>Clear</b></button>
      </div>
      <p></p>
      <p>Do you already have an account? <a href="login.php"><b>Login</b></a>.</p>
      <p class="mt-5 mb-3 text-muted">&copy;
        <script>
          document.write(new Date().getFullYear())
        </script> <b>E-Commerce Website. </b>
      </p>
      </p>
    </form>
  </main>
</body>

</html>