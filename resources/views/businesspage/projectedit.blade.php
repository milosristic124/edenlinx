@extends('layouts.master1')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

<link rel="stylesheet" href="{{asset('lib1/scripts/dropdown/dropdown.min.css')}}" id="colors">
<link rel="stylesheet" href="{{asset('lib1/scripts/dropdown/transition.min.css')}}" id="colors">

    <div class="row">

        <!-- Profile -->
        <div class="col-lg-8 col-md-12">
            <div class="dashboard-list-box margin-top-0">
                <h4 class="gray">Create/Edit Project</h4>
                <div class="dashboard-list-box-static">
                    <form action="{{url('business/saveproject')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        
                        <!-- Details -->
                        <div class="my-profile">
                            <label>Customer</label>
                            <div class="ui fluid search selection dropdown">
                                <input type="hidden" name="u_id">
                                <i class="dropdown icon"></i>
                                <div class="default text">Select Customer</div>
                                <div class="menu">

                                </div>
                           </div>

                            <label>Title</label>
                            <input value="{{$project->id > 0 ? $project->title : ""}}" type="text" id="title" name="title" required>

                            <label>Description</label>
                            <textarea name="description" id="description" cols="30" rows="10">{{$project->id > 0 ? $project->description : ""}}</textarea>
                            
                            <label>Complete in</label>
                            <table><tr style="vertical-align:top">
                                <td><input value="{{$project->id > 0 ? $project->delay_day : ""}}" type="text" id="delay_day" name="delay_day" required></td>
                                <td><label>&nbsp;&nbsp;Days</label></td>
                            </tr></table>

                            <label>Price</label>
                            <table><tr style="vertical-align:top">
                                <td><input value="{{$project->id > 0 ? $project->price : ""}}" type="number" id="price" name="price" required></td>
                                <td><label>&nbsp;&nbsp;AUD</label></td>
                            </tr></table>
                        </div>

                        <!-- Avatar -->
                        <div class="edit-profile-photo" style="margin-top: 30px;">
                            @if(isset($project->image) && $project->image != "")
                                <img src="{{asset($project->image)}}" alt="" id="project_img">
                            @else
                                <img src="{{asset('images/project.png')}}" alt="" id="project_img">
                            @endif
                                <div class="change-photo-btn">
                                    <div class="photoUpload">
                                        <span><i class="fa fa-upload"></i> Upload Image</span>
                                        <input accept="image/*" type="file" class="upload" name="project_image" onchange="load_project(event)" />
                                    </div>
                                </div>
                        </div>
                        <input type="hidden" id="edit_id" name="edit_id" value="{{$project->id}}" />
                        <button class="button margin-top-15" type="submit">Save</button>
                        <a href="../projects/0"><button class="button margin-top-15" style="background-color: #AAA" type="button">Cancel</button></a>
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
    $(document).ready(function(){
        $('.dropdown').dropdown({
            @foreach ($customers as $customer)
            values: [
            {
                name: '{{$customer->email}}',
                value: '{{$customer->id}}',
                @if($project->id > 0 && $project->u_id==$customer->id)
                selected: true
                @endif
            },
            @endforeach
            ]
        });
    });
    </script>

@endsection
