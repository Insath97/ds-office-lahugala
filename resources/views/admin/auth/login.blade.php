<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; {{ getSettingInfo('site_name') }}</title>

    <link rel="icon" href="{{ asset('admin/assets/img/favicon/favicon.ico') }}" type="image/x-icon">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/fontawesome/css/all.min.css') }}">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .card-header {
            background: #fff;
            border-bottom: none;
            padding: 1.5rem 2rem 0;
            text-align: center;
            position: relative;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background-color: #4e73df;
        }

        .login-brand {
            padding: 1.5rem 0;
        }

        .login-brand img {
            width: 60px;
            height: auto;
        }

        .login-brand p {
            font-weight: bold;
            margin-top: 0.5rem;
            color: #333;
            font-size: 1.1rem;
        }

        .card-body {
            padding: 0 2rem 2rem;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-group label {
            font-weight: 500;
            color: #555;
            margin-bottom: 0.4rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 4px;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 4px;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #3a56c5;
            border-color: #3a56c5;
            transform: translateY(-1px);
        }

        .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .footer {
            text-align: center;
            padding: 1rem 2rem;
            color: #6c757d;
            font-size: 0.85rem;
            border-top: 1px solid #eee;
            background-color: #f9fafb;
        }

        .forgot-password {
            font-size: 0.9rem;
        }

        .alert {
            border-radius: 4px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 575.98px) {
            .login-card {
                max-width: 100%;
                box-shadow: none;
            }

            body {
                padding: 10px;
                align-items: flex-start;
                padding-top: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="card-header">
            <div class="login-brand">
                <img src="{{ asset('images/logo.png') }}" alt="logo">
                <p>DS OFFICE - {{ getSettingInfo('site_office_name') }}</p>
            </div>
        </div>

        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-primary alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        {{ session()->get('success') }}
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.handle-login') }}" class="needs-validation" novalidate="">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">Please fill in your email</div>
                    @error('email')
                        <code>{{ $message }}</code>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="control-label">Password</label>
                        <a href="{{ route('admin.forgot-password') }}" class="forgot-password">Forgot Password?</a>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">Please fill in your password</div>
                    @error('password')
                        <code>{{ $message }}</code>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">Login</button>
                </div>
            </form>
        </div>

        <div class="footer">
            Powered by DS Office {{ getSettingInfo('site_office_name') }} &copy; {{ date('Y') }}
            <div class="bullet"></div>
            System Designed & Developed By
            <a href="https://inzeedo.com/" target="_blank">{{ getSettingInfo('site_company_name') }}</a>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('admin/assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/modules/popper.js') }}"></script>
    <script src="{{ asset('admin/assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('admin/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('admin/assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/stisla.js') }}"></script>
</body>

</html>
