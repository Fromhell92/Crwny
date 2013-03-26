<div class="uploads form">
<h2>Upload Image</h2>
<?php echo $this->Form->create('Upload', array('type' => 'file'));?>
  <fieldset>
     <legend><?php __('Add Upload'); ?></legend>
  <?php
  echo $this->Form->input('Upload.0.title');
  echo $this->Form->input('Upload.0.file', array('type' => 'file'));
  echo $this->Form->input('Upload.0.temp_tags', array(
		'label' => 'Tags (seperate with commas)',
    ));

  ?>
  </fieldset> 
  <fieldset>
     <legend><?php __('Add Upload'); ?></legend>
  <?php
  echo $this->Form->input('Upload.1.title');
  echo $this->Form->input('Upload.1.file', array('type' => 'file'));
  echo $this->Form->input('Upload.1.temp_tags', array(
		'label' => 'Tags (seperate with commas)',
    ));

  ?>
  </fieldset>
   <fieldset>
     <legend><?php __('Add Upload'); ?></legend>
  <?php
  echo $this->Form->input('Upload.2.title');
  echo $this->Form->input('Upload.2.file', array('type' => 'file'));
  echo $this->Form->input('Upload.2.temp_tags', array(
		'label' => 'Tags (seperate with commas)',
    ));

  ?>
  </fieldset>
  
  
  
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Uploads'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
