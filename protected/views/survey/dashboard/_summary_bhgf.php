<?php
$this->Widget('ext.highcharts.HighchartsWidget', array(
    'options' => array(
        'title' => false,
        'xAxis' => array(
            'categories' => array('1', '2', '3', '4', '5',),
            'title' => array('text' => 'Skala'),
        ),
        'yAxis' => array(
            'title' => array('text' => 'Bilangan'),
            'stackLabels' => array('enabled' => true, 'align' => 'center'),
        ),
        'colors' => array('#01A9DB', '#FE9A2E', '#B40431', '#86B404', '#F5A9A9', '#04B4AE', '#6E6E6E', '#3104B4', '#8A0886', '#886A08', '#1C1C1C', '#0B6138'),
        'gradient' => array('enabled' => true),
        'credits' => array('enabled' => false),
        'exporting' => array('enabled' => false),
        'chart' => array(
            'backgroundColor' => '#fff',
            'plotBorderWidth' => null,
            'plotShadow' => false,
            'height' => 400,
            'type' => 'column'
        ),
        'series' => $data,
        'themes' => array('grid'),
    )
));