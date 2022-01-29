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
  <h2>Enter user details to send sms to</h2>

<form action="{{route('send_message')}}" id="send_message" method="post" enctype="multipart/form-data">
@csrf
  <div class="form-group">
    <label for="from">From/Short Code (readonly field)</label>
    <input type="text" class="form-control" id="from" aria-describedby="fromHelp" value="Mojagate" readonly>
  </div>
  <div class="form-group">
    <label for="recipient">Recipient</label>
    <input type="number" class="form-control" id="recipient" aria-describedby="recipientHelp" placeholder="254748050434">
    <small id="recipientHelp" class="form-text text-muted">enter the sms recievers number, i.e 254748050434.</small>
  </div>
  <div class="form-group">
    <label for="message">Message</label>
    <input type="text" class="form-control" id="message" placeholder="Happy New Year from Mojagate">
  </div> 
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
