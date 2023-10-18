<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Your App Name</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f3f3;
        }
        .login-container {
            margin-top: 100px;
        }
        .login-box {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .login-header {
            background-color: #337ab7;
            color: #fff;
            padding: 15px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .login-header h2 {
            margin: 0;
        }
        .login-body {
            padding: 20px;
        }
        .form-control {
            border-radius: 3px;
        }
        .btn-login {
            background-color: #337ab7;
            color: #fff;
        }
        .btn-login:hover {
            background-color: #286090;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row login-container">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-box">
                <div class="login-header">
                    <h2>Login</h2>
                </div>
                <div class="login-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Username" name="username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-login btn-block">Login</button>
                        </div>
                        <div class="checkbox">

