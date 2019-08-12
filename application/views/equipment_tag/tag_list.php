<div class="row">
	<div class="col-sm-12">
		<div class="panel-group">
		  	<div class="panel panel-primary">
			    <div class="panel-heading">
			    	Equipment List
			    	<span class="pull-right"><a class="btn btn-info btn-sm" style="margin-top: -8px;" href="<?php echo $this->baseUrl; ?>equipment_tags/eq_tag_export">Export</a></span>
			    </div>
			    <div class="panel-body">
			    	<table id="dynamic-table" class="table table-striped table-bordered table-hover" data-url="<?php echo $this->baseUrl; ?>equipment_tags/index" data-imageUrl="<?php echo $this->assetsUrl; ?>qr/">
			    		<thead>
							<tr>
								<th>Equipment Name</th>
								<th>Plant Name</th>
								<th>Tag No</th>
								<th>Use</th>
								<th>QR</th>
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

<!-- Float Button-->
<div class="float_btn_parent">
    <a class="btn btn-warning btn-sm" title="Add Equipment Tag" href="<?php echo $this->baseUrl.'equipment_tags/add_update';?>">
        <i class="fa fa-plus"></i>
    </a>
</div>

@script
<script type="text/javascript">
	// to active the sidebar
    $('.nav .nav-list').activeSidebar('.equipment_tag_li');

	var table = $("#dynamic-table");
	var imgUrl = table.attr('data-imageUrl');
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
            		"data": "qr",
            		"render": function(data, type, row, meta){
            			console.log(data);
            			return "<img src='"+imgUrl+data+"' width='100px' />";
            		},
            		orderable: false
            	},
                {
                	"data": 'link',
                	"render": function ( data, type, row, meta ) {
				      return "<a class='green plant_edit' href='<?php echo $this->baseUrl; ?>equipment_tags/add_update/"+data.id+"'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
				    }
            	}
            ],
		});
</script>
@endscript