@extends('layouts.master2')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="dashboard-list-box margin-top-0">
                <h4 class="gray">
                @if($status == 0)
                New Projects
                @elseif($status == 1)
                Active Projects
                @elseif($status == 2)
                Pending Projects
                @else
                Complete Projects
                @endif
                </h4>

                @if(count($projects)>0)
                @foreach($projects as $project)
                <div style="border-bottom:1px solid #eee; padding: 30px; background-color:#fff">
                    <div class="">
                        <table style="width:100%;">
                            <tr>
                                <td style="width: 80px; vertical-align:top">
                                @if($project->business->b_image != null && $project->business->b_image != "")
                                <img src="{{asset($project->business->b_image)}}" alt="" id="profile_img" style="width:50px; height:50px;">
                                @else
                                <img src="{{asset('images/boy-256.png')}}" alt="" id="profile_img" style="width:50px; height:50px;">
                                @endif
                                </td>
                                <td style="width: *">
                                    <table style="width: 100%">
                                        <tr><td style="font-weight:800; font-size: 22px;">{{$project->title}}</td></tr>
                                        <tr><td style="padding-top:10px;color:#999"><b>Business :</b> {{$project->business->b_title}}</td></tr>
                                        <tr><td style="padding-top:10px;color:#999"><b>Create :</b> {{$project->create_date}}</td></tr>
                                        <tr><td style="padding-top:10px;color:#999"><b>Complete in :</b> {{$project->delay_day}} days</td></tr>
                                        <tr><td style="padding-top:10px;color:#999"><b>Price :</b> {{$project->price}} AUD</td></tr>
                                        <tr><td style="padding-top:30px;font-weight:800">Description</td></tr>
                                        <tr><td style="padding-top:10px;"><textarea class="proj_textarea" readonly="readonly" style="border: 0px solid; padding:0px; box-shadow:none; overflow:hidden; min-height: 30px; resize:none; " onfocus="autosize(this)">{{ $project->description }}</textarea></td></tr>
                                        @if ($project->image != null && $project->image != "")
                                            <tr><td style=""><img src="{{asset($project->image)}}" alt="" id="profile_img" style="max-width: 100%; height:auto"></td></tr>
                                        @endif
                                        <tr><td style="padding-top:30px; text-align: left;">
                                        @if($status == 0)
                                            <a href="../projectaccept/{{$project->id}}"><button class="button" style="padding: 8px 15px; border-radius: 3px; background-color: green"><i class="fa fa-check"></i>&nbsp;Accept this project</button></a>
                                        @elseif($status == 1)
                                            <button class="button disabled" style="padding: 8px 15px; border-radius: 3px; background-color: gray"><i class="fa fa-gears"></i>&nbsp;Processing...</button>
                                        @elseif($status == 2)
                                            <form id="add-comment" action="{{url('customer/projectcomplete')}}" method="post" class="add-comment">
                                                {{csrf_field()}}
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <!-- Leave Rating -->
                                                        <label><b>Rating:</b></label>
                                                        <div class="clearfix"></div>
                                                        
                                                        <div class="leave-rating margin-top-10 margin-bottom-10">
                                                            <input type="radio" name="com_rating_{{$project->id}}" id="com_rating_{{$project->id}}-1" value="5"/>
                                                            <label for="com_rating_{{$project->id}}-1" class="fa fa-star"></label>
                                                            <input type="radio" name="com_rating_{{$project->id}}" id="com_rating_{{$project->id}}-2" value="4"/>
                                                            <label for="com_rating_{{$project->id}}-2" class="fa fa-star"></label>
                                                            <input type="radio" name="com_rating_{{$project->id}}" id="com_rating_{{$project->id}}-3" value="3"/>
                                                            <label for="com_rating_{{$project->id}}-3" class="fa fa-star"></label>
                                                            <input type="radio" name="com_rating_{{$project->id}}" id="com_rating_{{$project->id}}-4" value="2"/>
                                                            <label for="com_rating_{{$project->id}}-4" class="fa fa-star"></label>
                                                            <input type="radio" name="com_rating_{{$project->id}}" id="com_rating_{{$project->id}}-5" value="1"/>
                                                            <label for="com_rating_{{$project->id}}-5" class="fa fa-star"></label>
                                                        </div>
                                                        <label style="margin-top:10px;">&nbsp;&nbsp;&nbsp;Communication</label>
                                                        <div class="clearfix"></div>
                                                        <div class="leave-rating margin-bottom-10">
                                                            <input type="radio" name="qlt_rating_{{$project->id}}" id="qlt_rating_{{$project->id}}-1" value="5"/>
                                                            <label for="qlt_rating_{{$project->id}}-1" class="fa fa-star"></label>
                                                            <input type="radio" name="qlt_rating_{{$project->id}}" id="qlt_rating_{{$project->id}}-2" value="4"/>
                                                            <label for="qlt_rating_{{$project->id}}-2" class="fa fa-star"></label>
                                                            <input type="radio" name="qlt_rating_{{$project->id}}" id="qlt_rating_{{$project->id}}-3" value="3"/>
                                                            <label for="qlt_rating_{{$project->id}}-3" class="fa fa-star"></label>
                                                            <input type="radio" name="qlt_rating_{{$project->id}}" id="qlt_rating_{{$project->id}}-4" value="2"/>
                                                            <label for="qlt_rating_{{$project->id}}-4" class="fa fa-star"></label>
                                                            <input type="radio" name="qlt_rating_{{$project->id}}" id="qlt_rating_{{$project->id}}-5" value="1"/>
                                                            <label for="qlt_rating_{{$project->id}}-5" class="fa fa-star"></label>
                                                        </div>
                                                        <label style="margin-top:0px;">&nbsp;&nbsp;&nbsp;Quality</label>
                                                        <div class="clearfix"></div>
                                                        <div class="leave-rating margin-bottom-10">
                                                            <input type="radio" name="spd_rating_{{$project->id}}" id="spd_rating_{{$project->id}}-1" value="5"/>
                                                            <label for="spd_rating_{{$project->id}}-1" class="fa fa-star"></label>
                                                            <input type="radio" name="spd_rating_{{$project->id}}" id="spd_rating_{{$project->id}}-2" value="4"/>
                                                            <label for="spd_rating_{{$project->id}}-2" class="fa fa-star"></label>
                                                            <input type="radio" name="spd_rating_{{$project->id}}" id="spd_rating_{{$project->id}}-3" value="3"/>
                                                            <label for="spd_rating_{{$project->id}}-3" class="fa fa-star"></label>
                                                            <input type="radio" name="spd_rating_{{$project->id}}" id="spd_rating_{{$project->id}}-4" value="2"/>
                                                            <label for="spd_rating_{{$project->id}}-4" class="fa fa-star"></label>
                                                            <input type="radio" name="spd_rating_{{$project->id}}" id="spd_rating_{{$project->id}}-5" value="1"/>
                                                            <label for="spd_rating_{{$project->id}}-5" class="fa fa-star"></label>
                                                        </div>
                                                        <label style="margin-top:0px;">&nbsp;&nbsp;&nbsp;Speed</label>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                                <input name="b_id" type="hidden" value="{{$project->b_id}}"/>
                                                <input name="p_id" type="hidden" value="{{$project->id}}"/>
                                                <input name="p_title" type="hidden" value="{{$project->title}}"/>

                                                <!-- Review Comment -->

                                                <div class="row col-md-6" style="margin-top:20px;">
                                                    <label><b>Review:</b></label>
                                                    <textarea name="review" rows="1" style="min-height:180px; height:180px;" required></textarea>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="row col-md-6">
                                                <button class="button" style="padding: 8px 15px; border-radius: 3px; background-color: green"><i class="fa fa-check"></i>&nbsp;Approve</button>
                                                </div>
                                            </form>
                                        @elseif($status ==3)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- Leave Rating -->
                                                    <label><b>Rating:</b></label>
                                                    <div class="clearfix"></div>
                                                    
                                                    <div class="leave-rating margin-top-10 margin-bottom-10">
                                                        <input type="radio" name="com_rating_{{$project->id}}" id="com_rating_{{$project->id}}-1" value="5" {{$project->review->communication == 5 ? 'checked' : ''}}/>
                                                        <label for="com_rating_{{$project->id}}-1" class="fa fa-star"></label>
                                                        <input type="radio" name="com_rating_{{$project->id}}" id="com_rating_{{$project->id}}-2" value="4" {{$project->review->communication == 4 ? 'checked' : ''}}/>
                                                        <label for="com_rating_{{$project->id}}-2" class="fa fa-star"></label>
                                                        <input type="radio" name="com_rating_{{$project->id}}" id="com_rating_{{$project->id}}-3" value="3" {{$project->review->communication == 3 ? 'checked' : ''}}/>
                                                        <label for="com_rating_{{$project->id}}-3" class="fa fa-star"></label>
                                                        <input type="radio" name="com_rating_{{$project->id}}" id="com_rating_{{$project->id}}-4" value="2" {{$project->review->communication == 2 ? 'checked' : ''}}/>
                                                        <label for="com_rating_{{$project->id}}-4" class="fa fa-star"></label>
                                                        <input type="radio" name="com_rating_{{$project->id}}" id="com_rating_{{$project->id}}-5" value="1" {{$project->review->communication == 1 ? 'checked' : ''}}/>
                                                        <label for="com_rating_{{$project->id}}-5" class="fa fa-star"></label>
                                                    </div>
                                                    <label style="margin-top:10px;">&nbsp;&nbsp;&nbsp;Communication</label>
                                                    <div class="clearfix"></div>
                                                    <div class="leave-rating margin-bottom-10">
                                                        <input type="radio" name="qlt_rating_{{$project->id}}" id="qlt_rating_{{$project->id}}-1" value="5" {{$project->review->quality == 5 ? 'checked' : ''}}/>
                                                        <label for="qlt_rating_{{$project->id}}-1" class="fa fa-star"></label>
                                                        <input type="radio" name="qlt_rating_{{$project->id}}" id="qlt_rating_{{$project->id}}-2" value="4" {{$project->review->quality == 4 ? 'checked' : ''}}/>
                                                        <label for="qlt_rating_{{$project->id}}-2" class="fa fa-star"></label>
                                                        <input type="radio" name="qlt_rating_{{$project->id}}" id="qlt_rating_{{$project->id}}-3" value="3" {{$project->review->quality == 3 ? 'checked' : ''}}/>
                                                        <label for="qlt_rating_{{$project->id}}-3" class="fa fa-star"></label>
                                                        <input type="radio" name="qlt_rating_{{$project->id}}" id="qlt_rating_{{$project->id}}-4" value="2" {{$project->review->quality == 2 ? 'checked' : ''}}/>
                                                        <label for="qlt_rating_{{$project->id}}-4" class="fa fa-star"></label>
                                                        <input type="radio" name="qlt_rating_{{$project->id}}" id="qlt_rating_{{$project->id}}-5" value="1" {{$project->review->quality == 1 ? 'checked' : ''}}/>
                                                        <label for="qlt_rating_{{$project->id}}-5" class="fa fa-star"></label>
                                                    </div>
                                                    <label style="margin-top:0px;">&nbsp;&nbsp;&nbsp;Quality</label>
                                                    <div class="clearfix"></div>
                                                    <div class="leave-rating margin-bottom-10">
                                                        <input type="radio" name="spd_rating_{{$project->id}}" id="spd_rating_{{$project->id}}-1" value="5" {{$project->review->speed == 5 ? 'checked' : ''}}/>
                                                        <label for="spd_rating_{{$project->id}}-1" class="fa fa-star"></label>
                                                        <input type="radio" name="spd_rating_{{$project->id}}" id="spd_rating_{{$project->id}}-2" value="4" {{$project->review->speed == 4 ? 'checked' : ''}}/>
                                                        <label for="spd_rating_{{$project->id}}-2" class="fa fa-star"></label>
                                                        <input type="radio" name="spd_rating_{{$project->id}}" id="spd_rating_{{$project->id}}-3" value="3" {{$project->review->speed == 3 ? 'checked' : ''}}/>
                                                        <label for="spd_rating_{{$project->id}}-3" class="fa fa-star"></label>
                                                        <input type="radio" name="spd_rating_{{$project->id}}" id="spd_rating_{{$project->id}}-4" value="2" {{$project->review->speed == 2 ? 'checked' : ''}}/>
                                                        <label for="spd_rating_{{$project->id}}-4" class="fa fa-star"></label>
                                                        <input type="radio" name="spd_rating_{{$project->id}}" id="spd_rating_{{$project->id}}-5" value="1" {{$project->review->speed == 1 ? 'checked' : ''}}/>
                                                        <label for="spd_rating_{{$project->id}}-5" class="fa fa-star"></label>
                                                    </div>
                                                    <label style="margin-top:0px;">&nbsp;&nbsp;&nbsp;Speed</label>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>

                                            <!-- Review Comment -->

                                            <div class="row col-md-6" style="margin-top:20px;">
                                                <label><b>Review:</b></label>
                                                <textarea id="review" rows="1" readonly="readonly" style="border: 0px solid; padding:0px; box-shadow:none; overflow:hidden; min-height: 30px; resize:none; " onfocus="autosize(this)">{{$project->review->review}}</textarea>
                                            </div>
                                        @endif

                                        </td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @endforeach
                @endif
                
            </div>
            <div class="pagination-container margin-top-15 margin-bottom-40">
                <nav class="pagination">
                    {!! $projects->links() !!}
                </nav>
            </div>
        </div>


        <!-- Copyrights -->
        <div class="col-md-12">
            <div class="copyrights">Copyright Edenlinx 2017. All rights reserved.<br>Created by <a href="http://emoceanstudios.com.au" target="_blank" style="color: #f91942;">emoceanstudios.com.au.</a></div>
        </div>

    </div>

    <script>
        function autosize(element){
            element.style.height = "5px";
            element.style.height = (element.scrollHeight)+"px";
            element.blur();
        }

        $(document).ready(function(){
            $('.proj_textarea').focus();
            $('#review').focus();
        });
    </script>
@endsection
