@extends('main')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-4">
		<div class="card">
			<div class="card-header">Profile</div>
			<div class="card-body">
            <form action="{{route('user.profile_validation')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <input type="text" name="name" class="form-controll" value="{{Auth::user()->name}}"/>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <input type="text" name="email" class="form-controll" value="{{Auth::user()->email}}"/>
                    @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <input type="password" name="password" class="form-controll" value=""/>
                </div>
                <div class="form-group mb-3">
                    <input type="file" name="user_image" class="form-controll" />
                    @if($errors->has('user_image'))
                        <span class="text-danger">{{ $errors->first('user_image') }}</span>
                    @endif
                    <br/>
                    @if(Auth::user()->user_image != '')
                    <img src="{{asset('images/'. Auth::user()->user_image)}}" width="150" class="img-thumbnail"/>
                    @endif
                    <input type="hidden" name="hidden_user_image" value="{{Auth::user()->user_image}}"/>
                </div>
                <div class="d-grid mx-auto">
                    <button type="submit" class="btn btn-dark btn-block">Save</button>
                </div>
            </form>


            </div>
        </div>
    </div>
</div>

@endsection