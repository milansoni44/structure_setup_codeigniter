<div class="row">
	<div class="col-sm-6">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading"><?php echo $page_title; ?> </div>
			    <div class="panel-body">
			    	<form data-action="<?php echo $this->baseUrl; ?>plants/save" id="plantFrm" method="post">
			    		<input type="hidden" name="plant_id" id="plant_id"/>
					 	<div class="form-group">
					    	<label for="plant_name">Plant Name:</label>
					    	<input type="text" class="form-control" name="name" id="plant_name" required />
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
			    	Plant List
			    	<span class="pull-right"><a class="btn btn-info btn-sm" style="margin-top: -8px;" href="<?php echo $this->baseUrl; ?>plants/pl_export">Export</a></span>
			    </div>
			    <div class="panel-body">
			    	<table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>plants/index">
			    		<thead>
							<tr>
								<th>Name</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							
							<?php 
								// if(!empty($plants)):
								// 	foreach($plants as $plant):
								// 		echo "<tr>
								// 			<td>{$plant['name']}</td>
								// 			<td>{$plant['description']}</td>
								// 			<td>
								// 				<a class='green plant_edit' data-id='{$plant['id']}' data-name='{$plant['name']}' data-description='{$plant['description']}' href='#'>
								// 				<i class='ace-icon fa fa-pencil bigger-130'></i>
								// 				</a>
								// 			</td>
								// 		</tr>";
								// 	endforeach;
								// endif;
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
    $('.nav .nav-list').activeSidebar('.plant_li');

	var plantFrm = $("#plantFrm");
	var table = $("#dynamic-table");
	var plant_name = $("#plant_name");
	var description = $("#description");
	var plant_id = $("#plant_id");
	console.log(table.data('url'));
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
				      return "<a class='green plant_edit' href='#' data-id='"+data.id+"' data-name='"+data.name+"' data-description='"+data.description+"'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
				    }
            	}
            ],
		})
		.on('click', '.plant_edit',function(e){
			e.preventDefault();
			var $this = $(this);
			reset_form();
			plant_name.val($this.data('name'));
			description.val($this.data('description'));
			plant_id.val($this.data('id'));
		});

	// submit form event
	plantFrm.on('submit', function(e){
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
		plantFrm.trigger("reset");
		plant_id.val("");
	}
</script>
@endscript