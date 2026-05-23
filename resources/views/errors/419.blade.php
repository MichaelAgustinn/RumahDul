@extends('errors.layout')

@section('title', 'Sesi Berakhir')
@section('code', '419')
@section('message', 'Sesi Anda Telah Berakhir')

@section('icon')
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
    </path>
@endsection

@section('description')
    Maaf, halaman ini telah kedaluwarsa karena Anda tidak melakukan aktivitas terlalu lama. Silakan kembali dan muat ulang
    (refresh) halaman sebelumnya.
@endsection
