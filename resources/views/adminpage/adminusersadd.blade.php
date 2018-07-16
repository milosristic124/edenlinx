@extends('layouts.mastera')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

    <div class="row">

        <!-- Profile -->
        <div class="col-lg-8 col-md-12">
            <div class="dashboard-list-box margin-top-0">
                <h4 class="gray">Account Details</h4>
                <div class="dashboard-list-box-static">
                    <form action="{{url('admin/adminusersadd/save')}}" method="post" enctype="multipart/form-data" id="register_form">
                        {{csrf_field()}}
                        <div class="my-profile">

                            <label>Email</label>
                            <input value="" type="email" id="email" name="email" required>

                            <label>New Password</label>
                            <input type="password" id="newpwd" name="newpwd" value="" required />
                        
                            <label>Confirm New Password</label>
                            <input type="password" id="confirmpwd" name="newpwd_confirmation" required />
                        
                            <span class="help-block">
                                <strong id="register_error" style="color:#f00"></strong>
                            </span>
                            <div class="clearfix"></div>

                            <button class="button margin-top-15" type="button" onclick="checkRegister()">Create Admin</button>
                            <button class="button margin-top-15 gray" type="button" onclick="window.location='{{url('/admin/adminusers')}}'">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Copyrights -->
        <div class="col-md-12">
            <div class="copyrights">Copyright Edenlinx 2017. All rights reserved.<br>Created by <a href="http://emoceanstudios.com.au" target="_blank" style="color: #f91942;">emoceanstudios.com.au.</a></div>
        </div>

    </div>

<script>
    function checkRegister()
    {
        email = $("#email").val();
        password = $("#newpwd").val();
        password1 = $("#confirmpwd").val();

        if (email.length == 0)
        {
            $("#register_error").html("Input Email");
            return;
        }
        if (password.length < 6)
        {
            $("#register_error").html("Password must be at least 6 characters");
            return;
        }
        if (password != password1)
        {
            $("#register_error").html("Please type password correctly");
            return;
        }

        $.ajax({
            url: "{{url('/check/register')}}",
            type: "GET",
            async : true,
            data: "name=&email="+email,
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#register_error").html("Error in register");
            },
            success: function (data) {
                obj = $.parseJSON(data);
                if (obj.res == "success")
                {
                    $("#register_form").submit();
                }
                else
                {
                    $("#register_error").html(obj.status);
                }
            }
        });
    }
</script>
@endsection
