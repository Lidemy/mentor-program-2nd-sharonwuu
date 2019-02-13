<!--//// 印出 被刪除的 msgBlock ////-->
<div class="msgBlock bg" 
	floorNum =<?php echo $row['floorNum']; ?>
	>
	<div style="display: inline-block;">
	 	<div class="pic"> <?php echo $row['floorNum'] ."F"; ?> </div>		
	</div> 	
	<span> <?php echo $row['content']; ?> </span>
</div>

