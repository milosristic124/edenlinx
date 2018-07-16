@extends('layouts.master2')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

<link rel="stylesheet" href="{{asset('lib1/scripts/pagination/simplePagination.css')}}" id="colors">


    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="dashboard-list-box margin-top-0">
                <h4 class="gray">Inbox</h4>

                @if(count($messages)>0)
                @foreach($messages as $message)
                <a href="message/{{$message->id}}">
                <div style="border-bottom:1px solid #eee; padding: 20px; background-color:#fff">
                    <div class="my-profile">
                        <table style="width:100%;">
                            <tr>
                                <td style="width: 70px; vertical-align:top">
                                @if($message->b_image != null)
                                <img src="{{asset($message->b_image)}}" alt="" id="profile_img" style="width:50px; height:50px;">
                                @else
                                <img src="{{asset('images/boy-256.png')}}" alt="" id="profile_img" style="width:50px; height:50px;">
                                @endif
                                </td>
                                <td style="width: *; vertical-align:top">
                                    <table style="width: 100%; height:100%;">
                                        <tr><td style="font-weight:800">{{$message->b_title}}&nbsp;&nbsp;
                                        @if($message->direct == 1 && $message->read == 0)
                                        <span class="nav-tag green"  style=" border-radius:50px; padding:0 7px; color:#fff">unread</span>
                                        @endif
                                        </td></tr>
                                        <tr><td style=""><div>{{print_r(strlen($message->content_plain) > 200 ? substr($message->content_plain, 0, 197)."..." : $message->content_plain, true)}}<div></td></tr>
                                    </table>
                                </td>
                                <td style="width: 150px;color:#BBB; text-align:right; vertical-align:top;">{{$message->send_date}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                </a>
                @endforeach
                @endif
               
            </div>

            <div style="margin-top:10px; float: left;" id="pagination"></div>

        </div>


        <!-- Copyrights -->
        <div class="col-md-12">
            <div class="copyrights">Copyright Edenlinx 2017. All rights reserved.<br>Created by <a href="http://emoceanstudios.com.au" target="_blank" style="color: #f91942;">emoceanstudios.com.au.</a></div>
        </div>

    </div>

    <script>
    $(document).ready(function(){
        $("#pagination").pagination({
            items: {{$totalCount}},
            itemsOnPage: {{$perPage}},
            currentPage: {{$curPage}},
            cssStyle: 'light-theme',
            onPageClick: function (pageNumber, event) {
                window.location = "message?page="+pageNumber;
            }
        });
    });
    </script>

@endsection
