<link rel="stylesheet" href="{{asset('lib1/scripts/datatables/css/bootstrap.min.css')}}" id="colors">
@extends('layouts.mastera')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

<link rel="stylesheet" href="{{asset('lib1/scripts/datatables/css/jquery.dataTables.css')}}" id="colors">

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
                            <th>Image1 (Click for download)</th>
                            <th>Image2 (Click for download)</th>
                            <th>Image3 (Click for download)</th>
                            <th>Brief Description</th>
                            <th>Submit Date</th>
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
            "ajax": "{{ url('/admin/professionalheader/table_getall') }}",
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
                    "searchable": true,
                    "orderable": true
                },
                {
                    "targets": [ 3 ],
                    "data" : "image1",
                    "name" : "image1",
                    "searchable": true,
                    "orderable": false,
                    render: function ( data, type, row, meta ) {
                        if (data != null && data != '')
                            path = "{{asset('')}}" + data;
                        else
                            path = "{{asset('images/business_header.jpg')}}";
                        return "<a href='"+path+"' download><img src='"+path+"' onError=\"this.src = '{{asset('images/business_header.jpg')}}'\" /></a>";
                    }
                },
                {
                    "targets": [ 4 ],
                    "data" : "image2",
                    "name" : "image2",
                    "searchable": true,
                    "orderable": false,
                    render: function ( data, type, row, meta ) {
                        if (data != null && data != '')
                            path = "{{asset('')}}" + data;
                        else
                            path = "{{asset('images/business_header.jpg')}}";
                        return "<a href='"+path+"' download><img src='"+path+"' onError=\"this.src = '{{asset('images/business_header.jpg')}}'\" /></a>";
                    }
                },
                {
                    "targets": [ 5 ],
                    "data" : "image3",
                    "name" : "image3",
                    "searchable": true,
                    "orderable": false,
                    render: function ( data, type, row, meta ) {
                        if (data != null && data != '')
                            path = "{{asset('')}}" + data;
                        else
                            path = "{{asset('images/business_header.jpg')}}";
                        return "<a href='"+path+"' download><img src='"+path+"'  onError=\"this.src = '{{asset('images/business_header.jpg')}}'\" /></a>";
                    }
                },
                {
                    "targets": [ 6 ],
                    "data" : "description",
                    "name" : "description",
                    "searchable": true,
                    "orderable": false
                },
                {
                    "targets": [ 7 ],
                    "data" : "create_at",
                    "name" : "create_at",
                    "searchable": true,
                    "orderable": true
                }
            ]
        });
    });

</script>
@endsection

