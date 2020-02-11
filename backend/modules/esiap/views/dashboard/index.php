<?php 

use dosamigos\chartjs\ChartJs;
use backend\modules\esiap\models\Stats;
use yii\helpers\ArrayHelper;

$this->title = 'e-SIAP Summary';
$this->params['breadcrumbs'][] = $this->title;



?>

<i>Electronic Structured and Integrated Academic Package</i>
<br /><br />





<div class="row">
<div class="col-md-6"><div class="box box-primary">
<div class="box-header">
<h3 class="box-title">Programs</h3>
</div>
<div class="box-body">

<?php 
$offered = Stats::countOfferedProgram();
$ud = Stats::countUDProgram();
echo ChartJs::widget([
    'type' => 'horizontalBar',
    'options' => [
       
        'width' => 400,
		'height' => 100
    ],
    'data' => [
        'labels' => ['','Offered Programs',' Under Development Programs'],
        'datasets' => [
            [
                'label' => "Total",
                'backgroundColor' => '#327fa8',
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => [0, $offered, $ud]
            ],
        ]
    ]
]);
?>


</div>
</div></div>

<div class="col-md-6">

<div class="box box-primary">
<div class="box-header">
<h3 class="box-title">Courses</h3>
</div>
<div class="box-body">

<?php 

$publish = Stats::countPublishedCourses();
$dev = Stats::countUDCourses();

echo ChartJs::widget([
    'type' => 'horizontalBar',
    'options' => [
       
        'width' => 400,
		'height' => 100
    ],
    'data' => [
        'labels' => ['','Published Courses',' Under Development Courses'],
        'datasets' => [
            [
                'label' => "Total",
                'backgroundColor' => '#327fa8',
                'borderColor' => "rgba(179,181,198,1)",
                'pointBackgroundColor' => "rgba(179,181,198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(179,181,198,1)",
                'data' => [0,$publish,$dev]
            ],
        ]
    ]
]);
?>


</div>
</div>

</div>

</div>



<div class="row">
<div class="col-md-6">


<div class="box">
<div class="box-header">
<div class="box-title">

Under Development Status
</div>

</div>
<div class="box-body"><?php 

$draft = Stats::countUDStatus(0);
$submit = Stats::countUDStatus(10);
$verify = Stats::countUDStatus(20);

echo ChartJs::widget([
    'type' => 'pie',
    'id' => 'position_status',
    'options' => [
        'height' => 200,
        'width' => 400,
    ],
    'data' => [
        'radius' =>  "90%",
        'labels' => ['Draft', 'Submitted', 'Verified'], // Your labels
        'datasets' => [
            [
                'data' => [$draft,$submit,$verify], // Your dataset
                'label' => '',
                'backgroundColor' => [
                        '#ADC3FF',
                        '#FF9A9A',
						'#76e8bf',
						'#e876c4',
						'#e4e876',
						'#76e8e2',
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
            'display' => true,
            'position' => 'bottom',
            'labels' => [
                'fontSize' => 10,
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

?></div>
</div>

</div>

<div class="col-md-6">

<div class="box">
<div class="box-header">
<div class="box-title">

Courses by Program
</div>

</div>
<div class="box-body"><?php 

$result = Stats::courseByProgram();
$label = ArrayHelper::map($result, 'id','course_label');
$data = ArrayHelper::map($result, 'id','course_data');
$label = array_values($label);
$data = array_values($data);


echo ChartJs::widget([
    'type' => 'pie',
    'id' => 'coursesprogram',
    'options' => [
        'height' => 300,
        'width' => 400,
    ],
    'data' => [
        'radius' =>  "90%",
        'labels' => $label, // Your labels
        'datasets' => [
            [
                'data' => $data, // Your dataset
                'label' => '',
                'backgroundColor' => [
                        '#ADC3FF',
                        '#FF9A9A',
						'#76e8bf',
						'#e876c4',
						'#e4e876',
						'#76e8e2',
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
            'display' => true,
            'position' => 'bottom',
            'labels' => [
                'fontSize' => 10,
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

?></div>
</div>


</div>

</div>
