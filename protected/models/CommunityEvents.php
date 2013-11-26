<?php

/**
 * This is the model class for table "community_events".
 *
 * The followings are the available columns in table 'community_events':
 * @property integer $id
 * @property integer $community_id
 * @property integer $event_id
 * @property integer $will_attend
 * @property integer $will_not_attend
 */
class CommunityEvents extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'community_events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('community_id, event_id', 'required'),
			array('community_id, event_id, will_attend, will_not_attend', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, community_id, event_id, will_attend, will_not_attend', 'safe', 'on'=>'search'),
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
			'community_id' => 'Community',
			'event_id' => 'Event',
			'will_attend' => 'Will Attend',
			'will_not_attend' => 'Will Not Attend',
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
		$criteria->compare('community_id',$this->community_id);
		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('will_attend',$this->will_attend);
		$criteria->compare('will_not_attend',$this->will_not_attend);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CommunityEvents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
