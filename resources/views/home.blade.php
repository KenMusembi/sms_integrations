@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
@if (session('status'))
<div class="alert alert-success" role="alert">
  {{ session('status') }}
</div>
@endif
@if(session()->has('success'))
<div class="alert alert-success text-center">
  {{ session()->get('success') }}
</div>
@endif

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">



          <div class="container">
            <h2>SMS Message History</h2>

            <table class="table">
              <tr>
                <td>Id</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>City Name</td>
                <td>Date</td>
              </tr>
              @foreach ($records as $record)
              <tr>
                <td>{{ $record->id }}</td>
                <td>{{ $record->status }}</td>
                <td>{{ $record->recipient }}</td>
                <td>{{ $record->message }}</td>
                <td>{{ $record->date_sent }}</td>
              </tr>
              @endforeach
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection