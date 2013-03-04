<?php
App::uses('AppModel', 'Model');

class Calendar extends AppModel {

	public $displayField = 'name';

	public $hasMany = array(
		'CalendarEvent' => array(
			'className' => 'CalendarEvent',
			'foreignKey' => 'calendar_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CalendarAdd' => array(
			'className' => 'CalendarAdd',
			'foreignKey' => 'calendar_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

}
