<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama - Panti</title>
    <link rel="stylesheet" href="{{ asset('css/halamanutama/panti.css') }}">
</head>
<body>

<div class="navbar">
    <div class="brand">DonasiYuk</div>
    <div class="menu">
        <a href="{{ route('halamanutama.panti') }}" class="active">Halaman Utama</a>
        <a href="{{ route('riwayat.panti') }}">Riwayat</a>
        <a href="{{ route('profil.panti') }}">Profil</a>
    </div>
    <div style="margin-left: auto; display: flex; align-items: center; gap: 15px;">
        <button class="btn-meminta" onclick="openModal()">Meminta</button>
        <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
            @csrf
        </form>
        <button class="btn-logout-nav" onclick="confirmLogout()">Logout</button>
    </div>
</div>

<div class="container">
    <div class="hero">
        <h1>Menghubungkan Hati,<br>Menyembuhkan Negeri.</h1>
        <p>Jelajahi berbagai permintaan bantuan dari panti asuhan yang telah terverifikasi. Transparansi adalah kunci dari setiap kebaikan yang Anda salurkan.</p>
    </div>

    <div class="grid" id="donationGrid">
        @if(isset($activeRequests) && $activeRequests->count() > 0)
            @foreach($activeRequests as $userId => $requests)
                @php
                    $user = $requests->first()->user;
                    $pantiProfile = $user ? $user->pantiProfile : null;
                    $isUrgent = $requests->contains('is_urgent', true);
                @endphp
                
                @if($user && $pantiProfile)
                    <div class="card">
                        <div class="card-img">
                            @if($isUrgent)
                                <span class="urgent-badge">Urgent</span>
                            @endif
                            @if($pantiProfile && $pantiProfile->photo_path)
                                <img src="{{ asset('storage/' . $pantiProfile->photo_path) }}" alt="Panti Photo" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                            @endif
                        </div>
                        <div class="card-content">
                            <h3>{{ $user->name }}</h3>
                            <div class="nib">NIB: {{ $pantiProfile->nib_number }}</div>
                            <div class="address">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                {{ $pantiProfile->address }}
                            </div>
                            <div class="needs-section">
                                <span class="needs-label">Kebutuhan</span>
                                @foreach($requests as $req)
                                    <div class="need-item">
                                        <span class="need-name">{{ $req->item_name }}</span>
                                        <span class="need-qty">{{ $req->quantity_remaining }} {{ $req->unit }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>

<!-- Modal Meminta -->
<div id="requestModal" class="modal">
    <div class="modal-content">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <h2>Permintaan Bantuan</h2>
        <form action="{{ route('panti.request.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="item_name" placeholder="Contoh: Beras, Baju, dll" required>
            </div>
            <div class="form-group">
                <label>Jumlah yang Dibutuhkan</label>
                <input type="number" name="quantity_needed" placeholder="Masukkan jumlah" required>
            </div>
            <div class="form-group">
                <label>Satuan</label>
                <input type="text" name="unit" placeholder="Contoh: Karung, Pcs, Box" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-submit">Meminta</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('requestModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('requestModal').style.display = 'none';
    }

    function confirmLogout() {
        if (confirm('Apakah anda ingin keluar?')) {
            document.getElementById('logout-form').submit();
        }
    }

    window.onclick = function(event) {
        let modal = document.getElementById('requestModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>

</body>
</html>
