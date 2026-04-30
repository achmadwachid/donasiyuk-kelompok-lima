<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Panti</title>
    <link rel="stylesheet" href="{{ asset('css/profil/panti.css') }}">
</head>
<body>

<div class="navbar">
    <div class="brand">DonasiYuk</div>
    <div class="menu">
        <a href="{{ route('halamanutama.panti') }}">Halaman Utama</a>
        <a href="{{ route('riwayat.panti') }}">Riwayat</a>
        <a href="{{ route('profil.panti') }}" class="active">Profil</a>
    </div>
</div>

<div class="container">
    <div class="profile-header">
        <div class="photo-wrapper" onclick="document.getElementById('photoInput').click()">
            <div class="photo-circle">
                @if($profile->photo_path)
                    <img src="{{ asset('storage/' . $profile->photo_path) }}" alt="Foto">
                @else
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                @endif
            </div>
            <form id="photoForm" action="/profil/panti" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="photo" id="photoInput" onchange="document.getElementById('photoForm').submit()">
            </form>
        </div>
        <div class="profile-title">
            <h1>Profil Panti</h1>
            <p>{{ $profile->head_name ? $user->name : '-' }}</p>
        </div>
    </div>

    <div class="card">
        <form id="profileForm" action="/profil/panti" method="POST">
            @csrf
            <div class="card-header">
                <div class="card-title">Detail Akun</div>
                <div class="action-buttons">
                    <div class="btn-edit-text" id="editBtn" onclick="enableEdit()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        Ubah Profil
                    </div>
                    <button type="submit" class="btn-save" id="saveBtn">Simpan</button>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Panti</label>
                    <div class="input-wrapper with-bar">
                        <input type="text" name="name" id="name" value="{{ $profile->head_name ? $user->name : '' }}" disabled required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email Operasional</label>
                    <div class="input-wrapper with-bar">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        <input type="email" value="{{ $user->email }}" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label>Nama Kepala</label>
                    <div class="input-wrapper with-bar">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                        <input type="text" name="head_name" id="head_name" value="{{ $profile->head_name }}" disabled required>
                    </div>
                </div>

                <div class="form-group">
                    <label>No HP</label>
                    <div class="input-wrapper with-bar">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <input type="text" name="phone" id="phone" value="{{ $profile->phone }}" disabled required>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label>Alamat</label>
                    <div class="input-wrapper textarea-wrapper">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <textarea name="address" id="address" disabled required>{{ $profile->address }}</textarea>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label>Nomor NIB</label>
                    <div class="input-wrapper with-bar">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <input type="text" name="nib_number" id="nib_number" value="{{ $profile->nib_number }}" disabled required>
                    </div>
                </div>
            </div>
        </form>

        <div class="logout-wrapper">
            <a href="{{ route('halamanutama.panti') }}" class="btn-logout" style="text-decoration: none;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Keluar Sesi
            </a>
        </div>
    </div>
</div>

<script>
    function enableEdit() {
        document.getElementById('name').disabled = false;
        document.getElementById('head_name').disabled = false;
        document.getElementById('nib_number').disabled = false;
        document.getElementById('phone').disabled = false;
        document.getElementById('address').disabled = false;
        document.getElementById('saveBtn').style.display = 'block';
        document.getElementById('editBtn').style.display = 'none';
    }
</script>

</body>
</html>
