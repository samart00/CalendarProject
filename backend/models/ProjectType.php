<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "project_type".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $project_type
 * @property mixed $description
 * @property mixed $status
 */
class ProjectType extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['db_pm', 'project_type'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'project_type',
            'description',
            'status',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_type', 'description', 'status'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'project_type' => 'Project Type',
            'description' => 'Description',
            'status' => 'Status',
        ];
    }
}
