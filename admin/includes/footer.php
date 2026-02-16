<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2021</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>
<script>
(() => {
'use strict';
const forms = document.querySelectorAll('.needs-validation');
Array.from(forms).forEach(form => {
form.addEventListener('submit', event => {
if (!form.checkValidity()) {
event.preventDefault();
event.stopPropagation();
}
form.classList.add('was-validated');
}, false);
});
})();

  // Image preview
  const bookCoverInput = document.getElementById('bookCoverInput');
  const bookCoverPreview = document.getElementById('bookCoverPreview');

  bookCoverInput.addEventListener('change', function() {
    const file = this.files[0];
    if(file){
      const reader = new FileReader();
      reader.onload = function(e){
        bookCoverPreview.src = e.target.result;
        bookCoverPreview.style.display = 'block';
      }
      reader.readAsDataURL(file);
    } else {
      bookCoverPreview.style.display = 'none';
    }
  });

  // PDF preview as thumbnail
  const pdfInput = document.getElementById('pdfInput');
  const pdfPreview = document.getElementById('pdfPreview');
  const pdfFilename = document.getElementById('pdfFilename');

  pdfInput.addEventListener('change', function() {
    const file = this.files[0];
    if(file){
      pdfPreview.style.display = 'block';
      pdfFilename.textContent = file.name;
    } else {
      pdfPreview.style.display = 'none';
      pdfFilename.textContent = '';
    }
  });

</script>

<!-- Bootstrap core JavaScript-->
<script src="assest/vendor/jquery/jquery.min.js"></script>
<script src="assest/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="assest/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="assest/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="assest/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="assest/js/demo/chart-area-demo.js"></script>
<script src="assest/js/demo/chart-pie-demo.js"></script>

<!-- Page level plugins -->
<script src="assest/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="assest/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="assest/js/demo/datatables-demo.js"></script>

</body>

</html>