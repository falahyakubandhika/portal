
<div class="content-wrapper">
          
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card ">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    
                 






                      
                      <?php
$aksi="pages/view/mod_video/aksi_video.php";
 
   echo "<h2>Video Home</h2>";  
          $sql  = mysql_query("SELECT * FROM bb_video where id=1 limit 1");
          $r    = mysql_fetch_array($sql);
echo "$r[URL]";
      echo "

<form class='forms-sample' method='POST' action='$aksi?module=video&act=update'>
                        <input type=hidden name=id value=$r[id]>
                        <div class='form-group'>
                          <label for='exampleInputEmail1'>URL Video : </label>
                          <input type='text' class='form-control' name='URL' value='$r[URL]'>
                        </div>
                        <div class='form-group'>
                          <label for='exampleInputEmail1'>Title Video : </label>
                          <input type='text' class='form-control' name='video_title' value='$r[video_title]'>
                        </div>
                        <div class='form-group'>
                          <label for='exampleInputEmail1'>Desc En : </label>
                          <textarea name='desc' style='width: 800px; height: 550px;' id='loko'>$r[desc_en]</textarea>
                        </div>
                        <div class='form-group'>
                          <label for='exampleInputEmail1'>Desc In : </label>
                          <textarea name='desc_id' style='width: 800px; height: 550px;' id='loko2'>$r[desc_id]</textarea>
                        </div>
                        
 <input type=submit name=submit value=Simpan  class='btn btn-success mr-2'>
                            <input type=button value=Batal onclick=self.history.back()  class='btn btn-light mr-2'>
                      </form>

      ";
?>

                  </div>
                  
                </div>
              </div>
            
          </div>
         
  </div>