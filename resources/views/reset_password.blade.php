<!DOCTYPE html>
<html lang="en">

<head>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!------ Include the above in your HEAD tag ---------->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/additional.css">
    <div class="form-gap"></div>
    <title>Document</title>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">

                                <form id="reset_password_form" role="form" autocomplete="off" class="form" action="abc" method="post">
                                    @csrf
                                    <!-- <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" /> -->
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                            <input id="chng_password" name="chng_password" placeholder="change password" class="form-control" type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                            <input id="confirm_password" name="confirm_password" placeholder="confirm password" class="form-control" type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password">Reset</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript Bundle with Popper -->
    @include('layouts.partials.footer');