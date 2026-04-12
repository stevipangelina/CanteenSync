<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            background-color: #c9c7d8;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 350px;
            margin: 100px auto;
            background: #e8e6e6;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
        }

        h2 {
            margin-bottom: 10px;
        }

        .logo {
            width: 60px;
            margin: 10px auto;
        }

        input {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 20px;
            border: none;
            background: #b9d8c3;
            outline: none;
        }

        button {
            padding: 10px 30px;
            border: none;
            border-radius: 20px;
            background: #5cbf7a;
            color: black;
            font-weight: bold;
            cursor: pointer;
        }

        .register {
            margin-top: 15px;
            font-size: 14px;
        }

        .register a {
            color: blue;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>LOGIN</h2>

    <img src="logo.png" class="logo">

    <form method="POST" action="/login">
        @csrf
        <input type="text" name="username" placeholder="Nama User">
        <input type="password" name="password" placeholder="Password">

        <button type="submit">LOGIN</button>
    </form>

    <div class="register">
        Belum Punya Akun? <a href="/register">Daftar</a>
    </div>
</div>

</body>
</html>
