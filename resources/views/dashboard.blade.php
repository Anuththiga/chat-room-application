@extends('main')

@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header"><b>Connected User</b></div>
            <div class="card-body">

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col col-md-6"><b>Chat Area</b></div>
                    <div class="col col-md-6"></div>
                </div>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card" style="height: 255px; overflow-y: scroll;">
            <div class="card-header">

            </div>
            <div class="card-body">
                <div id="search_people_area" class="mt-3"></div>

            </div>
        </div>
        <br/>
        <div class="card" style="height: 255px; overflow-y: scroll;">
            <div class="card-header"><b>Notification</b></div>
            <div class="card-body">
                <ul class="list-group">

                </ul>

            </div>
        </div>
    </div>

</div>

@endsection

<script>

var conn = new WebSocket('ws://127.0.0.1:8090/?token={{ auth()->user()->token }}');

var from_user_id = "{{ Auth::user()->id }}";
var to_user_id = "";

conn.onopen = function(e){
    console.log("Connection establised!");
    load_unconnected_user(from_user_id);

};

conn.onmessage = function(e){
    var data = JSON.parse(e.data);

    if(data.response_load_unconnected_user)
    {
        var html = '';

        if(data.data.length > 0)
        {
           
            html += '<ul class="list-group">';
            for(var count = 0; count < data.data.length; count++)
            {
                user_image = null;

                if(data.data[count].user_image != null)
                {
                    user_image = `<img src="{{ asset("images/") }}"/`+data.data[count].user_image+ ` width="40" class="rounded-circle" />`;
                }
                else
                {
                    user_image = `<img src="{{ asset('images/no-image.png') }}"
                    width="40" class="rounded-circle" />`;
                }
               
                console.log(data.data[count].name);
                html += `
                <li class="list-group-item">
                    <div class="row">
                        <div class="col col-9">`+user_image+`&nbsp;`+data.data[count].name+`</div>
                        <div class="col col-3">
                            <button type="button" name="send_request" class="btn 
                                btn-primary btn-sm float-end"><i class="fas fa-paper-plane"></i></button>    
                        </div>
                    </div>
                </li>

                    `;
            }
            html += '</ul>'
        }
        else
        {
            html = 'No User Foune'
        }

        document.getElementById('search_people_area').innerHTML = html;
    }
};

function load_unconnected_user(from_user_id)
{
    var data = {
        from_user_id : from_user_id,
        type : 'request_load_unconnected_user'
    };

    conn.send(JSON.stringify(data));
}

</script>