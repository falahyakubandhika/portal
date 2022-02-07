
<div class="content-wrapper">
          
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card ">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    
                 






                      
                      <?php
$aksi="pages/view/mod_aboutus/aksi_aboutus.php";
 
   echo "<h2>About Us</h2>";  
          $sql  = mysql_query("SELECT * FROM tb_about where id=1 limit 1");
          $r    = mysql_fetch_array($sql);

      echo " <form method=POST enctype='multipart/form-data' action=$aksi?module=aboutus&act=update>
               <input type=hidden name=id value=$r[id]>
               <table>
           <tr><td><textarea name='isi' style='width: 800px; height: 550px;' id='loko'>$r[about_text]</textarea></td></tr>
           <tr><td colspan=2><input type=submit value=Save  class='button'>
               <input type=button value=Cancel onclick=self.history.back()  class='button'></td></tr>
             </form></table>";
?>

                  </div>
                  
                </div>
              </div>
            
          </div>
         
  </div>