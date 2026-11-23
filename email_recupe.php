<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logoSN.ico" rel="icon">
  <title>Gstock - Login</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Mot de passe oublié !</h1>
                  </div>
                  <form class="user" action="controller/send_email_recupe" method="post">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                    </div>
                    <input type="text" name="email" class="form-control" placeholder="Entrer un Adresse email" aria-label="Username"
                      aria-describedby="basic-addon1">
                  </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block" name="btn_envoyer">REINITIALISER</button>
                    </div>              
                  </form>
                  <div class="card-footer bg-white p-0" align="center">
                  <?php 
	if(isset($_SESSION['message_add'])){?>
	<div class="alert alert-success" <?=$_SESSION['msg_type_add'] ?> align="center">
	<?php 
	echo $_SESSION['message_add'];
	unset($_SESSION['message_add']);
	?>
	</div>
	<?php }else if(isset($_SESSION['message_update'])){?>
	<div class="alert alert-warning" <?=$_SESSION['msg_type_update'] ?>>
	<?php 
	echo $_SESSION['message_update'];
	unset($_SESSION['message_update']);
	?>
	</div>
	<?php }else if(isset($_SESSION['message_delete'])){?>
	<div class="alert alert-danger" <?=$_SESSION['msg_type_delete'] ?> align="center">
	<?php 
	echo $_SESSION['message_delete'];
	unset($_SESSION['message_delete']);
	?>
	</div>
	<?php }?>
                  <hr>
                 
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script language="JavaScript">
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    
    togglePassword.addEventListener("click", function () {
       
      // toggle the type attribute
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);
      // toggle the eye icon
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
    </script>
</body>

</html>