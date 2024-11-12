<!-- signup.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <form name="sheet">
    <div class="container">
      <h1>Create Your Account</h1>
        <p class="lab" for="emailInput">Enter your email:</p>
        <input type="email" name="Email" id="emailInput" placeholder="email">
        <p class="lab" for="passwordInput">Enter your password:</p>
        <input type="password" name="Key" id="passwordInput" placeholder="password">
        <button type="submit" onclick="signUp()">submit</button>
    </div>
  </form>
  <p>Already have an account? <a href="login">Sign In</a></p>


</body>
</html>
