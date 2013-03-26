<?php
App::uses('AppModel', 'Model');
/**
 * upload Model
 *
 * @property User $User
 * @property User $User
 */
class upload extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'filename' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'filesize' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'filemime' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array('Tag');

	public function beforeSave($options = array()) {

    	if(isset($this->data['Upload']['temp_tags'])) {
     			
     		$newtags = explode(",", $this->data['Upload']['temp_tags']);
     		unset($this->data['Upload']['temp_tags']);
     		foreach($newtags as $newtag) {
     				
     			if($newtag != '') {
	      			$newtag = trim($newtag);
	      			//ID vorhanden oder nicht?
	      			$tag = $this->Tag->findByName($newtag);

	      			if(!isset($tag['Tag']['id'])) {
			        		
			        	//Tag neu anlegen
			        	$this->Tag->create();
				        $this->Tag->save(array('name' => $newtag));
				        $tag['Tag']['id'] = $this->Tag->id;
	      			}

	      			$this->data['Tag']['Tag'][] = $tag['Tag']['id'];
     			}
     		}
    	}

    	parent::beforeSave();
    	return true;
  }
  

}
?>