<div class="row">
	<div class="col-sm-6">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading">Department </div>
			    <div class="panel-body">
			    	<form data-action="<?php echo $this->baseUrl; ?>equipment_tags/add_update/<?php echo $id; ?>" id="tagFrm" method="post" data-generateQr="<?php echo $this->baseUrl; ?>equipment_tags/generate_qr">
			    		<div class="form-group">
					    	<label for="equipment_id">Equipment:</label>
					    	<select name="equipment_id" id="equipment_id" class="form-control" required>
					    		<option value=''></option>
					    		<?php 
					    			if(!empty($equipments)):
					    				foreach($equipments as $equipment):
					    					$select = ($equipment_tags['equipment_id'] == $equipment['id']) ? 'selected' : '';
					    					echo "<option value='{$equipment['id']}' {$select}>{$equipment['name']}</option>";
					    				endforeach;
					    			endif;
					    		?>
					    	</select>
					  	</div>
					  	<div class="form-group">
					    	<label for="plant_id">Plant:</label>
					    	<select name="plant_id" id="plant_id" class="form-control" required>
					    		<option value=''></option>
					    		<?php 
					    			if(!empty($plants)):
					    				foreach($plants as $plant):
					    					$select = ($equipment_tags['plant_id'] == $plant['id']) ? 'selected' : '';
					    					echo "<option value='{$plant['id']}' {$select}>{$plant['name']}</option>";
					    				endforeach;
					    			endif;
					    		?>
					    	</select>
					  	</div>
					  	<div class="form-group">
					    	<label for="tag_no">Tag No:</label>
					    	<input type="text" name="tag_no" id="tag_no" class="form-control" value="<?php echo $equipment_tags['tag_no']; ?>" required />
					  	</div>
					  	<div class="form-group">
					    	<label for="description">Use Of Equipment:</label>
					    	<textarea name="equipment_use" id="description" class="form-control"><?php echo $equipment_tags['equipment_use']; ?></textarea>
					  	</div>
					  	<button type="submit" class="btn btn-default">Save</button>
					  	<a class="btn btn-danger" href="<?php echo $this->baseUrl; ?>equipment_tags/">Cancel</a>
					</form>
			    </div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel-group">
			<div class="panel panel-primary">
				<div class="panel-heading">QR </div>
				<div class="panel-body">
					<div id="qr_image">
						<?php 
							if($equipment_tags['qr'] != ""): 
						?>
						<img src="<?php echo $this->assetsUrl; ?>qr/<?php echo $equipment_tags['qr']; ?>" width="250" />
						<?php 
							endif; 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@script
<script type="text/javascript">
	// to active the sidebar
    $('.nav .nav-list').activeSidebar('.equipment_tag_li');
    var tagNo = $("#tag_no");
    var equipment = $("#equipment_id");
    var plant = $("#plant_id");
    var tagFrm = $("#tagFrm");
    var description = $("#description");

    $(tagNo).add($(equipment)).add($(plant).add(description)).on('change', function(){
    	__generate();
    });

    function __generate(){
    	var equipmentVal = $.trim($("option:selected", equipment).text());
    	var plantVal = $.trim($("option:selected", plant).text());
    	var tagNoVal = tagNo.val();
    	if( equipmentVal != '' && plantVal != '' && tagNoVal != '' ){
			$.ajax({
				url: "<?php echo $this->baseUrl; ?>equipment_tags/generate_tag_qr",
				type: 'post',
				data: {"equipment": equipmentVal, "plant": plantVal, "tag_no": tagNoVal, "equipment_use": description.val()},
				success: function(result){
					var image = new Image();
					image.src = 'data:image/png;base64,'+result;
					image.width = '250';
					$("#qr_image").html(image);
				}
			});
    	}else{
    		return false;
    	}
    }
</script>
@endscript