<h1>Index</h1>
<?php echo $this->Form->create('Tag', array('controller' => 'Tags', 'action' => 'search'));?>
  <fieldset>
     <legend><?php __('Search'); ?></legend>
  <?php
  echo $this->Form->input('search');
  ?>
  </fieldset> 
<?php echo $this->Form->end(__('Submit', true));?>
<table>
	<tr>
		<th>Thumb</th>
		<th><?php echo $this->Paginator->sort('title'); ?></th>
		<th>Tags</th>
		<th><?php echo $this->Paginator->sort('user_id', 'Uploader'); ?></th>
		<th><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($uploads as $upload): ?>
	
	<tr>
		<td><?php 
			echo $this->html->image('/webroot/img/uploads/thumbs/small-'.$upload['Upload']['id'].'.jpg'); ?></td>
		<td><?php echo h($upload['Upload']['title']); ?></td>
		<td><?php 
			$tags = $upload['Tag'];
			foreach($tags as $tag) {
				echo $this->Html->link($tag['name'], array('controller' => 'tags', 'action' => 'show', $tag['id'])).' ';
		
				
			}
		
			?></td>
		<td>
			<?php echo $this->Html->link($upload['User']['username'], array('controller' => 'users', 'action' => 'view', $upload['User']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $upload['Upload']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $upload['Upload']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $upload['Upload']['id']), null, __('Are you sure you want to delete # %s?', $upload['Upload']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	
	
	
	
	
	
	
	
	
</table>