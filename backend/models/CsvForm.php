<?php
namespace backend\models;


use yii\base\Model;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;


class CsvForm extends Model{
	/**
	 * @var UploadedFile
	 */
	public $csv_file;

	public function rules(){
		return [
 				[['csv_file'],'required'],
				[['csv_file'],'file','extensions'=>'csv','maxSize'=>1024 * 1024 * 5],
// 				[['csv_file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
		];
	}

// 	public function attributeLabels(){
// 		return [
// 				'csv_file'=>'Select File',
// 		];
// 	}
// 	public function upload()
// 	{
// 		if ($this->validate()) {
// 			$this->csv_file->saveAs('uploads/' . $this->csv_file->baseName . '.' . $this->csv_file->extension);
// 			return true;
// 		} else {
// 			return false;
// 		}
// 	}
}