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
                <a href="{{url('/admin/categories/edit?edit_id=0')}}"><button class="button" style="padding: 8px 15px; border-radius: 3px; background-color: green; margin-bottom:20px;"><i class="fa fa-plus"></i>&nbsp;Add New Category</button></a>

                <table id="users" class="table table-striped table-bordered" cellspacing="0" width="100%" style="font-size: small;">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>No</th>
                            <th>Image</th>
                            <th>Name</th>
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
            "ajax": "{{ asset('admin/categories/table_getall') }}",
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
                    "data" : "category_photo",
                    "name" : "category_photo",
                    "searchable": false,
                    "orderable": false,
                    "className": "dt-body-center",
                    render: function ( data, type, row, meta ) {
                        if (data != null && data != '')
                            path = "{{asset('')}}" + data;
                        else
                            path = "{{asset('images/uploadimage.png')}}";

                        return "<i class='fa "+data+"'  style='font-size:50px;'></i>";
                    }
                },
                {
                    "targets": [ 3 ],
                    "data" : "categoryname",
                    "name" : "categoryname",
                    "visible": true,
                    "searchable": true
                },
                {
                    "targets": [ 4 ],
                    "searchable": false,
                    "orderable": false,
                    "className": "dt-body-center",
                    render: function ( data, type, row, meta ) {
                        return "<a href='{{url('/admin/categories/edit?edit_id=')}}"+row['id']+"' style='color:green'><i class='fa fa-edit'></i></a>" + "&nbsp;&nbsp;<a href='#' onclick='DeleteCategory("+row['id']+")' style='color: #933'><i class='fa fa-trash'></i></a>";
                    }
                }
            ]
            
        });
    });

    function DeleteCategory(id)
    {
        bootbox.confirm({
            size: 'small',
            title: "Delete Category?",
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
                        url: "{{url('/admin/categories/del')}}",
                        async : true,
                        data: "edit_id="+id,
                        success: function (data) {
                            obj = $.parseJSON(data);
                            toastr.options.timeOut = 2000;
                            if (obj.res == "true")
                            {
                                toastr.success('Delete successfully.', 'Category');
                            }
                            else
                                toastr.error(obj.errmsg, 'Category');

                            oTable.draw();
                        },
                        error: function (e) {
                            toastr.options.timeOut = 2000;
                            toastr.error('Delete failed.', 'Category');
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

