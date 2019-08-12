<div class="row">
	<div class="col-sm-6">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading">Equipment </div>
			    <div class="panel-body">
			    	<form data-action="<?php echo $this->baseUrl; ?>equipments/save" id="equipmentFrm" method="post">
			    		<input type="hidden" name="equipment_id" id="equipment_id"/>
					 	<div class="form-group">
					    	<label for="dept_name">Equipment Name:</label>
					    	<input type="text" class="form-control" name="name" id="equipment_name" required />
					  	</div>
					  	<div class="form-group">
					    	<label for="description">Description:</label>
					    	<textarea class="form-control" id="description" name="description"></textarea>
					  	</div>
					  	<button type="submit" class="btn btn-default">Save</button>
					  	<button type="button" class="btn btn-danger" onclick="reset_form();">Reset</button>
					</form>
			    </div>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading">
			    	Equipment List
			    	<span class="pull-right"><a class="btn btn-info btn-sm" style="margin-top: -8px;" href="<?php echo $this->baseUrl; ?>equipments/eq_export">Export</a></span>
		    	</div>
			    <div class="panel-body">
			    	<table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>equipments/index">
			    		<thead>
							<tr>
								<th>Name</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							
							<?php 
								/*if(!empty($equipments)):
									foreach($equipments as $equipment):
										echo "<tr>
											<td>{$equipment['name']}</td>
											<td>{$equipment['description']}</td>
											<td>
												<a class='green equipment_edit' data-id='{$equipment['id']}' data-name='{$equipment['name']}' data-description='{$equipment['description']}' href='#'>
												<i class='ace-icon fa fa-pencil bigger-130'></i>
												</a>
											</td>
										</tr>";
									endforeach;
								endif;*/
							?>
						</tbody>
			    	</table>
			    </div>
			</div>
		</div>
	</div>
</div>

@script
<script type="text/javascript">
	// to active the sidebar
    $('.nav .nav-list').activeSidebar('.equipment_li');

	var equipmentFrm = $("#equipmentFrm");
	var table = $("#dynamic-table");
	var equipment_name = $("#equipment_name");
	var description = $("#description");
	var equipment_id = $("#equipment_id");

	var oTable = table
		.DataTable({
			"processing": true,
			"serverSide": true,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"initComplete": function(settings, json) {
				//
			},
			"ajax":{
                "url": table.data('url'),
                "dataType": "json",
                "type": "POST",
            },
            "columns": [
                { "data": "name" },
                { "data": "description" },
                {
                	"data": null,
                	"render": function ( data, type, row, meta ) {
				      return "<a class='green equipment_edit' href='#' data-id='"+data.id+"' data-name='"+data.name+"' data-description='"+data.description+"'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
				    }
            	}
            ],
		})
		.on('click', '.equipment_edit',function(e){
			e.preventDefault();
			var $this = $(this);
			reset_form();
			equipment_name.val($this.data('name'));
			description.val($this.data('description'));
			equipment_id.val($this.data('id'));
		});

	// submit form event
	equipmentFrm.on('submit', function(e){
		e.preventDefault();
		var data = $(this).serialize();
		$.ajax({
			url: $(this).data('action'),
			method: 'post',
			dataType: 'json',
			data: data,
			success: function(data){
				reset_form();
				window.location.reload();
			}
		});
	});

	function reset_form(){
		equipmentFrm.trigger("reset");
		equipment_id.val("");
	}
</script>
@endscript