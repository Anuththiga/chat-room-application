@extends('main')

@section('content')

<div class="card">
    <div class="card-header">Dashboard</div>
    <div class="card-body">
        You are Logged in Dashboard...
    </div>
</div>

@endsection

<script>

var conn = new WebSocket('ws://127.0.0.1:8090/?token={{ auth()->user()->token }}');
conn.onopen = function(e){
    console.log("Connection establised!");

};

conn.onmessage = function(e){

};

</script>