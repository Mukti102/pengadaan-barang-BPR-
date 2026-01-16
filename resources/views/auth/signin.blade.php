<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login | Sistem Pengadaan Barang</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="/assets/img/kaiadmin/favicon.ico" type="image/x-icon" />

    <script src="/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                "families": ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['/assets/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/plugins.min.css">
    <link rel="stylesheet" href="/assets/css/kaiadmin.min.css">

    <style>
        body {
            background-color: #f5f7fd;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            background: #1a508b;
            padding: 30px;
            text-align: center;
            color: white;
        }

        .login-header h2 {
            font-weight: 700;
            margin: 0;
            letter-spacing: 1px;
        }

        .btn-login {
            background: #1a508b;
            border: none;
            font-weight: 600;
            padding: 12px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: #154273;
            transform: translateY(-2px);
        }

        .form-control:focus {
            border-color: #1a508b;
            box-shadow: 0 0 0 0.2rem rgba(26, 80, 139, 0.1);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="login-card mx-auto bg-white">
            <div class="login-header">

                <img style="width: 200px;" src="{{ asset('storage/' . setting('site_logo')) }}"
                    alt="">
                <p class="mb-0 text-white-50 mt-2">Sistem Pengadaan Barang</p>
            </div>
            <div class="card-body p-4">

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3 p-0">
                        <label for="email" class="form-label fw-bold">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="fas fa-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control border-start-0 ps-0" id="email"
                                placeholder="nama@perusahaan.com" required autofocus>
                        </div>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-4 p-0">
                        <label for="password" class="form-label fw-bold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="fas fa-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control border-start-0 border-end-0 ps-0"
                                id="password" placeholder="Masukkan password" required>
                            <span class="input-group-text bg-light border-start-0 cursor-pointer" id="togglePassword">
                                <i class="fas fa-eye-slash text-muted"></i>
                            </span>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check p-0 m-0">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label text-muted" for="remember" style="margin-left: 20px;">
                                Ingat Saya
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-login mb-3">
                        Masuk Ke Dashboard
                    </button>
                </form>

                <div class="text-center mt-3">
                    <p class="small text-muted mb-0">&copy; {{ date('Y') }}
                        {{ setting('site_name', 'Sistem Pengadaan') }}</p>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>

    <script>
        // Fitur Lihat/Sembunyi Password
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
