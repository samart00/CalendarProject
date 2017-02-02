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
 * @property mixed $Type
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
            'Type',
            'Color',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Event_name', 'Discription', 'Start_Date', 'End_Date', 'Type', 'Color'], 'safe']
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
            'Type' => 'Type',
            'Color' => 'Color',
        ];
    }
    
    public function search($params)
    {
    	$query = Event::find();
    
    	// add conditions that should always apply here
    
    	
    	$query = Event::find();
    	
    	
    
    	// grid filtering conditions
    	$query->andFilterWhere(['like', '_id', $this->_id])
    	->andFilterWhere(['like', 'Event_name', $this->Event_name])
    	->andFilterWhere(['like', 'Discription', $this->Discription])
    	->andFilterWhere(['like', 'Start_Date', $this->Start_Date])
    	->andFilterWhere(['like', 'End_Date', $this->End_Date])
    	->andFilterWhere(['like', 'Type', $this->Type])
    	->andFilterWhere(['like', 'Color', $this->Color]);
    
    	$dataProvider = $query->all();
    	return $dataProvider;
    }
}
