@extends('layouts.app')
@section('title', 'Login')

@section('content')
<main class="kotak">
    <h1 class="login-title">Form Login</h1>

    @if ($errors->any())
        <p style="color:red;">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <input type="submit" value="Login">
    </form>
</main>
@endsection