<div class="row">
	<div class="col-sm-12">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading">Equipment List</div>
			    <div class="panel-body">
			    	<table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>index.php/equipment_tags/index">
			    		<thead>
							<tr>
								<th>Equipment Name</th>
								<th>Plant Name</th>
								<th>Tag No</th>
								<th>Use</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>							
							<?php 
								/*if(!empty($equipment_tags)):
									foreach($equipment_tags as $equipment_tag):
										echo "<tr>
											<td>{$equipment_tag['equipment_name']}</td>
											<td>{$equipment_tag['plant_name']}</td>
											<td>{$equipment_tag['tag_no']}</td>
											<td>
												<a class='green equipment_tag_edit' href='{$this->baseUrl}index.php/equipment_tags/add_update/{$equipment_tag['id']}'>
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

<!-- Float Button-->
<div class="float_btn_parent">
    <a class="btn btn-warning btn-sm" title="Add Equipment Tag" href="<?php echo $this->baseUrl.'index.php/equipment_tags/add_update';?>">
        <i class="fa fa-plus"></i>
    </a>
</div>

@script
<script type="text/javascript">
	// to active the sidebar
    $('.nav .nav-list').activeSidebar('.equipment_tag_li');

	var table = $("#dynamic-table");
	var oTable = table
		.DataTable({
			"processing": true,
			"serverSide": true,
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"ajax":{
                "url": table.data('url'),
                "dataType": "json",
                "type": "POST",
            },
            "columns": [
                { "data": "equipment_name" },
                { "data": "plant_name" },
                { "data": "tag_no" },
                { "data": "equipment_use" },
                {
                	"data": 'link',
                	"render": function ( data, type, row, meta ) {
				      return "<a class='green plant_edit' href='<?php echo $this->baseUrl; ?>index.php/equipment_tags/add_update/"+data.id+"'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
				    }
            	}
            ],
		});
</script>
@endscript