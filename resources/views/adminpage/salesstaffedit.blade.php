<link rel="stylesheet" href="{{asset('lib1/scripts/datatables/css/bootstrap.min.css')}}" id="colors">
@extends('layouts.mastera')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

<link rel="stylesheet" href="{{asset('lib1/scripts/datatables/css/jquery.dataTables.css')}}" id="colors">

    
    <div class="row">
    @if($edit_id > 0)
        <div class="col-lg-12 col-md-12">
            <div class="dashboard-list-box ">
            <h4 class="gray">Business List Using this Coupon Code</h4>
                <div style="border-bottom:1px solid #eee; padding: 20px; background-color:#fff">
                <table id="users" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size: small;">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>No</th>
                            <th>Business</th>
                            <th>Business Name</th>
                            <th>Category</th>
                            <th>Package</th>
                            <th>Monthly Sale</th>
                            <th>Discounted Monthly Sale</th>
                        </tr>
                    </thead>
                </table>
                </div>
            </div>
        </div>
    @endif
        <!-- Profile -->
        <div class="col-lg-8 col-md-12">

            <div class="dashboard-list-box margin-top-20">
                <h4 class="gray">Sales Staff Member Details</h4>
                <div class="dashboard-list-box-static">
                    <form action="{{url('admin/salesstaff/save')}}" method="post" enctype="multipart/form-data" id="register_form">
                        {{csrf_field()}}

                        <div class="my-profile">
                            <input value="{{$edit_id}}" type="hidden" id="edit_id" name="edit_id">

                            <label>Name</label>
                            <input value="{{$name}}" type="text" id="name" name="name" required>

                            <label>Phone</label>
                            <input value="{{$phone}}" type="text" id="phone" name="phone" required>

                            <label>Email</label>
                            <input value="{{$email}}" type="text" id="email" name="email" required>

                            <label>Discount Type</label>
                            <select id="discounttype" name="discounttype">
                                <option value="0" 
                                @if($discounttype == 0)
                                selected
                                @endif
                                >%</option>
                                <option value="1" 
                                @if($discounttype == 1)
                                selected
                                @endif
                                >$</option>
                            </select>

                            <label>Discount</label>
                            <input value="{{$discountprice}}" type="text" id="discountprice" name="discountprice" required>

                            <label>Coupon Code</label>
                            <input value="{{$couponcode}}" type="text" id="couponcode" name="couponcode" required>

                        </div>
                        <span class="help-block">
                            <strong id="register_error" style="color:#f00"></strong>
                        </span>
                        <div class="clearfix"></div>

                        <button class="button margin-top-15" type="button" onclick="checkRegister()">Save</button>
                        <button class="button margin-top-15 gray" type="button" onclick="window.location='{{url('/admin/salesstaff')}}'">Cancel</button>
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
    @if($edit_id > 0)
    $(document).ready(function() {
        oTable = $('#users').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url('/admin/salesstaff/table_getallbusiness') }}?salesid={{$edit_id}}",
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "data" : "b_id",
                    "name" : "b_id",
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [ 1 ],
                    "searchable": false,
                    "orderable": false,
                    "className": "dt-body-center",
                    render: function ( data, type, row, meta ) {
                        pageinfo = oTable.page.info();
                        return meta.row + pageinfo.page * pageinfo.length + 1;
                    }
                },
                {
                    "targets": [ 2 ],
                    "data" : "b_image",
                    "name" : "b_image",
                    "searchable": false,
                    "orderable": false,
                    "visible": false,
                    "className": "dt-body-center",
                    render: function ( data, type, row, meta ) {
                        if (data != null && data != '')
                            path = "{{asset('')}}" + data;
                        else
                            path = "{{asset('images/business.png')}}";
                        return "<img src='"+path+"' style='width:128px; height:71px;' onError=\"this.src = '{{asset('images/business.png')}}'\" />";
                    }
                },
                {
                    "targets": [ 3 ],
                    "data" : "b_title",
                    "name" : "b_title",
                    "searchable": true,
                },
                {
                    "targets": [ 4 ],
                    "data" : "b_category",
                    "name" : "b_category",
                    "searchable": true
                },
                {
                    "targets": [ 5 ],
                    "data" : "package",
                    "name" : "package",
                    "searchable": true
                },
                {
                    "targets": [ 6 ],
                    "data" : "price",
                    "name" : "price",
                    "searchable": true,
                    render: function ( data, type, row, meta ) {
                        return data + "$";
                    }
                },
                {
                    "targets": [ 7 ],
                    "data" : "price",
                    "name" : "discountprice",
                    "searchable": true,
                    render: function ( data, type, row, meta ) {
                        @if($discounttype == 0)
                            return data / 100 * (100 - {{$discountprice}}) + "$";
                        @else
                            if (data == 0) return "0$";
                            return data - {{$discountprice}} + "$";
                        @endif
                    }
                }
            ]
        });
    });
    @endif
    function isNumeric(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
    function checkRegister()
    {
        editid = $("#edit_id").val();
        name = $("#name").val();
        phone = $("#phone").val();
        email = $("#email").val();
        discountprice = $("#discountprice").val();
        couponcode = $("#couponcode").val();

        if (name.length == 0)
        {
            $("#register_error").html("Input Name");
            return;
        }
        if (phone.length == 0)
        {
            $("#register_error").html("Input Phone number");
            return;
        }
        if (email.length == 0)
        {
            $("#register_error").html("Input Email");
            return;
        }
        if (discountprice.length == 0 || !isNumeric(discountprice))
        {
            $("#register_error").html("Input Correct Discount Price");
            return;
        }
        if (couponcode.length == 0)
        {
            $("#register_error").html("Input Coupon Code");
            return;
        }
        if (couponcode.length != 5)
        {
            $("#register_error").html("Coupon Code has to be 5 characters long");
            return;
        }
        $.ajax({
            url: "{{url('/admin/salesstaff/checkregister')}}",
            type: "GET",
            async : true,
            data: "name="+name+"&email="+email+"&couponcode="+couponcode+"&editid="+editid,
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
