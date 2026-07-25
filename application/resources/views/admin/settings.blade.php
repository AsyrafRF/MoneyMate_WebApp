@extends('layouts.admin')

@section('title', 'Pengaturan Web')

@section('content')
{{-- Alert untuk pesan sukses --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Nama Bank / Platform E-Wallet</label>
        <input type="text" name="bank_name" class="form-control" value="{{ $settings['bank_name'] ?? 'SEABANK' }}">
    </div>

    <div class="mb-3">
        <label>Atas Nama</label>
        <input type="text" name="bank_account_name" class="form-control" value="{{ $settings['bank_account_name'] ?? 'ASYRAF RAIS FADHIL' }}">
    </div>

    <div class="mb-3">
        <label>Nomor Rekening / No E-Wallet</label>
        <input type="text" name="bank_account_number" class="form-control" value="{{ $settings['bank_account_number'] ?? '901396857636' }}" inputmode="numeric" pattern="[0-9]*">
    </div>

    <div class="mb-3">
        <label>Nomor Whatsapp</label>
        <input type="tel" name="wa_number" class="form-control" value="{{ $settings['wa_number'] ?? '6282172437617' }}" pattern="[0-9]{10,15}">
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>

</form>

@endsection