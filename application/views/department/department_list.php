<div class="row">
	<div class="col-sm-6">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading">Department </div>
			    <div class="panel-body">
			    	<form data-action="<?php echo $this->baseUrl; ?>departments/save" id="deptFrm" method="post">
			    		<input type="hidden" name="department_id" id="dept_id"/>
					 	<div class="form-group">
					    	<label for="dept_name">Department Name:</label>
					    	<input type="text" class="form-control" name="name" id="dept_name" required />
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
			    	Department List
			    	<span class="pull-right"><a class="btn btn-info btn-sm" style="margin-top: -8px;" href="<?php echo $this->baseUrl; ?>departments/dept_export">Export</a></span>
			    </div>
			    <div class="panel-body">
			    	<table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>departments/index">
			    		<thead>
							<tr>
								<th>Name</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							
							<?php 
								// if(!empty($departments)):
								// 	foreach($departments as $dept):
								// 		echo "<tr>
								// 			<td>{$dept['name']}</td>
								// 			<td>{$dept['description']}</td>
								// 			<td>
								// 				<a class='green dept_edit' data-id='{$dept['id']}' data-name='{$dept['name']}' data-description='{$dept['description']}' href='#'>
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
    $('.nav .nav-list').activeSidebar('.department_li');

	var deptFrm = $("#deptFrm");
	var table = $("#dynamic-table");
	var dept_name = $("#dept_name");
	var description = $("#description");
	var dept_id = $("#dept_id");

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
                'cache': false,
                "type": "POST",
            },
            "columns": [
                { "data": "name" },
                { "data": "description" },
                {
                	"data": null,
                	"render": function ( data, type, row, meta ) {
				      return "<a class='green dept_edit' href='#' data-id='"+data.id+"' data-name='"+data.name+"' data-description='"+data.description+"'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
				    }
            	}
            ],
		})
		.on('click', '.dept_edit',function(e){
			e.preventDefault();
			var $this = $(this);
			reset_form();
			dept_name.val($this.data('name'));
			description.val($this.data('description'));
			dept_id.val($this.data('id'));
		});

	// submit form event
	deptFrm.on('submit', function(e){
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
		deptFrm.trigger("reset");
		dept_id.val("");
	}
</script>
@endscript