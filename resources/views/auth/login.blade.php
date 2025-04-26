<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <style>
    @keyframes gradient-animation {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }
    body {
        background: url('/background-login.png') no-repeat center center fixed;
        background-size: cover;
        font-family: 'Segoe UI', sans-serif;
        height: 100dvh;
    }

    .login-card {
      width: 100%;
      max-width: 420px;
      border-radius: 1rem;
      background-color: rgba(255, 255, 255, 0.4);
      padding: 2rem;
      margin: 10px;
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(10px) !important;
    }
    .login-card h3 {
      font-weight: 700;
      color: #000000;
    }
    .form-control:focus {
      border-color: #14c46c;
      box-shadow: 0 0 0 0.2rem rgba(13, 253, 113, 0.35);
    }
    .btn-primary {
      background: linear-gradient(-45deg, #1a1a2e, #46913f, #559c4b, #1a1a2e);
      background-size: 400% 400%;
      margin: 0;
      animation: gradient-animation 6s ease infinite;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #14c46c;
      box-shadow: 0 4px 12px rgba(13, 253, 113, 0.35);
    }
    .login-icon {
      font-size: 3rem;
      color: #0dfd8d;
      margin-bottom: 1rem;
    }

  </style>
</head>
<body class="d-flex justify-content-center align-items-center">

  <div class="login-card text-center">
    <div class="login-icon">
        <img src="/logo.png" alt="Logo Admin" class="img-fluid" style="max-height: 100px;" />
    </div>

    <h3 class="mb-3 ">IKBS Admin</h3>

    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show text-start" role="alert">
        {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="mb-3 text-start">
        <label class="form-label fw-semibold">Email</label>
        <input type="email" name="email" class="form-control py-2" placeholder="Masukkan email" required>
      </div>

      <div class="mb-3 text-start">
        <label class="form-label fw-semibold">Password</label>
        <input type="password" name="password" class="form-control py-2" placeholder="Masukkan password" required>
      </div>

      <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Login</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
