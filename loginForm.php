<!--
<?php
    session_start();
    if ((isset($_SESSION['login']))) {
        header("Location: dashboard.php");
        exit();
    }
?>
-->
<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Boondoggle Dashboard</title>
    <link rel="shortcut icon" href="">
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/moment.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.0/fullcalendar.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.0/fullcalendar.print.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link rel='stylesheet' href="boondoggle.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.0/fullcalendar.min.js"></script>
    <link rel="shortcut icon" href="favicon.ico" />
    <script>
        $(document).ready(function(){
            $("#register").click(function() {
                $("#registerModal").modal();
            });

            resizeLogin();

            $(window).resize(function () {
                resizeLogin();
            });

            function resizeLogin() {
                var windowWidth = $(window).width();
                if (windowWidth < 1200) {
                    $(".login-panel").css({'margin-top':'20px'});
                    $("#explain-panel").hide();
                    $("#signin-panel").addClass("col-md-12");
                    $("#signin-panel").removeClass("col-md-6");

                }
                else if (windowWidth < 1000) {
                    $(".login-panel").css({'margin-top':'20px'});
                    $("#explain-panel").show();
                    $("#signin-panel").addClass("col-md-6");
                    $("#signin-panel").removeClass("col-md-12");
                }
                else {
                    $(".login-panel").css({'margin-top':'250px'});
                    $("#explain-panel").show();
                    $("#signin-panel").addClass("col-md-6");
                    $("#signin-panel").removeClass("col-md-12");
                }
            }
        });




    </script>
    <!--[if IE]>
          <script src="https://cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>
     <![endif]-->
</head>

<body>



<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
            <div class="panel panel-primary login-panel">
                <div class="panel-heading calendar-heading login-heading">
                    <div class="logo">Boondoggle</div>
                </div>
                <div class="panel-body login-body">
                    <div class="hidden-sm hidden-xs col-md-6" id="explain-panel">
                        <div class="panel panel-primary logo-panel">
                            <div class="panel-body">
                                Boondoggle is a homework tracking web app made for CSIT 2230 at Pellissippi State, by me, TJ Buckner.
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12" id="signin-panel">
                        <form class="form-horizontal" action="login.php" method="post" role="form">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="username" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-default btn-submit">Sign in</button>

                                    <button type="button" id="register" class="btn btn-default btn-register">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="registerModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Sign Up for Boondoggle!</h4>
            </div>
            <form class="form-horizontal" action="register.php" method="post" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">First Name:</label>
                        <div class="col-sm-8">
                            <input type="textarea" class="form-control" name="firstName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Last Name:</label>
                        <div class="col-sm-8">
                            <input type="textarea" class="form-control" name="lastName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">User Name:</label>
                        <div class="col-sm-8">
                            <input type="textarea" class="form-control" name="userName">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Email Address:</label>
                        <div class="col-sm-8">
                            <input type="textarea" class="form-control" name="email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Password:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Confirm Password:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="confirmPassword">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-4 col-sm-offset-8 col-xs-12">
                        <button type="submit" class="btn btn-default submit">Register</button>
                    </div>

                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

</body>

</html>
