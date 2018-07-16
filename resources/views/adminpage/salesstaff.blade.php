<link rel="stylesheet" href="{{asset('lib1/scripts/datatables/css/bootstrap.min.css')}}" id="colors">
@extends('layouts.mastera')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

<link rel="stylesheet" href="{{asset('lib1/scripts/datatables/css/jquery.dataTables.css')}}" id="colors">
<link rel="stylesheet" href="{{asset('lib1/scripts/toastr/toastr.min.css')}}" id="colors">

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="dashboard-list-box ">
                <div style="border-bottom:1px solid #eee; padding: 20px; background-color:#fff">
                <a href="{{url('/admin/salesstaff/edit?edit_id=0')}}"><button class="button" style="padding: 8px 15px; border-radius: 3px; background-color: green; margin-bottom:20px;"><i class="fa fa-plus"></i>&nbsp;Add New Sales Staff Member</button></a>

                <table id="users" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size: small;">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>No</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>DiscountType</th>
                            <th>Discount</th>
                            <th>Coupon Code</th>
                            <th>Total Monthly Sale</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                </table>
            </div>
            </div>

        </div>


        <!-- Copyrights -->
        <div class="col-md-12">
            <div class="copyrights" style="display: inline-block;">Copyright Edenlinx 2017. All rights reserved.<br>Created by <a href="http://emoceanstudios.com.au" target="_blank" style="color: #f91942;">emoceanstudios.com.au.</a></div>
        </div>

    </div>


<script type="text/javascript">
    $(document).ready(function() {
        oTable = $('#users').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ asset('admin/salesstaff/table_getall') }}",
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "data" : "id",
                    "name" : "id",
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [ 1 ],
                    "orderable": false,
                    "searchable": false,
                    render: function ( data, type, row, meta ) {
                        pageinfo = oTable.page.info();
                        return meta.row + pageinfo.page * pageinfo.length + 1;
                    }
                },
                {
                    "targets": [ 2 ],
                    "data" : "membername",
                    "name" : "membername",
                    "visible": true,
                    "searchable": true
                },
                {
                    "targets": [ 3 ],
                    "data" : "phone",
                    "name" : "phone",
                    "visible": true,
                    "searchable": true
                },
                {
                    "targets": [ 4 ],
                    "data" : "email",
                    "name" : "email",
                    "visible": true,
                    "searchable": true
                },
                {
                    "targets": [ 5 ],
                    "data" : "discounttype",
                    "name" : "discounttype",
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [ 6 ],
                    "data" : "discountprice",
                    "name" : "discountprice",
                    "visible": true,
                    "searchable": false,
                    render: function ( data, type, row, meta ) {
                        return data + "&nbsp;" + (row['discounttype'] == 0 ? "%" : "$");
                    }
                },
                {
                    "targets": [ 7 ],
                    "data" : "couponcode",
                    "name" : "couponcode",
                    "visible": true,
                    "searchable": true,
                },
                {
                    "targets": [ 8 ],
                    "data" : "monthlysale",
                    "name" : "monthlysale",
                    "visible": true,
                    "searchable": true,
                    render: function ( data, type, row, meta ) {
                        return (data != null ? data : "0") + "$";
                    }
                },
                {
                    "targets": [ 9 ],
                    "searchable": false,
                    "orderable": false,
                    "className": "dt-body-center",
                    render: function ( data, type, row, meta ) {
                        return "<a href='{{url('/admin/salesstaff/edit?edit_id=')}}"+row['id']+"' style='color:green'><i class='fa fa-edit'></i></a>" + "&nbsp;&nbsp;<a href='#' onclick='DeleteSalesstaff("+row['couponcode']+")' style='color: #933'><i class='fa fa-trash'></i></a>";
                    }
                }
            ]
            
        });
    });

    function DeleteSalesstaff(couponCode)
    {
        bootbox.confirm({
            size: 'small',
            title: "Delete Sales Staff Member?",
            message: "Are you sure?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Delete'
                }
            },
            callback: function(result){ 
                if (result == true)
                {
                    $.ajax({
                        type: "GET",
                        url: "{{url('/admin/salesstaff/del')}}",
                        async : true,
                        data: "couponcode="+couponCode,
                        success: function (data) {
                            obj = $.parseJSON(data);
                            toastr.options.timeOut = 2000;
                            if (obj.res == "true")
                            {
                                toastr.success('Delete successfully.', 'Sales Staff');
                            }
                            else
                                toastr.error(obj.errmsg, 'Sales Staff');

                            oTable.draw();
                        },
                        error: function (e) {
                            toastr.options.timeOut = 2000;
                            toastr.error('Delete failed.', 'Sales Staff');
                        }
                    });
                }
            }
        }).find('.modal-content').css({
            'margin-top': '100px'
        });
    }
</script>
@endsection

