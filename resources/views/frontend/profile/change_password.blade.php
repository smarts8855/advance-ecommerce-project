@extends('frontend.main_master')
@section('content')

<div class="body-content">
    <div class="container">
        <div class="row">
            @include('frontend.common.user_sidebar')

            <div class="col-md-2">

            </div> <!-- // end col md-2 -->

            <div class="col-md-6">
                <div class="card">
                    <h3 class="text-center">Change Password</h3>

                    <div class="card-body">
                        <form action="{{ route('user.password.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">Current Password </label>
                                <input type="password" class="form-control " id="current_password" name="oldpassword" >
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">New Password  </label>
                                <input type="password" class="form-control " id="password"  name="password" >
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">Confirm Password </label>
                                <input type="password" class="form-control" id="password_confirmation"  name="password_confirmation" >
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger">Update</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div> <!-- // end col md-2 -->
        </div> <!-- // end row -->
    </div>
</div>

@endsection
