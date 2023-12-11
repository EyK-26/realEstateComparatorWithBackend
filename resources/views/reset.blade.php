@extends('layouts.layout')
@section('content')
<h1>Reset Password</h1>
@guest
@isset($email)
<form action="{{ route('password.update') }}" method="post">
    @method('put')
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">
    <label for="password">New password</label>
    <input type="password" name="password" id="password">
    <label for="password_confirmation">Confirm new password</label>
    <input type="password" name="password_confirmation" id="password_confirmation">
    <button type="submit">Reset</button>
</form>
@endisset
@else
<h1>404, not authorized</h1>
@endguest
<ul class="messages">
    @if(session('message_success'))
    <li class="li_message--success">{{ session('message_success') }}</li>
    @endif
    @if(session('message_error'))
    <li class="li_message--error">{{ session('message_error') }}</li>
    @endif
</ul>
<ul class="errors">
    @if (count($errors) > 0)
    @foreach ($errors->all() as $error)
    <li class="li_message">{{ $error }}</li>
    @endforeach
    @endif
</ul>
@endsection