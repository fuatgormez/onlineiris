</div>

</div>

<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery-2.2.4.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/dataTables.bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>public/backend/admin/js/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/jscolor.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery.inputmask.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery.inputmask.extensions.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/icheck.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/fastclick.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery.fancybox.pack.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/app.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/summernote.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/demo.js"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/custom.js?<?php echo uniqid(); ?>"></script>
<script src="<?php echo base_url(); ?>public/backend/admin/js/dataTable.js?<?php echo uniqid(); ?>"></script>
<script src="<?php echo base_url(); ?>public/backend/js/backend.js?<?php echo uniqid(); ?>"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

<script>
	(function($) {

		var clipboard = new ClipboardJS('.copyClipboard');

		clipboard.on('success', function(e) {
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Copied!",
				text: e.text,
				showConfirmButton: false,
				timer: 1000,
				backdrop: `rgba(0,80,170,0.4) left top no-repeat`,
			});
			e.clearSelection();
		});

		clipboard.on('error', function(e) {
			Swal.fire({
				position: "top-end",
				icon: "error",
				title: "error",
				showConfirmButton: false,
				timer: 1500,
				backdrop: `rgba(244,67,54,0.4) left top no-repeat`,
			});
		});


		$(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });

		$(document).ready(function() {
			$('#editor1').summernote({
				height: 300
			});
			$('#editor2').summernote({
				height: 300
			});
			$('#editor3').summernote({
				height: 300
			});
			$('#editor4').summernote({
				height: 300
			});
			$('#editor5').summernote({
				height: 300
			});
			$('#editor6').summernote({
				height: 300
			});
			$('#editor7').summernote({
				height: 300
			});
			$('#editor8').summernote({
				height: 300
			});
			$('#editor9').summernote({
				height: 300
			});
			$('#editor10').summernote({
				height: 300
			});
			$('.editor').summernote({
				height: 300
			});
			$('.editor_short').summernote({
				height: 150
			});

			

		});

		$(".check-negative").keyup(function() {
			if ($(this).val() < 0) {
				$(this).val(0)
			}

		});

		//Initialize Select2 Elements
		$(".select2").select2();

		//Datemask dd/mm/yyyy
		$("#datemask").inputmask("dd-mm-yyyy", {
			"placeholder": "dd-mm-yyyy"
		});
		//Datemask2 mm/dd/yyyy
		$("#datemask2").inputmask("mm-dd-yyyy", {
			"placeholder": "mm-dd-yyyy"
		});
		//Money Euro
		$("[data-mask]").inputmask();

		//Date picker
		$('.datepicker').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd',
			todayBtn: 'linked',
		});
		$('#datepicker').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd',
			todayBtn: 'linked',
		});

		$('#datepicker1').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd',
			todayBtn: 'linked',
		});

		$('#datepicker2').datepicker({
			autoclose: true,
			format: 'yyyy-mm-dd',
			todayBtn: 'linked',
		});

		//iCheck for checkbox and radio inputs
		$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
			checkboxClass: 'icheckbox_minimal-blue',
			radioClass: 'iradio_minimal-blue'
		});
		//Red color scheme for iCheck
		$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
			checkboxClass: 'icheckbox_minimal-red',
			radioClass: 'iradio_minimal-red'
		});
		//Flat red color scheme for iCheck
		$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
			checkboxClass: 'icheckbox_flat-green',
			radioClass: 'iradio_flat-green'
		});

		$('#table_product_items').DataTable({
			"ordering": true,"searching": false,"paging": false,"info":false,
		});
		$('#example1').DataTable({
			// "order": [[ 0, "desc" ]]
			"ordering": true,
			"order": [[ 0, "desc" ]],
		});


		$('#example2').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": false,
			"ordering": true,
			"info": true,
			"autoWidth": false
		});

		$('#confirm-delete').on('show.bs.modal', function(e) {
			$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
		});

	})(jQuery);
</script>

<script type="text/javascript">
	$(document).ready(function() {

		$("#btnAddNew").click(function() {

			var rowNumber = $("#PhotosTable tbody tr").length;

			var trNew = "";

			var addLink = "<div class=\"upload-btn" + rowNumber + "\"><input type=\"file\" name=\"photos[]\"></div>";

			var deleteRow = "<a href=\"javascript:void()\" class=\"Delete btn btn-danger btn-xs\">X</a>";

			trNew = trNew + "<tr> ";

			trNew += "<td>" + addLink + "</td>";
			trNew += "<td style=\"width:28px;\">" + deleteRow + "</td>";

			trNew = trNew + " </tr>";

			$("#PhotosTable tbody").append(trNew);

		});

		$('#PhotosTable').delegate('a.Delete', 'click', function() {
			$(this).parent().parent().fadeOut('slow').remove();
			return false;
		});


	});

	selectEmailMethod = $('#selectEmailMethod').val();
	$('#selectEmailMethod').on('change', function() {
		selectEmailMethod = $('#selectEmailMethod').val();
		if (selectEmailMethod == 'Normal') {
			$('#smtpContainer').hide();
		} else if (selectEmailMethod == 'SMTP') {
			$('#smtpContainer').show();
		}
	});
</script>


<?php if(base_url(uri_string()) === base_url('backend/shop/order')):?>
<script src="<?php echo base_url(); ?>public/backend/js/dymo_print.js?<?php echo uniqid(); ?>"></script>
<?php endif;?>
<?php if(base_url(uri_string()) === base_url('backend/machine_tracking/device')):?>
<script src="<?php echo base_url(); ?>public/backend/js/device.js?<?php echo uniqid(); ?>"></script>
<?php endif;?>
</body>

</html>