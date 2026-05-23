@extends('errors.layout')

@section('title', 'Halaman Tidak Ditemukan')
@section('code', '404')
@section('message', 'Oops! Halaman Tidak Ditemukan')

@section('icon')
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
    </path>
@endsection

@section('description')
    Maaf, URL atau halaman yang Anda cari mungkin telah dihapus, diubah namanya, atau memang tidak pernah ada.
@endsection
