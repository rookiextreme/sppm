<?php
$this->Widget('ext.highcharts.HighchartsWidget', array(
    'options' => array(
        'title' => false,
        'xAxis' => array(
            'categories' => $category['lable'],
            'title' => array('text' => 'Tajuk Perbentangan'),
        ),
        'yAxis' => array(
//            'min' => 0,
//            'max' => 4,
//            'categories' => array('1', '2', '3', '4', '5',),
            'title' => array('text' => 'Skala'),
        ),
        'gradient' => array('enabled' => true),
        'credits' => array('enabled' => false),
        'exporting' => array('enabled' => false),
        'chart' => array(
            'backgroundColor' => '#fff',
            'plotBorderWidth' => null,
            'plotShadow' => false,
//            'height' => 400,
            'type' => 'line'
        ),
        'series' => $data,
        'themes' => array('grid'),
    )
));