

<h2><?php $count = count($tags['Upload']);
	if($count == 1) {
		echo '1 image found for tag "'.$tags['Tag']['name'].'"';
		}
	else {
		echo $count.' images found for tag "'.$tags['Tag']['name'].'"';
	}
	?>
</h2>

	<?php 

	$i = 1;
	foreach ($tags['Upload'] as $tag): ?>
	
		<div class="<?php echo 'Thumb'.$i; ?>">
	<?php 		echo $this->Html->link($this->html->image('/webroot/img/uploads/thumbs/small-'.$tag['id'].'.jpg'), array(
				'controller' => 'uploads', 'action' => 'display', $tag['id']), array(
					'escape' => false));
		    
			?>
		</div>
	<?php 
	$i++;
	endforeach; ?>
	
