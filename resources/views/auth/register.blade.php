<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
</head>
<body>

<div class="card">
    <h2>Daftar Akun</h2>

    <form method="POST" action="/register">
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
            <label>Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@contoh.com" required>
        </div>

        <div class="form-group">
            <label>Kata Sandi</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <div class="form-group">
            <label>Jenis Keanggotaan</label>
            <select name="role" required>
                <option value="donatur">Donatur</option>
                <option value="panti">Pihak Panti</option>
            </select>
        </div>

        <button class="btn-main" type="submit">
            Daftar
        </button>
    </form>

    <div class="small-text">
        Sudah memiliki akun? <a href="{{ route('login') }}">Masuk</a>
    </div>
</div>

</body>
</html>
