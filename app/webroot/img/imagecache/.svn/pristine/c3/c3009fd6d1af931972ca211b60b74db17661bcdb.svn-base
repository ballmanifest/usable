<?php
App::uses('AppModel', 'Model');

class Group extends AppModel {

	public $displayField = 'id';

	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $hasMany = array(
		'ContactsGroup' => array(
			'className' => 'ContactsGroup',
			'foreignKey' => 'group_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UsersGroup' => array(
			'className' => 'UsersGroup',
			'foreignKey' => 'group_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Folder' => array(
			'className' => 'Folder',
			'foreignKey' => 'folder_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Share' => array(
			'className' => 'Share',
			'foreignKey' => 'contact_id',
			'conditions' => '',
			'dependent' => true,
			'fields' => '',
			'order' => ''
		)
	);
	 public $hasAndBelongsToMany = array(
        'Contacts' =>
            array(
                'className'              => 'Contact',
                'joinTable'              => 'contacts_groups',
                'foreignKey'             => 'group_id',
                'associationForeignKey'  => 'contact_id',
                'unique'                 => false,
                'conditions'             => '',
                'fields'                 => '',
                'order'                  => '',
                'limit'                  => '',
                'offset'                 => '',
                'finderQuery'            => '',
                'deleteQuery'            => '',
                'insertQuery'            => ''
            ),
             'User' =>
            array(
                'className'              => 'User',
                'joinTable'              => 'users_groups',
                'foreignKey'             => 'group_id',
                'associationForeignKey'  => 'user_id',
                'unique'                 => false,
                'conditions'             => '',
                'fields'                 => '',
                'order'                  => '',
                'limit'                  => '',
                'offset'                 => '',
                'finderQuery'            => '',
                'deleteQuery'            => '',
                'insertQuery'            => ''
            )
    );
	
	public function list_user_created_groups($user_id=null, $clue=null, $escape=array()){
		$groups_list = array();
		$conditions = array('Group.user_id' => $user_id);
		if($clue) {
			$conditions['Group.name LIKE'] = '%'. $clue . '%';
		}
		if(!empty($escape)) {
			$conditions['NOT'] = array('Group.id' => array_unique($escape));
		}
		$groups_list = $this->find('all',
										array(
											'fields' => array('Group.id', 'Group.name', 'Group.purpose','Group.is_for_account_users'),
											'recursive' => -1,
											'conditions' => $conditions
										)
									);
		return $groups_list;
	}
	
	public function get_info($group_id){
		$group_info = $this->find('first',
										array(
											'fields' => array('Group.id', 'Group.name', 'Group.purpose', 'Group.is_for_account_users', 'Group.folder_id'/*, 'Group.has_smart_filing_category'*/),
											'recursive' => -1,
											'conditions' => array('Group.id'=>$group_id)
										)
									);
		return $group_info;
	}
	
	
	
	
	
	public function get_user_groups($id){
		$model=array( 
                        'hasOne' => array_keys($this->hasOne), 
                        'hasMany' => array_keys($this->hasMany), 
                        'belongsTo' => array_keys($this->belongsTo), 
                        'hasAndBelongsToMany' => array_keys($this->hasAndBelongsToMany)) ;
		$this->unbindModelAll();
		$this->bindModel(array('hasAndBelongsToMany'=>array('User' =>
            array(
                'className'              => 'User',
                'joinTable'              => 'users_groups',
                'foreignKey'             => 'group_id',
                'associationForeignKey'  => 'user_id',
                'unique'                 => false,
                'conditions'             => '',
                'fields'                 => '',
                'order'                  => '',
                'limit'                  => '',
                'offset'                 => '',
                'finderQuery'            => '',
                'deleteQuery'            => '',
                'insertQuery'            => ''
            ))));
		$group_info = $this->find('all',
										array(
											
											'recursive' => 1,
											'conditions' => array('Group.id'=>$id)
										)
									);
	    foreach ($model as $relation => $model) {
         $this->bindModel(array($relation => $model)); 
         }
		return $group_info;
		
		
	}
	
	
	
	
	
	
	public function get_contact_groups($id){
		$model=array( 
                        'hasOne' => array_keys($this->hasOne), 
                        'hasMany' => array_keys($this->hasMany), 
                        'belongsTo' => array_keys($this->belongsTo), 
                        'hasAndBelongsToMany' => array_keys($this->hasAndBelongsToMany)) ;
		$this->unbindModelAll();
		$this->bindModel(array('hasAndBelongsToMany'=>array('Contacts' =>
            array(
                'className'              => 'Contact',
                'joinTable'              => 'contacts_groups',
                'foreignKey'             => 'group_id',
                'associationForeignKey'  => 'contact_id',
                'unique'                 => false,
                'conditions'             => '',
                'fields'                 => '',
                'order'                  => '',
                'limit'                  => '',
                'offset'                 => '',
                'finderQuery'            => '',
                'deleteQuery'            => '',
                'insertQuery'            => ''
            ))));
		$group_info = $this->find('all',
										array(
											
											'recursive' => 1,
											'conditions' => array('Group.id'=>$id)
										)
									);
	    foreach ($model as $relation => $model) {
         $this->bindModel(array($relation => $model)); 
         }
		return $group_info;
		
		
	}
	
	
	
	
	 function unbindModelAll() { 
                foreach(array( 
                        'hasOne' => array_keys($this->hasOne), 
                        'hasMany' => array_keys($this->hasMany), 
                        'belongsTo' => array_keys($this->belongsTo), 
                        'hasAndBelongsToMany' => array_keys($this->hasAndBelongsToMany) 
                ) as $relation => $model) {
                        $this->unbindModel(array($relation => $model)); 
                } 
        } 
}
