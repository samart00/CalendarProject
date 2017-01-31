<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Project;
use yii\widgets\ActiveForm;

$baseUrl = \Yii::getAlias('@web');
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'โครงการ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <p>
        <?= Html::a('สร้างโครงการ', ['create'], ['class' => 'btn btn-success','style']) ?>
    </p>
   	<div class="site-index">
	<div class="box box-solid">
		<div class="box-header with-border">
		<?php $form = ActiveForm::begin(); ?>
			<div class="row">
				<div class="col-md-4">
					<?php echo Html::textInput('name', $name, ['id'=> 'project_name', 'class'=> 'form-control', 'placeholder'=> 'ชื่อโครงการ', 'onchange'=>'this.form.submit()']);?>
				</div>
				<div class="col-md-4">
					<?php echo Html::textInput('status', $status, ['id'=> 'status', 'class'=> 'form-control', 'placeholder'=> 'สถานะ', 'onchange'=>'this.form.submit()']);?>
				</div>
				<div class="col-md-4">
					<?php echo Html::textInput('sort', $sort, ['id'=> 'sort', 'class'=> 'form-control', 'placeholder'=> 'จัดเรียง', 'onchange'=>'this.form.submit()']);?>
				</div>
			</div>
		<?php ActiveForm::end(); ?>
		</div>
	</div>
	<?php $count = 0; ?>
	<?php foreach ($value as $field): ?>
	<?php $count++; ?>
	<?php if($count == 1){?>
		<div class="row">
		<?php } ?>
			<div class="col-md-4">
				<div class="box box-solid">
					<div class="box-header with-border box-height">
						<span>
							<?php echo $field->project_name; ?>
						</span>
					</div>
				</div>
			</div>
		<?php if($count == 3 ){ $count = 0;?>
		</div>
		<?php } ?>
	<?php endforeach; ?>
	</div>
</div>
