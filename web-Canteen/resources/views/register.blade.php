<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Register </title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
<div class="container">
    <div class="login-box">
        <h2> REGISTER </h2>
        <img src="{{ asset('images/logo.png') }}" class="logo">
        @if($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <input type="text" name="username" placeholder="Nama User" required autocomplete="off">
            <input type="email" name="email" placeholder="Email" required autocomplete="off">
            <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
            <input type="text" name="phone" placeholder="No Handphone" required autocomplete="off">
            <button type="submit"> REGISTER </button>
        </form>

        <p class="register">
            Sudah punya akun?
            <a href="{{ route('login') }}"> Login </a>
        </p>
    </div>
</div>

</body>
</html>