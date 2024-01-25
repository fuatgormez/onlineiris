		</div>

	</div>

	<!-- jQuery -->
<script src="<?php echo base_url(); ?>public/backend/manager/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>public/backend/manager/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>public/backend/manager/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>public/backend/manager/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url(); ?>public/backend/manager/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url(); ?>public/backend/manager/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/manager/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>public/backend/manager/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url(); ?>public/backend/manager/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/manager/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>public/backend/manager/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>public/backend/manager/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>public/backend/manager/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>public/backend/manager/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>public/backend/manager/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>public/backend/manager/js/demo.js"></script>

	<script>



	(function($) {
		
		$(document).ready(function() {
	        $('#editor1').summernote({height: 300});
	        $('#editor2').summernote({height: 300});
	        $('#editor3').summernote({height: 300});
	        $('#editor4').summernote({height: 300});
	        $('#editor5').summernote({height: 300});
	        $('#editor6').summernote({height: 300});
	        $('#editor7').summernote({height: 300});
	        $('#editor8').summernote({height: 300});
	        $('#editor9').summernote({height: 300});
	        $('#editor10').summernote({height: 300});
	        $('.editor').summernote({height: 300});
	        $('.editor_short').summernote({height: 150});
	    });

        $(".check-negative").keyup(function(){
            if($(this).val() < 0) {
                $(this).val(0)
            }

        });

	    //Initialize Select2 Elements
	    $(".select2").select2();

	    //Datemask dd/mm/yyyy
	    $("#datemask").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
	    //Datemask2 mm/dd/yyyy
	    $("#datemask2").inputmask("mm-dd-yyyy", {"placeholder": "mm-dd-yyyy"});
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


	    $("#example1").DataTable();
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

        $(document).ready(function () {

		    $("#btnAddNew").click(function () {

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

		    $('#PhotosTable').delegate('a.Delete', 'click', function () {
		        $(this).parent().parent().fadeOut('slow').remove();
		        return false;
		    });


		});

		selectEmailMethod = $('#selectEmailMethod').val();
        $('#selectEmailMethod').on('change',function() {
            selectEmailMethod = $('#selectEmailMethod').val();
            if ( selectEmailMethod == 'Normal' ) {
               	$('#smtpContainer').hide();
            } else if ( selectEmailMethod == 'SMTP' ) {
               	$('#smtpContainer').show();
            }
        });
        
    </script>
</body>
</html>