@extends('layout.master')

@section('title', 'Weather App')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection

@section('script')
    <script src="{{ asset('js/main.js') }}"></script>
@endsection


@section('content')

    @livewire('dashboard')

@endsection
