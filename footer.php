</div>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
<div class="copyright">
ระบบใบประเมินการสอบปฏิบัติ 9 งาน (สำหรับนักศึกษาทันตแพทยศาสตร์ ระดับปริญญาตรี) <br>
งานเทคโนโลยีสารสนเทศ ว่าที่ร.ต.มงคล ทองเพชรคง 7505  
</div>


<?php
//print_r($_SESSION);
?>

</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>



 <!-- jQuery -->
 <script src="assets/vendor/jquery/jquery.min.js"></script>
      <!-- select2 JS File -->
      <script src="assets/vendor/select2/js/select2.js"></script>



      <script>
          $(document).ready(function() {
            $('.select2').select2({
              placeholder: '--- กรุณาเลือก ---',
              allowClear: true,
              height: 30,
            });
            $('.js-example-basic-single').select2({
              placeholder: 'Select an option'
            });
          });


          $(document).ready(function() {
            $('select.select2:not(.normal)').each(function() {
              $(this).select2({
                dropdownParent: $(this).parent().parent()
              });
            });
          });
      </script>

 


    




<!-- datatables JS File -->
<script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="assets/vendor/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/vendor/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/vendor/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/vendor/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/vendor/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assets/vendor/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="assets/vendor/datatables-buttons/js/buttons.print.min.js"></script>
<script src="assets/vendor/datatables-buttons/js/buttons.colVis.min.js"></script>


<script>
  $("#DataTable1").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "ordering": true,
    "paging": true,
    "lengthChange": true,
    //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    "buttons": ["copy", "csv", "excel", "pdf", "print"]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');



  $("#DataTable2").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "ordering": true,
    "paging": true,
    "lengthChange": true,
    //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    "buttons": ["copy", "csv", "excel", "pdf", "print"]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');



</script>


 

<!-- Vendor JS Files -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/chart.js/chart.min.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.min.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>





</body>

</html>