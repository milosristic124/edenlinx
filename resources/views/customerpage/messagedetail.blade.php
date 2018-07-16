@extends('layouts.master2')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

<link rel="stylesheet" href="{{asset('lib1/scripts/summernote/bootstrap.css')}}" id="colors">
<link rel="stylesheet" href="{{asset('lib1/scripts/summernote/summernote.css')}}" id="colors">

    <div class="row">

        <div class="col-lg-7 col-md-12">
            <div class="dashboard-list-box margin-top-0">
                <h4 class="gray">Message Detail</h4>
                @if(count($messages)>0)
                @foreach($messages as $message)

                <div class="dashboard-list-box-static;" style="padding:0px;">
                <div style="border-bottom:1px solid #eee; padding: 20px; background-color:#fff">
                    <div class="my-profile">
                        <table style="width:100%;">
                            <tr>
                                
                                <td style="width: 70px; vertical-align:top">
                                @if($message->direct == 0)
                                    @if($customeravatar != null)
                                    <img src="{{asset($customeravatar)}}" alt="" id="profile_img" style="width:50px; height:50px;">
                                    @else
                                    <img src="{{asset('images/boy-256.png')}}" alt="" id="profile_img" style="width:50px; height:50px;">
                                    @endif
                                @else
                                    @if($businessavatar != null)
                                    <img src="{{asset($businessavatar)}}" alt="" id="profile_img" style="width:50px; height:50px;">
                                    @else
                                    <img src="{{asset('images/boy-256.png')}}" alt="" id="profile_img" style="width:50px; height:50px;">
                                    @endif
                                @endif
                                </td>
                                <td style="width: *; vertical-align:top">
                                    <table style="width: 100%; height:100%">
                                        @if($message->direct == 0)
                                        <tr><td style="font-weight:800">{{$customername}}&nbsp;&nbsp;
                                        @else
                                        <tr><td style="font-weight:800">{{$businessname}}&nbsp;&nbsp;
                                        @endif
                                        </td></tr>
                                        <tr><td style="width: 90px;color:#BBB;padding-top:5px; padding-bottom:10px;">{{$message->send_date}}</td></tr>
                                        <tr><td style="padding-top:20px;"><div>
                                        @php
                                        print_r($message->content)
                                        @endphp
                                        <div></td></tr>
                                        @if($message->image != null && $message->image != "")
                                        <tr><td style="padding-top:20px;"><img src="{{asset($message->image)}}" alt="" style="max-width:80%; height:auto"></td></tr>
                                        @endif
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                    
                </div>
                @endforeach
                @endif

            </div>
        </div>

        <!-- Message -->
        <div class="col-lg-5 col-md-12">
            <div class="dashboard-list-box margin-top-0">
                <h4 class="gray">Send Message</h4>
                <div class="dashboard-list-box-static">
                    <form action="{{url('customer/sendmessage')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <!-- Details -->
                        <input type="hidden" name="b_id" value="{{$messages[0]->b_id}}" />
                        <input type="hidden" name="parent_id" value="{{$messages[0]->parent_id}}" />
                        <div class="my-profile">
                            <label class="margin-top-0">Message</label>
                            <textarea id="message_content" name="message_content"></textarea>
                        </div>
                        <div class="edit-profile-photo" style="margin-top: 30px;">
                            <img src="{{asset('images/uploadimage.png')}}" alt="" id="project_img">
                            <div class="change-photo-btn">
                                <div class="photoUpload">
                                    <span><i class="fa fa-upload"></i> Upload Image</span>
                                    <input accept="image/*" type="file" class="upload" name="project_image" onchange="load_project(event)" />
                                </div>
                            </div>
                        </div>
                        <button class="button margin-top-15" type="submit">Send Message</button>
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
    /*
    $(document).ready(function () {
        $("#message_content").summernote({
            height: '210px',
            maximumImageFileSize: 524288,
            onpaste: function (e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                document.execCommand('insertText', false, bufferText);
            }
        });

        $("#message_content").on('summernote.blur', function () {
            $('#message_content').html($('#message_content').summernote('code'));
        });
    });
    */
</script>

@endsection
