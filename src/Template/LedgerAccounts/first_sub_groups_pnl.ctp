<table class='table' style='border-top:none; border-bottom:none;' >
	<?php
		$Total_Liablities_ajax=0;
		
		foreach($liablitie_groups as $liablitie_group) 
			{ $Total_Liablities_ajax = $liablitie_group['debit'] - $liablitie_group['credit']; ?>
			  <tr>
				 <td style='text-align:left;border-top: none;border-bottom: none;'>
						<a href='#' class="first_grp_name"  first_grp_id='<?php echo $liablitie_group['group_id']; ?>' style='color:black;' > 
						<?php echo $liablitie_group['name']; ?> </a> 
				 </td>
				 <td style='text-align:right;border-top: none;border-bottom: none;'>
						<?php echo(abs($Total_Liablities_ajax));
						 if($Total_Liablities_ajax >= 0){ echo 'Dr'; } else { echo 'Cr';} ?>
				 </td>
			  </tr>
	
	 <?php  } ?>
</table>
