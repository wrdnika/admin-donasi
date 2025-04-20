<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"/>
  <style>
    body {
      background: linear-gradient(to bottom right, #e0f2fe, #f8fafc);
      font-family: 'Segoe UI', sans-serif;
    }
    .login-card {
      width: 100%;
      max-width: 420px;
      border-radius: 1rem;
      background-color: #ffffff;
      padding: 2rem;
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
    }
    .login-card h3 {
      font-weight: 700;
      color: #0d6efd;
    }
    .form-control:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    .btn-primary {
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #0b5ed7;
      box-shadow: 0 4px 12px rgba(13, 110, 253, 0.35);
    }
    .login-icon {
      font-size: 3rem;
      color: #0d6efd;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

  <div class="login-card text-center">
    <div class="login-icon">
      🔒
    </div>
    <h3 class="mb-3">Login Admin</h3>

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
