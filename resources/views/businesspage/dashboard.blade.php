@extends('layouts.master1')
@section('title', $title)
@section('menuitem', $title)
@section('dashboardcontent')

<div class="row">

    <!-- Item -->
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-stat color-1">
            <div class="dashboard-stat-content"><h4>{{$info->activeproject}}</h4><span>Active<br/>Projects</span></div>
            <div class="dashboard-stat-icon"><i class="im im-icon-Map2"></i></div>
        </div>
    </div>

    <!-- Item -->
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-stat color-2">
            <div class="dashboard-stat-content"><h4>{{$info->completeproject}}</h4><span>Completed<br/>Projects</span></div>
            <div class="dashboard-stat-icon"><i class="im im-icon-Line-Chart"></i></div>
        </div>
    </div>


    <!-- Item -->
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-stat color-3">
            <div class="dashboard-stat-content"><h4>{{$info->monthlysale}}</h4><span>This<br/>Month</span></div>
            <div class="dashboard-stat-icon"><i class="fa fa-dollar"></i></div>
        </div>
    </div>

    <!-- Item -->
    <div class="col-lg-3 col-md-6">
        <div class="dashboard-stat color-4">
            <div class="dashboard-stat-content"><h4>{{$info->totalsale}}</h4><span>Total<br/>Sales</span></div>
            <div class="dashboard-stat-icon"><i class="fa fa-dollar"></i></div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{asset('lib1/scripts/Chart.min.js')}}"></script>

<div class="row" style="margin-top: 40px;">
    <div class="col-lg-12 col-md-12">
        <canvas id="myChart" height="100px"></canvas>
    </div>
</div>

<div class="row" style="margin-top: 40px;">

    <div class="col-lg-12 col-md-12">
        <div class="dashboard-list-box invoices with-icons margin-top-20">
            <h4>Next 5 Projects</h4>
            <ul>

                @foreach($info->nextproject  as $project)
                <li>
                    <img class="list-box-icon" src="{{url('')}}/{{$project->image}}" style="width:64px; height:auto" onerror="this.src='{{asset('images/theproject.png')}}'" />
                    <strong>{{$project->title}}</strong>
                    <ul>
                        <li><strong>{{$project->email}}</strong></li>
                        <li>End Date: <?php print_r(date_format(date_create($project->enddate), "Y/m/d")) ?></li>
                    </ul>
                    <div class="buttons-to-right">
                        <a href="{{url('business/projects/1')}}" class="button gray">View Project</a>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>


    <!-- Copyrights -->
    <div class="col-md-12">
        <div class="copyrights">Copyright Edenlinx 2017. All rights reserved.<br>Created by <a href="http://emoceanstudios.com.au" target="_blank" style="color: #f91942;">emoceanstudios.com.au.</a></div>
    </div>
</div>

<script>
   var ctx = document.getElementById('myChart').getContext('2d');
   var chart = new Chart(ctx, {
       // The type of chart we want to create
       type: 'bar',
   
       // The data for our dataset
       data: {
        labels: [
        <?php
            for($i = 5; $i >= 0; $i--)
            {
                echo "\"".date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"))."\"";
                if ($i > 0) echo ",";
            }
        ?>

        ],
        datasets: [
          {
            label: "Monthly Number of Visits",
            backgroundColor: ["#484a52", "#484a52","#484a52","#484a52","#484a52","#81c85b"],
            data: [
                <?php
                for($i = 5; $i >= 0; $i--)
                {
                    echo "\"".$info->viewcnt[$i]."\"";
                    if ($i > 0) echo ",";
                }
                ?>
            ]
          }
        ]
       },
       options: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Monthly Number of Visits'
            }
        }
   });
</script>
@endsection
