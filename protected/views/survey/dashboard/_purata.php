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
        'colors' => array('#01A9DB', '#FE9A2E', '#B40431', '#86B404'),
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
        'plotOptions' => array(
            'column' => array(
                'borderColor'=>null,
                'dataLabels' => array(
                    'enabled' => true,
                ),
            ),
        ),
        'series' => $data,
        'themes' => array('grid'),
    )
));
