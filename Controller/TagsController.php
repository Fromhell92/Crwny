<?php
App::uses('AppController', 'Controller');
class TagsController extends AppController {
    
    public $helpers = array('Js');
    public $components = array('RequestHandler');
	
	public function show($id = null) {
		$options = array('conditions' => array('Tag.' . $this->Tag->primaryKey => $id));
		$this->set('tags', $this->Tag->find('first', $options));
	}
	
	public function search() {
	   
		if ( $this->RequestHandler->isAjax() ) {
            	
            Configure::write ( 'debug', 0 );
            $this->autoRender=false;
          	$tags=$this->Tag->find('all',array('conditions'=>array('Tag.name LIKE'=>'%'.$_GET['term'].'%')));
                 $i=0;
                 foreach($tags as $tag){
                     	
                    $response[$i]['value']=$tag['Tag']['name'];
                 	$i++;
                 }
             	echo json_encode($response);
      	}
        else{
              	
         	if (!empty($this->data)) {
                 
				$this->set('tags', $this->Tag->findByName($this->data['Tag']['search']));
		
            }
         }
		
	}

	public function searchAll() {
   		if ( $this->RequestHandler->isAjax() ) {
        		
        	Configure::write ( 'debug', 0 );
            $this->autoRender=false;
            $tags=$this->Tag->find('all',array('limit'=>array(10)));
            $i=0;
            foreach($tags as $tag){
              
            	$response[$i]['value']=$tag['Tag']['name'];
                    $i++;
         	}
            echo json_encode($response);
        }
  		else{
          		
          	if (!empty($this->data)) {
             		
             	$this->set('tags', $this->Tag->findByName($this->data['Tag']['search']));
        
            }
        }
        
	}	
}    	
?>