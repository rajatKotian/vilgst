<div id="load-popup-modal" class="modal fade" tabindex="-1"></div>
    <!-- jQuery 2.1.4 -->
    <!-- <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js" integrity="sha512-AFwxAkWdvxRd9qhYYp1qbeRZj6/iTNmJ2GFwcxsMOzwwTaRwz2a/2TX225Ebcj3whXte1WGQb38cXE5j7ZQw3g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap 3.3.5 -->
<!-- < ? php //if (strpos($pageType, "add") !== false) { ?>

< ? php// } ?> -->

  <?php  if($pageType!='login') { ?>
    <script src="dist/js/jquery.validate.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
      $.widget.bridge('uitooltip', $.ui.tooltip);
    </script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="plugins/iCheck/icheck.min.js"></script>

    <!-- DataTables -->
   <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="plugins/datepicker/jquery.datetimepicker.js"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
   <script src="plugins/clipboard/clipboard.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js?ver=03062017010101"></script>

  <?php } ?>
  </body>
</html>
<script type="text/javascript">
 if (window.location.protocol != 'https:') {
     location.href = location.href.replace("http://", "https://");
 }
</script>
