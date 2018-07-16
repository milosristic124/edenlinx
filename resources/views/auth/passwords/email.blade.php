@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('lib1/scripts/toastr/toastr.min.css')}}" id="colors">

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Reset Password</div>

                    <div class="panel-body">

                        <div id="password_reest">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4" style="margin-top: 15px;">
                                    <button id="reset_btn" type="button" onclick="onclick_reset()" class="btn btn-primary">
                                        Reset password
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div id="password_result_success" style="display: none;">
                            <h4>Your password is successfully chnaged.<br/><br/>Please check your mail box.</h4>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{asset('lib1/scripts/jquery-2.2.0.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('lib1/scripts/toastr/toastr.min.js')}}"></script>

    <script type="text/javascript">
        function onclick_reset()
        {
            $("#reset_btn").html("Please wait...");
            $("#reset_btn").prop("disabled", true);

            $.ajax({
                type: "GET",
                url: "{{url('/password/sendemail')}}",
                async : true,
                data: "email="+$("#email").val(),
                success: function (data) {
                    obj = $.parseJSON(data);
                    toastr.options.timeOut = 2000;
                    if (obj.res == "true")
                    {
                        $("#password_reest").css("display", "none");
                        $("#password_result_success").css("display", "block");
                    }
                    else
                    {
                        toastr.error(obj.errmsg, 'Reset password');
                        $("#reset_btn").html("Reset password");
                        $("#reset_btn").prop("disabled", false);
                    }
                },
                error: function (e) {
                    toastr.options.timeOut = 2000;
                    toastr.error('Reset failed.', 'Reset password');
                    $("#reset_btn").html("Reset password");
                    $("#reset_btn").prop("disabled", false);
                }
            });
        }
    </script>
@endsection
