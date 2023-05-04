<?php
/* @var $this SurveyController */
/* @var $model Survey */
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'survey-form',
	'enableAjaxValidation'=>false,
)); 

$this->breadcrumbs=array(
	'Surveys'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Survey', 'url'=>array('index')),
	array('label'=>'Manage Survey', 'url'=>array('admin')),
);
?>

<h1>Pengurusan Survey</h1>
<?php 
$idMajlis = Yii::app()->user->getState('id_majlis');
$model_Majlis = Majlis::model()->findByPk($idMajlis);
$flag = $model_Majlis->flag_survey;


if ($flag <> 1){
    echo CHtml::button('Mulakan Penilaian', array('class' => 'btn_print','submit' => array('majlis/start'))); 
}
elseif($flag == 1){ 
    echo CHtml::button('Tutup Penilaian', array('class' => 'btn_print','submit' => array('majlis/stop'))); 
}
$this->endWidget(); 
?>