<div class="row">
	<div class="col-sm-6">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading"><?php echo $page_title; ?> </div>
			    <div class="panel-body">
			    	<form data-action="<?php echo $this->baseUrl; ?>equipment_types/save" id="eqTypeFrm" method="post">
			    		<input type="hidden" name="equipment_type_id" id="equipment_type_id"/>
					 	<div class="form-group">
					    	<label for="dept_name">Equipment Type:</label>
					    	<input type="text" class="form-control" name="name" id="name" required />
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
			    	Equipment Type List
			    	<span class="pull-right"><a class="btn btn-info btn-sm" style="margin-top: -8px;" href="<?php echo $this->baseUrl; ?>equipment_types/eq_type_export">Export</a></span>
			    </div>
			    <div class="panel-body">
			    	<table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>equipment_types/index">
			    		<thead>
							<tr>
								<th>Equipment Type</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
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
    $('.nav .nav-list').activeSidebar('.equipment_type_li');

	var eqTypeFrm = $("#eqTypeFrm");
	var table = $("#dynamic-table");
	var eqTypeName = $("#name");
	var description = $("#description");
	var eq_id = $("#equipment_type_id");

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
			eqTypeName.val($this.data('name'));
			description.val($this.data('description'));
			eq_id.val($this.data('id'));
		});

	// submit form event
	eqTypeFrm.on('submit', function(e){
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
		eqTypeFrm.trigger("reset");
		eq_id.val("");
	}
</script>
@endscript