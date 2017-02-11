<?php
namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
	/**
	 * @var UploadedFile
	 */
	public $HolidayFile;

	public function rules()
	{
		return [
				[['HolidayFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
		];
	}

	public function upload()
	{
		if ($this->validate()) {
			$this->HolidayFile->saveAs('uploads/' . $this->HolidayFile->baseName . '.' . $this->HolidayFile->extension);
			return true;
		} else {
			return false;
		}
	}
}
?>