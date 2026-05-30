<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="container">
    <div class="login-box">
        
        <h2>REGISTER</h2>

        <!-- Logo -->
        <img src="{{ asset('images/logo.png') }}" class="logo">

        <!-- Form Register -->
        <form action="#" method="POST">
            @csrf
            <input type="text" name="username" placeholder="Nama User" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="phone" placeholder="No Handphone" required>

            <button type="submit">REGISTER</button>
        </form>

        <!-- Kembali ke login -->
        <p class="register">
            Sudah punya akun? 
            <a href="{{ route('login') }}">Login</a>
        </p>

    </div>
</div>

</body>
</html>
