<div id="sidebar" class="sidebar responsive ace-save-state">
	<script type="text/javascript">
		try{ace.settings.loadState('sidebar')}catch(e){}
	</script>

	<!--<div class="sidebar-shortcuts" id="sidebar-shortcuts">
		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<button class="btn btn-success">
				<i class="ace-icon fa fa-signal"></i>
			</button>

			<button class="btn btn-info">
				<i class="ace-icon fa fa-pencil"></i>
			</button>

			<button class="btn btn-warning">
				<i class="ace-icon fa fa-users"></i>
			</button>

			<button class="btn btn-danger">
				<i class="ace-icon fa fa-cogs"></i>
			</button>
		</div>

		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<span class="btn btn-success"></span>

			<span class="btn btn-info"></span>

			<span class="btn btn-warning"></span>

			<span class="btn btn-danger"></span>
		</div>
	</div>--><!-- /.sidebar-shortcuts -->

	<ul class="nav nav-list">
		<li class="">
			<a href="<?php echo $this->baseUrl; ?>">
				<i class="menu-icon fa fa-tachometer"></i>
				<span class="menu-text"> Dashboard </span>
			</a>

			<b class="arrow"></b>
		</li>

		<li class="">
			<a href="#" class="dropdown-toggle">
				<i class="menu-icon fa fa-desktop"></i>
				<span class="menu-text">
					Masters
				</span>

				<b class="arrow fa fa-angle-down"></b>
			</a>

			<b class="arrow"></b>

			<ul class="submenu">
				<li class="department_li">
					<a href="<?php echo $this->baseUrl; ?>index.php/departments">
						<i class="menu-icon fa fa-caret-right"></i>
						Departments
					</a>

					<b class="arrow"></b>
				</li>
				<li class="plant_li">
					<a href="<?php echo $this->baseUrl; ?>index.php/plants">
						<i class="menu-icon fa fa-caret-right"></i>
						Plants
					</a>

					<b class="arrow"></b>
				</li>
				<li class="equipment_type_li">
					<a href="<?php echo $this->baseUrl; ?>index.php/equipment_types">
						<i class="menu-icon fa fa-caret-right"></i>
						Equipment Types
					</a>

					<b class="arrow"></b>
				</li>
				<li class="equipment_li">
					<a href="<?php echo $this->baseUrl; ?>index.php/equipments">
						<i class="menu-icon fa fa-caret-right"></i>
						Equipments
					</a>

					<b class="arrow"></b>
				</li>
				<li class="equipment_tag_li">
					<a href="<?php echo $this->baseUrl; ?>index.php/equipment_tags">
						<i class="menu-icon fa fa-caret-right"></i>
						Equipment Tags
					</a>

					<b class="arrow"></b>
				</li>
				<li class="import_li">
					<a href="<?php echo $this->baseUrl; ?>index.php/imports/import_equipments">
						<i class="menu-icon fa fa-caret-right"></i>
						Imports
					</a>

					<b class="arrow"></b>
				</li>
			</ul>
		</li>
	</ul><!-- /.nav-list -->

	<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
		<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
	</div>
</div>