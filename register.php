<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/taktyl.jpg" rel="icon">
    <title>Taktyl - Login</title>
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
                                        <h1 class="h4 text-gray-900 mb-4">Inscription !</h1>
                                        <img src="img/logo/taktyl.jpg" width="100" height="100"
                                            style="margin-top: -30px;margin-bottom:10px ;">
                                    </div>
                                    <form class="user" action="controller/login" method="post">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="fa fa-user"></i></span>
                                            </div>
                                            <input type="text" name="nom" class="form-control"
                                                placeholder="Nom complet" aria-label="Username"
                                                aria-describedby="basic-addon1" required="required" onkeyup="this.value=this.value.charAt(0).toUpperCase()+this.value.substr(1);">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="fa fa-sort-numeric-down"></i></span>
                                            </div>
                                            <select name="formule" id=""  class="form-control" required="required">
                                                <option value="">Selectionnez formule</option>
                                                <option value="1">Formule 1</option>
                                                <option value="3">Formule 2</option>
                                                <option value="1000">Formule 3</option>
                                            </select>
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="fa fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="telephone" class="form-control"
                                                placeholder="Telephone" aria-label="Username"
                                                aria-describedby="basic-addon1" required="required">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="fa fa-envelope"></i></span>
                                            </div>
                                            <input type="text" name="emailconnect" class="form-control"
                                                placeholder="Adresse email" aria-label="Username"
                                                aria-describedby="basic-addon1" required="required">
                                        </div>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="fa fa-lock"></i></span>
                                            </div>
                                            <input type="password" name="mdpconnect" id="password" class="form-control"
                                                placeholder="Mot de passe" aria-label="Username"
                                                aria-describedby="basic-addon1" required="required">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-eye-slash"
                                                        id="togglePassword" style="cursor: pointer"></i></span>
                                            </div>
                                        </div>

                                        
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block" name="register">Inscription</button>
                                        </div>
                                    </form>
                                    <div class="card-footer bg-white p-0" align="center">
                                        <?php  if(isset($_SESSION['message_delete'])){?>
                                        <div class="alert alert-danger alert-dismissible" role="alert"
                                            <?=$_SESSION['msg_type_delete'] ?> align="center">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
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

        togglePassword.addEventListener("click", function() {

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