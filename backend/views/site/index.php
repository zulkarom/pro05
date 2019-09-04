<?php

use dosamigos\chartjs\ChartJs;
use backend\models\Stats;
use backend\models\Semester;


/* @var $this yii\web\View */

$this->title = 'Dashboard';

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

$curr_sem = Semester::getCurrentSemester();

?>
<h4>CURRENT SEMESTER: <?=strtoupper($curr_sem->niceFormat())?></h4>
<section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL ACTIVE<br /> FASILITATOR</span>
              <span class="info-box-number"><?=Stats::countAllCurrentFasilitator()?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">ACTIVE FASI <br />AT BACHOK</span>
              <span class="info-box-number"><?=Stats::countCurrentFasilitatorByCampus(1)?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">ACTIVE FASI <br />AT KOTA</span>
              <span class="info-box-number"><?=Stats::countCurrentFasilitatorByCampus(2)?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">ACTIVE FASI <br />AT JELI</span>
              <span class="info-box-number"><?=Stats::countCurrentFasilitatorByCampus(3)?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
      </div>
      
	  
	  <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>RM<?=number_format(Stats::sumClaimCurrentSemester()->sum_all,0)?></h3>

              <p>TOTAL CLAIM <br />CURRENT SEMESTER</p>
            </div>
            <div class="icon">
              <i class="fa fa-usd"></i>
            </div>
           
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>RM<?=number_format(Stats::sumClaimCurrentSemesterByCampus(1),0)?></h3>

              <p>CLAIM FOR BACHOK <br />CURRENT SEMESTER</p>
            </div>
            <div class="icon">
              <i class="fa fa-usd"></i>
            </div>
           
          </div>
        </div>
        <!-- ./col -->
       <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>RM<?=number_format(Stats::sumClaimCurrentSemesterByCampus(2),0)?></h3>

              <p>CLAIM FOR KOTA <br />CURRENT SEMESTER</p>
            </div>
            <div class="icon">
              <i class="fa fa-usd"></i>
            </div>
           
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
             <h3>RM<?=number_format(Stats::sumClaimCurrentSemesterByCampus(3),0)?></h3>

              <p>CLAIM FOR JELI <br />CURRENT SEMESTER</p>
            </div>
            <div class="icon">
              <i class="fa fa-usd"></i>
            </div>
           
          </div>
        </div>
        <!-- ./col -->
      </div>
      


<?php 
/* <div class="row">
<div class="col-md-6">

<div class="box">
<div class="box-header"></div>
<div class="box-body"><?= ChartJs::widget([
    'type' => 'line',
    'options' => [
        'height' => 400,
        'width' => 400
    ],
    'data' => [
        'labels' => ["January", "February", "March", "April", "May", "June", "July"],
        'datasets' => [
            [
                'label' => "My First dataset",
                'backgroundColor' => "rgba(179,181,198,0.2)",
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => [65, 59, 90, 81, 56, 55, 40]
            ],
            [
                'label' => "My Second dataset",
                'backgroundColor' => "rgba(255,99,132,0.2)",
                'borderColor' => "rgba(255,99,132,1)",
                'pointBackgroundColor' => "rgba(255,99,132,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(255,99,132,1)",
                'data' => [28, 48, 40, 19, 96, 27, 100]
            ]
        ]
    ]
]);
?></div>
</div></div>
<div class="col-md-6">

<div class="box">
<div class="box-header"></div>
<div class="box-body">
<?php 

echo ChartJs::widget([
    'type' => 'pie',
    'id' => 'structurePie',
    'options' => [
        'height' => 200,
        'width' => 400,
    ],
    'data' => [
        'radius' =>  "90%",
        'labels' => ['Label 1', 'Label 2', 'Label 3'], // Your labels
        'datasets' => [
            [
                'data' => ['35.6', '17.5', '46.9'], // Your dataset
                'label' => '',
                'backgroundColor' => [
                        '#ADC3FF',
                        '#FF9A9A',
                    'rgba(190, 124, 145, 0.8)'
                ],
                'borderColor' =>  [
                        '#fff',
                        '#fff',
                        '#fff'
                ],
                'borderWidth' => 1,
                'hoverBorderColor'=>["#999","#999","#999"],                
            ]
        ]
    ],
    'clientOptions' => [
        'legend' => [
            'display' => false,
            'position' => 'bottom',
            'labels' => [
                'fontSize' => 14,
                'fontColor' => "#425062",
            ]
        ],
        'tooltips' => [
            'enabled' => true,
            'intersect' => true
        ],
        'hover' => [
            'mode' => false
        ],
        'maintainAspectRatio' => false,

    ],

        
])
?>


</div>
</div>

</div>
</div> */

?>







</section>
