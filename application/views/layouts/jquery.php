<!-- basic scripts -->

<!--[if !IE]> -->
<script src="<?php echo $this->assetsUrl; ?>assets/js/jquery-2.1.4.min.js"></script>

<!-- <![endif]-->

<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
<script type="text/javascript">
if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo $this->assetsUrl; ?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="<?php echo $this->assetsUrl; ?>assets/js/bootstrap.min.js"></script>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
<script src="assets/js/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo $this->assetsUrl; ?>assets/js/jquery-ui.custom.min.js"></script>
<script src="<?php echo $this->assetsUrl; ?>assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo $this->assetsUrl; ?>assets/js/jquery.easypiechart.min.js"></script>
<script src="<?php echo $this->assetsUrl; ?>assets/js/jquery.sparkline.index.min.js"></script>
<script src="<?php echo $this->assetsUrl; ?>assets/js/jquery.flot.min.js"></script>
<script src="<?php echo $this->assetsUrl; ?>assets/js/jquery.flot.pie.min.js"></script>
<script src="<?php echo $this->assetsUrl; ?>assets/js/jquery.flot.resize.min.js"></script>

<!-- ace scripts -->
<script src="<?php echo $this->assetsUrl; ?>assets/js/ace-elements.min.js"></script>
<script src="<?php echo $this->assetsUrl; ?>assets/js/ace.min.js"></script>
<script src="<?php echo $this->assetsUrl; ?>assets/js/moment.min.js"></script>
<script src="<?php echo $this->assetsUrl; ?>assets/js/maintenance.js"></script>

<!-- table scripts -->
<script src="<?php echo $this->assetsUrl; ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->assetsUrl; ?>assets/js/jquery.dataTables.bootstrap.min.js"></script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
jQuery(function($) {
	$('.easy-pie-chart.percentage').each(function(){
		var $box = $(this).closest('.infobox');
		var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
		var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
		var size = parseInt($(this).data('size')) || 50;
		$(this).easyPieChart({
			barColor: barColor,
			trackColor: trackColor,
			scaleColor: false,
			lineCap: 'butt',
			lineWidth: parseInt(size/10),
			animate: ace.vars['old_ie'] ? false : 1000,
			size: size
		});
	});

});
</script>