<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Monitoring Mahasiswa | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
        .custom-h3 {
            color: #fff;
        }
    </style>
<body>
    <section class="vh-100" style="background: #000">
        <div class="container py-5 h-100">
            <h3 class="custom-h3 text-center">Sistem Monitoring Mahasiswa</h3>
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
                        class="img-fluid" alt="Login Image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">

                @if (session('loginError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <!-- username input -->
                        <div class="form-outline mb-4">
                            <input type="username" id="username" name="username" class="form-control form-control-lg" required />
                            <label class="form-label" for="username" style="color: #fff">Username</label>
                        </div>
                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <input type="password" id="password" name="password" class="form-control form-control-lg" required />
                            <label class="form-label" for="password" style="color: #fff">Password</label>
                        </div>
                        <!-- <div class="form-group row">
                            <label for="captcha" class="col-md-4 col-form-label text-md-right" style="color: #fff">Captcha</label>

                            <div class="col-md-6">
                                <input id="captcha" type="text" class="form-control" name="captcha" required>
                            </div>
                        </div> -->
                        <!-- Submit button -->
                        <br>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
