<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
</head>
<body>

<div class="card">
    <h2>Selamat Datang</h2>

    <form method="POST" action="/login">
        @csrf

        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px; font-size: 14px; text-align: left;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@contoh.com" required>
        </div>

        <div class="form-group">
            <label>Kata Sandi</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <button class="btn-main" type="submit">
            Masuk
        </button>
    </form>

    <div class="small-text">
        Belum punya akun?
    </div>

    <a href="/register">
        <button class="btn-secondary">
            Buat akun →
        </button>
    </a>
</div>

</body>
</html>