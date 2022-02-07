      <div class="content-wrapper">
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    
<?php 
include 'configclass/fungsi_indotgl.php';
/////////////////NEW FORM///////
$action = 'pages/view/mod_'.$link[1].'/aksi_'.$link[1].'.php';
$date = date("Y-m-d");  
if(!isset($_GET['aksi'])) 
{
  echo '
                  <h1 class="text-center">Our Business</h1>
                  <a class="btn btn-primary" href="#new" onclick="document.getElementById("new").scrollIntoView();">New</a>
                  
                  </script>
                  <p></p>
                  <table id="example" class="hover" style="width:100%">
                    <thead>
                        <tr>
                            <th width="1%">No</th>
                            <th >TITLE</th>
                            <th width="20%" >DATE POSTED</th>
                            <th width="1%" >ACTIVE</th>
                            <th width="3%" >ACTION</th>
                        </tr>
                    </thead>
                    <tbody>';
  
  $rslt = mysql_query("select * from tb_catdetail order by Date desc");
  $num = 1;
  while ($r2=mysql_fetch_array($rslt)) {
    $tgl_real = date("Y-m-d", strtotime($r2['Date']));
    $tgl_posting=tgl_indo($r2['Date']);
    $format=date("Y-m-d", strtotime($r2['Date']));
    $detail=$r2['Detail'];
    
        if ($r2['fl_active'] == 1)
        {
          $aktif =" title='Matikan'";
        } 
        else
        {
          $aktif ='style="filter:grayscale(100%)" title="Publikasikan"';
        }
        if(empty($r2['Imgpath'])) $r2['Imgpath']="";
    echo '


                          <tr>

                            <td>'.$num.'</td>
                            <td>'.$r2["Title"].'</td>
                            <td>'.$tgl_real.'</td>
                            <td class="text-center"><a href="'.$action.'?aksi=ubahstatus&id='.$r2['tip'].'"><img src="images/aktif.png" class="tombol" '.$aktif.'></a></td>
                            <td class="text-center"><a style="border:0px; background:transparent; cursor:pointer" href="?page=catdetail&aksi=edit-'.$r2['tip'].'"><img src="images/edit.png" class="tombol" title="Edit"></button>
          <a href="'.$action.'?aksi=delete&id='.$r2['tip'].'" class="ask" ';?> onclick="return confirm('Menghapus tidak akan mengembalikan data')"><img src="images/trash.png" class="tombol" title="Delete Article"></a></td>
                        </tr>
                        <?php 
                        $num++;
                      
  }
  echo '</tbody>
                    </table>';?>
                    <p id="new" style="margin-bottom: 20px"></p>
                    <h1 class="text-center">Create New</h1>
                    <div  class="contianer table-responsive">
                      
                      <table class="table" width="100%" style="border:1px solid #31373c">
                        <form method="post" action="<?php echo $action;?>" enctype="multipart/form-data">
                          <thead>
                            <th width="10%"></th>
                            <th></th>
                          </thead>
                          <tr>
                            <td>Title</td>
                            <td><input type="text" name="Title" class="form-control" placeholder="Title" required=""></td>
                          </tr>
                          <tr>
                            <td>Date Post</td> 
                            <td><input type="date" name="Date" class="form-control" required="" value="<?php echo $date;?>" readonly></td>
                          </tr>
                          <tr>
                            <td>Keywords</td>
                            <td><input type="text" name="meta_key" class="form-control" placeholder="Kata Kunci perncarian google" ></td>
                          </tr>
                          <tr>
                            <td>Description</td>
                            <td><input type="text" name="Subtitle" class="form-control" placeholder="Teks untuk menjelaskan keywords" required=""></td>
                          </tr>
                          <tr>
                            <td>Content</td>
                            <td><textarea class=ckeditor type="text" name="Detail" class="form-control" required=""></textarea></td>
                          </tr>
                          <tr>
                            <td>Image</td>
                            <td><input type="file" name="fupload" id="fupload" class="form-control" accept="image/*" size=40 ><br/>Ukuran lebar maks: 400 px</td>
                          </tr>
                          <tr>
                            <td>Kelompok</td>
                            <td>
                              <select name='brand_id' id='brand_id'>
                                <option value=-1 >- Pilih Merk -</option>"
<?php 
$tampil=mysql_query("select * from tb_brand where fl_active =1  order by brand_name");
while($r=mysql_fetch_array($tampil))
{
 
  echo                          "<option value=".$r['brand_id'].">".$r['brand_name']."</option>";
}
?>

                            </td>
                          </tr>
                          <tr>
                            <td><input class="btn btn-success" type="submit" name="sbinput" value="Save">
                              </td>
                            <td></td>
                          </tr>
                        
                        </form>
                      </table>
                    </div>

<?php }
else if(isset($_GET['aksi'])){

  $link = explode("-", $_GET['aksi']);
  $id = $link[1];
  $rslt = mysql_query("SELECT * from tb_catdetail where tip=".$id);
  
  while ($r=mysql_fetch_array($rslt)) {
    $tgl_posting=date("Y-m-d", strtotime($r['Date']));
    $format=date("Y-m-d", strtotime($r['Date']));
    $d_id=$r['tip'];
    $d_detail=$r['Detail'];
    $d_title = $r['Title'];
     $d_url = $r['cat_url'];
    $d_sbtitle = $r['Subtitle'];
     $d_key = $r['meta_key'];
    $cat = $r['cat'];
        if ($r['fl_active'] == 1)
        {
          $aktif="<img src='images/aktif.png' class='tombol'>";
        } 
        else
        {
          $aktif="<img src='images/nonaktif.png' class='tombol'>";
        }
        if(empty($r['Imgpath'])) $r['Imgpath']="";
    
    


  ?>
                    <h1 class="text-center">Edit Detail</h1>
                    <div  class="contianer table-responsive">
                      
                      <table class="table" width="100%" style="border:1px solid #31373c">
                        <form method="post" action="pages/view/mod_catdetail/aksi_catdetail.php" enctype="multipart/form-data">
                          <thead>
                            <th width="4%"></th>
                            <th></th>
                          </thead>
                          <tr>
                            <td>Title</td><input type="hidden" name="id" value="<?php echo $d_id;?>">
                            <td><input type="text" name="Title" class="form-control" value="<?php echo $d_title; ?>" required=""><br/><input type="text" name="zz" class="form-control" value="ijintender.co.id/development/detail.php?det=<?php echo $d_url; ?>" readonly></td>
                          </tr>
                          <tr>
                            <td>Date Post</td> 
                            <td><input type="date" name="Date" class="form-control" required="" value="<?php echo $tgl_posting;?>"></td>
                          </tr>
                          <tr>
                            <td>Description</td>
                            <td><input type="text" name="Subtitle" class="form-control" value="<?php echo $d_sbtitle; ?>" required=""></td>
                          </tr>
                          <tr>
                            <td>Keywords</td>
                            <td><input type="text" name="meta_key" class="form-control" value="<?php echo $d_key;?>" ></td>
                          </tr>
                          <tr>
                            <td>Content</td>
                            <td><textarea class=ckeditor type="text" name="Detail" class="form-control" required=""><?php echo $d_detail?></textarea></td>
                          </tr>
                          <tr>
                            <td>Image Terpilih</td>
                            <td><img src="../<?php echo $r['Imgpath'];?>" style="width: 150px; height: auto; border-radius: 0px"></td>
                          </tr>
                          <tr>
                            <td>Image</td>
                            <td><input type="file" name="fupload" id="fupload" class="form-control" accept="image/*" size=40><br/>Silahkan pilih jika ingin diganti. Ukuran lebar maks: 400 px</td>
                          </tr>
                          <tr>
                            <td>Kelompok</td>
                            <td>
                              <select name='brand_id' id='brand_id'>
                                <option value=-1>- Pilih Merk -</option>"
<?php 
$tampil=mysql_query("SELECT * from tb_brand where fl_active =1  order by brand_name");
while($r=mysql_fetch_array($tampil))
{
   if($cat==$r['brand_id']) {echo "<option value=".$r['brand_id']." selected>".$r['brand_name']."</option>";}
  else {echo                          "<option value=".$r['brand_id'].">".$r['brand_name']."</option>";}
}
?>

                            </td>
                          </tr>
                          <tr>
                            <td><input class="btn btn-success" type="submit" name="sbupdate" value="Save"><a class="btn btn-secondary mx-2" href="?page=catdetail">Cancel</a></td>
                            <td></td>
                          </tr>
                        
                        </form>
                      </table>
                    </div>
  <?php
}

}

?>
                                        
                
                  </div>
                  
                </div>
              </div>
            
          </div>
         
  </div>
