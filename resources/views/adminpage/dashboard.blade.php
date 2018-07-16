@extends('layouts.mastera')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

<div class="row">

    <!-- Item -->
    <div class="col-lg-4 col-md-6">
        <div class="dashboard-stat color-1">
            <div class="dashboard-stat-content" style="text-align:center;"><h4>{{$info->totalsales}}</h4> <span>Total Sales(AUD)</span></div>
            <div class="dashboard-stat-icon"><i class="fa fa-dollar"></i></div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="dashboard-stat color-2">
            <div class="dashboard-stat-content" style="text-align:center;"><h4>{{$info->totalbusiness}}</h4> <span>Total Business</span></div>
            <div class="dashboard-stat-icon"><i class="fa fa-briefcase"></i></div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="dashboard-stat color-3">
            <div class="dashboard-stat-content" style="text-align:center;"><h4>{{$info->totalcustomer}}</h4> <span>Total Customer</span></div>
            <div class="dashboard-stat-icon"><i class="fa fa-user"></i></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-stat color-2">
            <div class="dashboard-stat-content" style="text-align:center;"><h4>{{$info->freebusiness}}</h4> <span>Free Business</span></div>
            <div class="dashboard-stat-icon"><i class="fa fa-dashboard"></i></div>
        </div>
    </div>


    <div class="col-lg-3 col-md-6">
        <div class="dashboard-stat color-3">
            <div class="dashboard-stat-content" style="text-align:center;"><h4>{{$info->basicbusiness}}</h4> <span>Basic Business</span></div>
            <div class="dashboard-stat-icon"><i class="fa fa-building"></i></div>
        </div>
    </div>


    <div class="col-lg-3 col-md-6">
        <div class="dashboard-stat color-4">
            <div class="dashboard-stat-content" style="text-align:center;"><h4>{{$info->regularbusiness}}</h4> <span>Regular Business</span></div>
            <div class="dashboard-stat-icon"><i class="fa fa-diamond"></i></div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="dashboard-stat color-1">
            <div class="dashboard-stat-content" style="text-align:center;"><h4>{{$info->premiumbusiness}}</h4> <span>Premium Business</span></div>
            <div class="dashboard-stat-icon"><i class="fa fa-heart"></i></div>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-lg-6 col-md-12">
        <div class="dashboard-list-box with-icons margin-top-20">
            <h4>Top 5 Earned Business</h4>
            <ul>
                <?php $i = 0; ?>
                @foreach($info->topearnedbusiness as $earnbusiness)
                <?php $i++; ?>
                <li>
                    <img class="list-box-icon" src="{{url('')}}/{{$earnbusiness->b_image}}" style="width:64px; height:auto" onerror="this.src='{{asset('images/business.png')}}'" />
                    <strong style="font-size: 15px;">{{$earnbusiness->b_title}}</strong><br/><strong style="font-size: 13px;">Total Sales : <span style="color:#B00"> ${{$earnbusiness->b_sales}} </span></strong>
                </li>
                @endforeach
                @for($i; $i < 5; $i++)
                <li style="height: 68px;">
                </li>
                @endfor
            </ul>
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="dashboard-list-box with-icons margin-top-20">
            <h4>Top 5 Viewed Business</h4>
            <ul>
                <?php $i = 0; ?>
                @foreach($info->topviewedbusiness as $viewbusiness)
                <?php $i++; ?>
                <li>
                    <img class="list-box-icon" src="{{url('')}}/{{$viewbusiness->b_image}}"  style="width:64px; height:auto" onerror="this.src='{{asset('images/business.png')}}'" />
                    <strong style="font-size: 15px;">{{$viewbusiness->b_title}}</strong><br/><strong style="font-size: 13px;">Visit Count : <span style="color:#B00"> {{$viewbusiness->viewcnt}} </span> </strong>
                </li>
                @endforeach
                @for($i; $i < 5; $i++)
                <li style="height: 68px;">
                </li>
                @endfor
            </ul>
        </div>
    </div>

</div>

<script type="text/javascript" src="{{asset('lib1/scripts/Chart.min.js')}}"></script>

<div class="row" style="margin-top: 40px;">
    <div class="col-lg-6 col-md-12">
        <canvas id="myChart" height="200px"></canvas>
    </div>
</div>

<div class="row">
    <!-- Copyrights -->
    <div class="col-md-12">
        <div class="copyrights">Copyright Edenlinx 2017. All rights reserved.<br>Created by <a href="http://emoceanstudios.com.au" target="_blank" style="color: #f91942;">emoceanstudios.com.au.</a></div>
    </div>
</div>

<script>
   var ctx = document.getElementById('myChart').getContext('2d');
   var chart = new Chart(ctx, {
       // The type of chart we want to create
       type: 'line',
   
       // The data for our dataset
       data: {
           labels: ["30 days ago", "14 days ago", "7 days ago", "today"],
           datasets: [{
               label: "Customer",
               backgroundColor: 'rgba(255, 255, 255, 0)',
               borderColor: 'rgb(255, 99, 132)',
               data: [{{$info->customercnt_30}}, {{$info->customercnt_14}}, {{$info->customercnt_7}}, {{$info->totalcustomer}}],
           },
           {
               label: "Business",
               backgroundColor: 'rgba(255, 255, 255, 0)',
               borderColor: 'rgb(99, 99, 99)',
               data: [{{$info->businesscnt_30}}, {{$info->businesscnt_14}}, {{$info->businesscnt_7}}, {{$info->totalbusiness}}],
           }]
       },
   
       options: {}
   });
</script>
@endsection
