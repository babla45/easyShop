<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
  <h2>Login to your account</h2>
  <div class="container">
    <!-- Show any error messages -->
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST">
      @csrf
      <p class="lab" for="emailInput">Enter your email:</p>
      <input type="email" id="emailInput" name="email" placeholder="email" required>

      <p class="lab" for="passwordInput">Enter your password:</p>
      <input type="password" id="passwordInput" name="password" placeholder="password" required>

      <div class="form-check">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Remember Me</label>
      </div>

      <button type="submit">Login</button>
    </form>
  </div>

  <p>Don't have an account? <a href="register">Create Account</a></p>
</body>
</html>
