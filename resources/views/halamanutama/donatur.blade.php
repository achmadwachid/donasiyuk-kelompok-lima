<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama - Donatur</title>
    <link rel="stylesheet" href="{{ asset('css/halamanutama/donatur.css') }}">
</head>
<body>

<div class="navbar">
    <div class="brand">DonasiYuk</div>
    <div class="menu">
        <a href="{{ route('halamanutama.donatur') }}" class="active">Halaman Utama</a>
        <a href="{{ route('riwayat.donatur') }}">Riwayat</a>
        <a href="{{ route('profil.donatur') }}">Profil</a>
    </div>
    <div style="margin-left: auto; display: flex; align-items: center;">
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

    <form action="{{ route('halamanutama.donatur') }}" method="GET" class="search-container">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <input type="text" name="search" placeholder="Cari nama panti atau kebutuhan..." value="{{ request('search') }}">
    </form>

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
                            <div class="card-actions">
                                <button class="btn-sumbang" onclick="openDonateModal({{ $userId }})">Sumbang</button>
                                @php
                                    $phone = $pantiProfile->phone;
                                    $phone = preg_replace('/[^0-9]/', '', $phone);
                                    if (str_starts_with($phone, '0')) {
                                        $phone = '62' . substr($phone, 1);
                                    }
                                @endphp
                                <a href="https://wa.me/{{ $phone }}" class="btn-pesan" target="_blank">Pesan</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>

<!-- Modal Sumbang -->
<div id="donateModal" class="modal">
    <div class="modal-content">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <h2>Sumbang Barang</h2>
        <form action="{{ route('donatur.donate.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Pilih Barang</label>
                <select name="donation_request_id" id="itemSelect" required>
                    <!-- Options populated by JS -->
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah Sumbangan</label>
                <input type="number" name="quantity_donated" placeholder="Masukkan jumlah" required min="1">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn-submit">Sumbang</button>
            </div>
        </form>
    </div>
</div>

<script>
    const activeRequests = @json($activeRequests);

    function openDonateModal(userId) {
        const requests = activeRequests[userId];
        const select = document.getElementById('itemSelect');
        select.innerHTML = '';
        
        requests.forEach(req => {
            const option = document.createElement('option');
            option.value = req.id;
            option.textContent = `${req.item_name} (Sisa: ${req.quantity_remaining} ${req.unit})`;
            select.appendChild(option);
        });

        document.getElementById('donateModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('donateModal').style.display = 'none';
    }

    function confirmLogout() {
        if (confirm('Apakah anda ingin keluar?')) {
            document.getElementById('logout-form').submit();
        }
    }

    window.onclick = function(event) {
        let modal = document.getElementById('donateModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>

</body>
</html>
