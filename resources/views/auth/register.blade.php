<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
    <form action="" method="POST">
        @csrf
        <div>
            <label for="name">Username</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="text" id="email" name="email" required>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <label for="co-password">Confirmation password</label>
            <input type="password" id="co-password" name="password_confirmation" required>
        </div>

        <button type="submit">
            Register
        </button>
        <a href="{{ route('login') }}">Login</a>
    </form>
</body>
</html>