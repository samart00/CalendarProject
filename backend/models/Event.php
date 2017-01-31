<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for collection "Event".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $Event_name
 * @property mixed $Discription
 * @property mixed $Start_Date
 * @property mixed $End_Date
 * @property mixed $Status
 * @property mixed $Color
 */
class Event extends \yii\mongodb\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        return ['db_pm', 'Event'];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            'Event_name',
            'Discription',
            'Start_Date',
            'End_Date',
            'Status',
            'Color',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Event_name', 'Discription', 'Start_Date', 'End_Date', 'Status', 'Color'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            '_id' => 'ID',
            'Event_name' => 'Event Name',
            'Discription' => 'Discription',
            'Start_Date' => 'Start  Date',
            'End_Date' => 'End  Date',
            'Status' => 'Status',
            'Color' => 'Color',
        ];
    }
}
