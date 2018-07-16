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

                <table id="users" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size: small;">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th width="20px">No</th>
                            <th>Business Name</th>
                            <th>Date</th>
                            <th>Review</th>
                            <th>Action</th>
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
            "ajax": "{{ url('/admin/review/table_getall') }}",
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
                    "data" : "b_title",
                    "name" : "b_title",
                    "searchable": true
                },
                {
                    "targets": [ 3 ],
                    "data" : "create_date",
                    "name" : "create_date",
                    "searchable": true
                },
                {
                    "targets": [ 4 ],
                    "data" : "review",
                    "name" : "review",
                    "searchable": true,
                    "orderable": false
                },
                {
                    "targets": [ 5 ],
                    "searchable": false,
                    "orderable": false,
                    "className": "dt-body-center",
                    render: function ( data, type, row, meta ) {
                        return "<a href='/admin/review/getreview?id="+row['id']+"' style='color:green'><i class='fa fa-edit'></i></a>" + "&nbsp;&nbsp;<a href='#' onclick='DeleteReview("+row['id']+")' style='color: #933'><i class='fa fa-trash'></i></a>";
                    }
                }
            ]
        });
    });

    function DeleteReview(userId)
    {
        bootbox.confirm({
            size: 'small',
            title: "Delete Review?",
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
                        url: "{{url('/admin/review/delreview')}}",
                        async : true,
                        data: "id="+userId,
                        success: function (data) {
                            obj = $.parseJSON(data);
                            toastr.options.timeOut = 2000;
                            if (obj.res == "true")
                            {
                                toastr.success('Delete successfully.', 'Review');
                            }
                            else
                                toastr.error('Delete failed.', 'Review');

                            oTable.draw();
                        },
                        error: function (e) {
                            toastr.options.timeOut = 2000;
                            toastr.error('Delete failed.', 'Review');
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

