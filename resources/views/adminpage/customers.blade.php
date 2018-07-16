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
                            <th width="40px">Avatar</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created Date</th>
                            <th>Active</th>
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
            "ajax": "{{ url('/admin/customers/table_getall') }}",
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
                    "data" : "userprofile",
                    "name" : "userprofile",
                    "searchable": false,
                    "orderable": false,
                    "className": "dt-body-center",
                    render: function ( data, type, row, meta ) {
                        if (data != null && data != '')
                            path = "{{asset('')}}" + data;
                        else
                            path = "{{asset('images/boy-256.png')}}";
                        return "<img src='"+path+"' style='width:32px; height:32px' />";
                    }
                },
                {
                    "targets": [ 3 ],
                    "data" : "name",
                    "name" : "name",
                    "searchable": true
                },
                {
                    "targets": [ 4 ],
                    "data" : "email",
                    "name" : "email",
                    "searchable": true
                },
                {
                    "targets": [ 5 ],
                    "data" : "created_at",
                    "name" : "created_at",
                    "searchable": false
                },
                {
                    "targets": [ 6 ],
                    "data" : "status",
                    "name" : "status",
                    "className": "dt-body-center",
                    "searchable": false,
                    render: function ( data, type, row, meta ) {
                        if (data == "1")
                            return "<button type=\"button\" class=\"btn btn-xs btn-success\" onclick=\"SetActive(0, "+row['id']+")\">Activate</button>";
                        else if(data == "0")
                            return "<button type=\"button\" class=\"btn btn-xs btn-danger\" onclick=\"SetActive(1, "+row['id']+")\">Suspend</button>";
                    }

                },
                {
                    "targets": [ 7 ],
                    "searchable": false,
                    "orderable": false,
                    "className": "dt-body-center",
                    render: function ( data, type, row, meta ) {
                        return "<a href='{{url('/admin/customers/profile?edit_id=')}}"+row['id']+"' style='color:green'><i class='fa fa-edit'></i></a>"
                    }
                }
            ]
            
        });
    });

    function SetActive(isActive, userId)
    {
        $.ajax({
            type: "GET",
            url: "{{url('/admin/customers/setactive')}}",
            async : true,
            data: "id="+userId+"&bActive="+isActive,
            success: function (data) {
                obj = $.parseJSON(data);
                toastr.options.timeOut = 2000;
                if (obj.res == "true")
                {
                    if (isActive)
                        toastr.success('Activate successfully.', 'Customers');
                    else
                        toastr.success('Suspend successfully.', 'Customers');
                }
                else
                    toastr.error('Activate/Suspend failed.', 'Customers');

                oTable.draw();
            },
            error: function (e) {
                toastr.options.timeOut = 2000;
                toastr.error('Activate/Suspend failed.', 'Customers');
            }
        });
    }
</script>
@endsection

