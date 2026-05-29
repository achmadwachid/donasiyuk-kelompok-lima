<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Donasi - Panti</title>
    <link rel="stylesheet" href="{{ asset('css/riwayat/panti.css') }}">
</head>
<body>

<div class="navbar">
    <div class="brand">DonasiYuk</div>
    <div class="menu">
        <a href="{{ route('halamanutama.panti') }}">Halaman Utama</a>
        <a href="{{ route('riwayat.panti') }}" class="active">Riwayat</a>
        <a href="{{ route('profil.panti') }}">Profil</a>
    </div>
    <div style="margin-left: auto; display: flex; align-items: center;">
        <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
            @csrf
        </form>
        <button class="btn-logout-nav" onclick="confirmLogout()">Logout</button>
    </div>
</div>

<div class="container">
    <div class="grid">
        @foreach($donations as $donation)
            <div class="card">
                <div class="card-top">
                    <div class="card-date">{{ $donation->created_at->format('d M Y') }}</div>
                    <div class="card-label">Nama Pengirim: {{ $donation->user->name }}</div>
                    <div class="card-item-box">
                        {{ $donation->donationRequest->item_name }}: {{ $donation->quantity_donated }} {{ $donation->donationRequest->unit }}
                    </div>
                </div>
                
                <div class="card-bottom">
                    @if($donation->status === 'sudah diterima')
                        <div class="status-badge">Selesai</div>
                    @else
                        <form action="{{ route('panti.donation.confirm', $donation->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-diterima">Diterima</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function confirmLogout() {
        if (confirm('Apakah anda ingin keluar?')) {
            document.getElementById('logout-form').submit();
        }
    }
</script>

</body>
</html>
