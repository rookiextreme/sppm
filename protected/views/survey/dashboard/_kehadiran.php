<?php

$this->Widget('ext.highcharts.HighchartsWidget', array(
    'options' => array(
        'colors' => array('#68B55A', '#FFD148'),
        'gradient' => array('enabled' => true),
        'credits' => array('enabled' => false),
        'exporting' => array('enabled' => false),
        'chart' => array(
            'backgroundColor' => '#fff',
            'plotBorderWidth' => null,
            'plotShadow' => false,
            'height' => 400,
        ),
        'title' => false,
        'tooltip' => array(
            'percentageDecimals' => 1,
            'formatter' => 'js:function() { return this.point.name+":  <b>"+this.point.y+" ("+Math.round(this.point.percentage)+"</b>%)"; }',
        //the reason it didnt work before was because you need to use javascript functions to round and refrence the JSON as this.<array>.<index> ~jeffrey
        ),
        'plotOptions' => array(
            'pie' => array(
                'borderColor'=>null,
                'allowPointSelect' => true,
                'cursor' => 'pointer',
                'dataLabels' => array(
                    'enabled' => false,
                    'color' => '#AAAAAA',
                    'connectorColor' => '#AAAAAA',
                ),
                'showInLegend' => true,
            )
        ),
        'series' => array(
            array(
                'type' => 'pie',
                'name' => 'Percentage',
                'data' => $data,
            ),
        ),
    )
));
