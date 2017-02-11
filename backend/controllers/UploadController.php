<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\UploadForm;
use yii\web\UploadedFile;
use yii\bootstrap\BootstrapWidgetTrait;
use yii\bootstrap\Alert;
class UploadController extends Controller
{
	public function actionIndex()
	{
		$model = new UploadForm();

		if (Yii::$app->request->isPost) {
			$model->HolidayFile = UploadedFile::getInstance($model, 'HolidayFile');
			if ($model->upload()) {
				// file is uploaded successfully
				Alert::begin([
				    'options' => [
				        'class' => 'alert-success',
				    ],
				]);
			
				echo 'Success.';
				
				Alert::end();
			}else{
				Alert::begin([
						'options' => [
								'class' => 'alert-danger',
						],
				]);
					
				echo 'Fail';
				
				Alert::end();
			}
		}

		return $this->render('UploadHoliday', ['model' => $model]);
	}
}
?>