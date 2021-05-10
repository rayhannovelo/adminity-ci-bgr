<div class="card">
	<div class="card-header">
			<?php
			if ($action_cek["act_create"]==1){
			?>
			<button data-toggle="modal" data-target="#modal-container" id="modal-btn" style="margin-left:5px;" title="Add/Edit Data"
			 class="card-block icon-btn btn btn-inverse btn-outline-inverse btn-icon">
				<i class="icofont icofont-ui-add"></i>
			</button>
			<?php } ?>
		<div class="card-header-right">
			<ul class="list-unstyled card-option">
				<li><i class="feather icon-maximize full-card"></i></li>
				<li><i class="feather icon-minus minimize-card"></i></li>
			</ul>
		</div>
	</div>
	<div class="card-block">
	<?php
				echo $render_table;
	?>
	</div>

</div>

<?php
	echo (!empty($render_table_js)?$render_table_js:"");
	echo (!empty($render_form_modal)?$render_form_modal:"");
	echo (!empty($render_detail_modal)?$render_detail_modal:"");
	echo (!empty($render_approve)?$render_approve:"");
?>