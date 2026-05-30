<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    
    
</head>
<body>

<div class="container">
    <h2>LOGIN</h2>

    <img src="{{ asset('images/logo.png') }}" class="logo">

    <form method="GET" action="{{ route('dashboard') }}">
        @csrf
        <input type="text" name="username" placeholder="Nama User">
        <input type="password" name="password" placeholder="Password">

        <button type="submit">LOGIN</button>
    </form>

    <div class="register">
        Belum Punya Akun? 
        <a href="{{ route('register') }}">Daftar</a>
    </div>
</div>

</body>
</html>
