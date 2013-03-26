<?php
class ContactsController extends AppController {
 
    public $components = array('Email');
 
    function send() {
        	
        if(!empty($this->data)) {
            	
            $this->Contact->set($this->data);
 
            if($this->Contact->validates()) {
                	
                if(!empty($this->data['Contact']['company'])) {
                    	
                    $this->Email->from = $this->data['Contact']['company'] . ' - ' . $this->data['Contact']['name'] . ' <' . $this->data['Contact']['email'] . '>';
                } 
                else {
                    	
                    $this->Email->from = $this->data['Contact']['name'] . ' <' . $this->data['Contact']['email'] . '>';
                }
                $this->Email->to = 'mk@leodes.com';
                $this->Email->subject = 'Website request';
                $this->Email->send($this->data['Contact']['message']);
                $this->Session->setFlash('Your message has been sent.');
				$this->render('index');
                // Display the success.ctp page instead of the form again
            } 
            else {
               
			    $this->render('index');
            }
        }
    }
 
    function index() {
        // Placeholder for index. No actual action here, everything is submitted to the send function.
    }
 
}
?>