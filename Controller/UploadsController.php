<?php
App::uses('AppController', 'Controller');
/**
 * Uploads Controller
 *
 * @property Upload $Upload
 */
class UploadsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	
	public function index() {
			
		$this->Upload->recursive = 0;
		$this->set('uploads', $this->paginate());
	}

	public function newindex() {
		
		$this->set('uploads', $this->paginate());
		
	}
	
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Upload->exists($id)) {
				
			throw new NotFoundException(__('Invalid upload'));
		
		}
		$options = array('conditions' => array('Upload.' . $this->Upload->primaryKey => $id));
		$this->set('upload', $this->Upload->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		$allowedTypes = array('.jpg', '.jpeg', '.gif', '.png');
		if ($this->request->is('post')) {
		$count = count($this->request->data['Upload']);	
			for ($i = 0; $i <= $count-1; $i++){
				$checked = false;	
				$namecheck = $this->data['Upload'][$i]['file']['name'];
				foreach($allowedTypes as $type) {
						
					if(strrchr($namecheck, ".") == $type) {
						$checked = true;
					}
				}
				if ($checked) {
						
					if ($this->uploadMultipleFile($i) && $this->Upload->save($this->data['Upload'][$i])) {
	
						$status = ImageTool::resize(array(
							'input' => APP.'webroot/img/uploads'.DS.$this->data['Upload'][$i]['id'].strrchr($this->data['Upload'][$i]['filename'], "."),
							'output' => APP.'webroot/img/uploads/thumbs'.DS.'small-'.$this->data['Upload'][$i]['id'].'.jpg',
							'width' => 150,
							'height' => 150,
							));
						
					} 
					else {
					$this->Session->setFlash(__('The upload could not be saved. Please, try again.'));
					}
				}
				else {
				$this->Session->setFlash('Fehler beim Upload von Bild '.$i.': Dateiformat wird nicht unterstützt.');
				}
				
			}
			
			$this->redirect(array('action' => 'newindex'));
			
			$users = $this->Upload->User->find('list');
			$this->set(compact('users', 'users'));
		}
	}

/**
 *	 Upload function
 *		
 * 		Called by add function.
 * 
 * 		Moves uploaded file to
 * 		upload folder webroot/img/uploads/.
 * 
 *  	Writes information about the file 
 *  	into an array to insert it into the
 *  	database.
 * 		
 * 		@param int $i
 * 		@return boolean
 * 		@return array
 * 		
 */

	function uploadMultipleFile($i) {
			
		$file = $this->data['Upload'][$i]['file'];
		if ($file['error'] === UPLOAD_ERR_OK) {
				
			$id = String::uuid();
			if (move_uploaded_file($file['tmp_name'], APP.'webroot/img/uploads'.DS.$id.strrchr($file['name'], "."))) {
			  	
			  $this->request->data['Upload'][$i]['id'] = $id;
			  $this->request->data['Upload'][$i]['user_id'] = $this->Auth->user('id');
			  $this->request->data['Upload'][$i]['filename'] = $file['name'];
			  $this->request->data['Upload'][$i]['filesize'] = $file['size'];
			  $this->request->data['Upload'][$i]['filemime'] = $file['type'];
			
			  return true;
			}
			
		}
	
	return false;
	
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Upload->exists($id)) {
				
			throw new NotFoundException(__('Invalid upload'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
				
			if ($this->Upload->save($this->request->data)) {
					
				$this->Session->setFlash(__('The upload has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
					
				$this->Session->setFlash(__('The upload could not be saved. Please, try again.'));
			}
		} else {
				
			$options = array('conditions' => array('Upload.' . $this->Upload->primaryKey => $id));
			$this->request->data = $this->Upload->find('first', $options);
		}
		$users = $this->Upload->User->find('list');
		$this->set(compact('users', 'users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
			
		$this->Upload->id = $id;
		
		if (!$this->Upload->exists()) {
				
			throw new NotFoundException(__('Invalid upload'));
		}
		$this->request->onlyAllow('post', 'delete');
		$upload = $this->Upload->find('first', array(
				'conditions' => array(
				'Upload.id' => $id,
				)));
		$filename = $upload['Upload']['id'];
			
		$image = new File(WWW_ROOT.'/img/uploads/'.$filename.strrchr($upload['Upload']['filename'], "."),false, 0777);
		$thumb = new File(WWW_ROOT.'/img/uploads/thumbs/small-'.$filename.'.jpg', false, 0777);
			
		if ($this->Upload->delete() && $image->delete() && $thumb->delete()) {
			
			$image->close(); 
			$thumb->close(); 
			$this->Session->setFlash(__('Upload deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Upload was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function display($id = null) {
			
		if (!$id) {
				
			$this->Session->setFlash(__('Invalid id for upload', true));
			$this->redirect(array('action' => 'index'));
		}
			$upload = $this->Upload->find('first', array(
			'conditions' => array(
				'Upload.id' => $id,
			)));
			$filename = $upload['Upload']['id'];
			$this->redirect('/webroot/img/uploads/'.$filename.strrchr($upload['Upload']['filename'], "."));
	}

	

}
