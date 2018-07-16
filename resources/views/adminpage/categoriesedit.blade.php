<link rel="stylesheet" href="{{asset('lib1/scripts/datatables/css/bootstrap.min.css')}}" id="colors">
@extends('layouts.mastera')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

<link rel="stylesheet" href="{{asset('lib1/scripts/datatables/css/jquery.dataTables.css')}}" id="colors">

    <div class="row">
   
        <!-- Profile -->
        <div class="col-lg-8 col-md-12">

            <div class="dashboard-list-box margin-top-20">
                <h4 class="gray">Category Details</h4>
                <div class="dashboard-list-box-static">
                    <form action="{{url('admin/categories/save')}}" method="post" enctype="multipart/form-data" id="register_form">
                        {{csrf_field()}}

                        <div class="my-profile" style="align:center">
                            <label>Category Icon</label>
                            <i class="fa {{$photo}}" id="category_icon" style="font-size:100px;"></i>
                            <input type="text" id="iconpicker" name="iconpicker" value="{{$photo}}" onchange="iconpickerchange()" required/>
                        </div>

                        <div class="my-profile">
                            <input value="{{$edit_id}}" type="hidden" id="edit_id" name="edit_id">

                            <label>Category Name</label>
                            <input value="{{$name}}" type="text" id="name" name="name" required>

                        </div>
                        <span class="help-block">
                            <strong id="register_error" style="color:#f00"></strong>
                        </span>
                        <div class="clearfix"></div>

                        <button class="button margin-top-15" type="button" onclick="checkRegister()">Save</button>
                        <button class="button margin-top-15 gray" type="button" onclick="window.location='{{url('/admin/categories')}}'">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Copyrights -->
        <div class="col-md-12">
            <div class="copyrights">Copyright Edenlinx 2017. All rights reserved.<br>Created by <a href="http://emoceanstudios.com.au" target="_blank" style="color: #f91942;">emoceanstudios.com.au.</a></div>
        </div>

    </div>

<script type="text/javascript">

    $(document).ready(function() {
        $('#iconpicker').iconpicker("#iconpicker");

    });

    function iconpickerchange()
    {
        $("#category_icon").attr("class", "fa " + $('#iconpicker').val());
    }
    
    function checkRegister()
    {
        name = $("#name").val();
        editid = $("#edit_id").val();

        if (name.length == 0)
        {
            $("#register_error").html("Input Category Name");
            return;
        }

        $.ajax({
            url: "{{url('/admin/categories/checkregister')}}",
            type: "GET",
            async : true,
            data: "name="+name+"&editid="+editid,
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $("#register_error").html("Save failed");
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
