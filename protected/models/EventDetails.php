<?php

/**
 * This is the model class for table "event_details".
 *
 * The followings are the available columns in table 'event_details':
 * @property integer $id
 * @property string $event_name
 * @property string $event_details
 */
class EventDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'event_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_name, event_details', 'required'),
			array('event_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, event_name, event_details', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'event_name' => 'Event Name',
			'event_details' => 'Event Details',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('event_name',$this->event_name,true);
		$criteria->compare('event_details',$this->event_details,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EventDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    public static function getAllEvents($communityId){
        $query = Yii::app()->db->createCommand()
            ->select('*')
            ->from('community_events t1 , event_details t2')
            ->where('t1.event_id = t2.id and t1.community_id=:id',array(':id'=>$communityId))
            ->queryAll();
        
        return $query;
    }
    
    public static function getEventDetails($communityId, $eventId){
        $query = Yii::app()->db->createCommand()
            ->select('*')
            ->from('community_events t1 , event_details t2')
            ->where('t1.event_id = t2.id and t1.community_id=:id and t1.event_id=:eventId',array(':id'=>$communityId,':eventId'=>$eventId))
            ->queryAll();
        
        return $query[0];
    }
    
    public static function isUserAttends($userId,$eventId){
        $query = Yii::app()->db->createCommand()
            ->select('*')
            ->from('community_events t1 , community_attending t2')
            ->where('t1.event_id = t2.event_id and t1.event_id=:eventId and t2.id=:userId',array(':eventId'=>$eventId,':userId'=>3))
            ->queryAll();
        Common::pre($query,true);
        if($query){
            return true;
        }
        return false;
    
    }

}
