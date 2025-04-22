@extends('layouts.admin-layout')

@section('title', 'Error')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-red-500 mb-4">500 Server Error</h1>
        <p class="text-gray-400 mb-4">{{ $error ?? 'An unexpected error occurred.' }}</p>
        <a href="{{ route('admin.dashboard') }}"
           class="bg-gradient-to-r from-[#EA2F2F] to-[#5E1313] text-white px-6 py-2 rounded-lg hover:opacity-90 transition duration-150">
            Return to Dashboard
        </a>
    </div>
</div>
@endsection
