@extends('layouts.app')

@section('content')
<div class="container mx-auto flex justify-center items-center min-h-screen bg-red-50">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-lg rounded-lg p-8 border-t-4 border-red-600">
            <h1 class="text-2xl font-bold text-center mb-6">Login</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('auth.login') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                        required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password"
                        class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                        required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-red-700 text-white font-semibold py-2 rounded-lg hover:bg-red-700 transition">
                    Login
                </button>
            </form>

            <p class="text-center text-gray-600 mt-6">
                Don't have an account? <a href="{{ route('auth.register') }}" class="text-red-600 hover:underline font-semibold">Register here</a>
            </p>
        </div>
    </div>
</div>
@endsection
