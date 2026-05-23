@extends('errors.layout')

@section('title', 'Kesalahan Server')
@section('code', '500')
@section('message', 'Terjadi Kesalahan Server')

@section('icon')
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
@endsection

@section('description')
    Maaf, sistem kami sedang mengalami gangguan internal. Tim teknis kami telah diberitahu dan sedang memperbaikinya.
@endsection
