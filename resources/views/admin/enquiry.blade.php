@extends('layouts.layout')

@section('content')
@auth

@if($user->can('admin') && isset($enquiry))
<h1>See Enquiry Details</h1>
<textarea resize="none" disabled id="enquiry">{{ $enquiry->message }}</textarea>
@isset($offer_id)
<h2>From</h2>
@isset($client)
<table>
    <thead>
        <tr>
            <th>User ID</th>
            <th>User Name</th>
            <th>User Email</th>
            <th>Product ID</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $client->id }}</td>
            <td>{{ $client->name }}</td>
            <td>{{ $client->email }}</td>
            <td><a href={{ "/prod_view/$offer_id" }} target="_blank">{{ $offer_id }}</a></td>
        </tr>
    </tbody>
</table>
@endisset
@endisset

@isset($enquiry_id)
<a class="contact_user" href={{ route('enquiry.answer', compact('enquiry_id'))}}>Contact User</a>
@endisset

@else
<p>404 not authorized</p>
@endif

@else
<p>Please login as admin to see the page.</p>
@endauth

@endsection