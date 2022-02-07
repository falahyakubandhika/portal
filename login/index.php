<?php 
ob_start();
session_start();
if(!empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])) echo '<p style="display:none"></p>';
else if(empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])) echo '<script>window.location = "/portal/login/login.php";</script>';

define('FILE_ACCESS', TRUE);
include 'config/koneksi.php';
include '../config/fungsi_indotgl.php';

	//echo '<script>window.location = "dashboard";</script>';
include header;
?>

<body>
<div class="container-scroller">
<!-- partial:partials/_navbar.html -->
<?php include 'partials/navbar.php';?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <!-- partial:partials/_sidebar.html -->
  <?php include sidebar;?>
  <!-- partial -->
  <div class="main-panel">

    <?php 
    if (!isset($_GET['module'])) {
      $_GET['module'] = 'dashboard';
      include 'pages/view/dashboard/index.php';
    }
    elseif(isset($_GET['module'])) {
      $actual_link = "$_SERVER[QUERY_STRING]";
      $link=explode('=',$actual_link);
      if($_GET['module']=='dashboard') include 'pages/view/dashboard/index.php';
     // else echo '<script>window.location = "pages/samples/error-404.html";</script>';
      else {
        $dariget = $_GET['module'];
        include 'pages/view/mod_'.$dariget.'/index.php';
      };
    }
    
    include footer;

    ?>
    
    <!-- partial -->
  </div>
  <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>

 
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/jquery.dataTables.min.js" type="text/javascript"></script>
   <script src="ckeditor/ckeditor.js"></script>
  
  <script type="text/javascript">
    CKEDITOR.on('dialogDefinition', function( ev ) {
  
    var diagName = ev.data.name;
    var diagDefn = ev.data.definition;

    if(diagName === 'table') {
      var infoTab = diagDefn.getContents('info');
      
      var width = infoTab.get('txtWidth');
      width['default'] = "100%";
      
      
    }
});
  CKEDITOR.replaceClass( 'ckeditor',{
     toolbarGroups: [{
          "name": "zsuploader",
          "groups": ["basicstyles"]
        }],
     extraPlugins = 'zsuploader';
  filebrowserBrowseUrl : 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
  filebrowserUploadUrl : 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
  filebrowserImageBrowseUrl : 'filemanager/dialog.php?type=1&editor=ckeditor&fldr='
});

  </script>
  <script type="text/javascript">
                      $(document).ready(function() {
                          $('#example').DataTable();
                      } );
                    </script>
  <!-- End custom js for this page-->
<script type="text/javascript">

// This is a check for the CKEditor class. If not defined, the paths must be checked.
if ( typeof CKEDITOR == 'undefined' )
{
  document.write(
    '<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
    'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
    'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
    'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
    'value (line 32).' ) ;
}
else
{
var editor = CKEDITOR.replace( 'loko' ) ;


  // Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
  // The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
  CKFinder.setupCKEditor( editor, '../includes/ckfinder/' ) ;

  // It is also possible to pass an object with selected CKFinder properties as a second argument.
  // CKFinder.SetupCKEditor( editor, { BasePath : '../../', RememberLastFolder : false } ) ;
  
  var editor2 = CKEDITOR.replace( 'loko2' ) ;


  // Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
  // The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
  CKFinder.setupCKEditor( editor2, '../includes/ckfinder/' ) ;

var editor3 = CKEDITOR.replace( 'loko3' ) ;


  // Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
  // The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
  CKFinder.setupCKEditor( editor3, '../includes/ckfinder/' ) ;

var editor4 = CKEDITOR.replace( 'loko4' ) ;


  // Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
  // The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
  CKFinder.setupCKEditor( editor4, '../includes/ckfinder/' ) ;
}

    </script>
</body>

</html>
