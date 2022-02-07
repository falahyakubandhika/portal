
<div class="content-wrapper">
          
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card ">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    
                 
                      
                      <?php
$aksi="pages/view/mod_banner/aksi_banner.php";
if (isset($_GET['act'])){
    switch($_GET['act']){
  // Tampil users_group
    // Tampil User
  default:
   
    break;
  
  case "tambahbanner":
       $sSQL = "  SELECT (banner_id + 1) AS banner_id FROM tb_banner ORDER BY banner_id DESC LIMIT 1 ";
     $rslt=mysql_query($sSQL) or die ("error query");
     $i=0;
     while ($row=mysql_fetch_assoc($rslt))
      {
          $banner_id = $row['banner_id'];
      }
      mysql_free_result($rslt);
 
    echo "<h2>New Banner</h2>
          <form method=POST action='$aksi?module=banner&act=input' name=formData onSubmit='return CekField();' enctype='multipart/form-data'>
          <table>
      <input name='banner_id' type='hidden' value='$banner_id'>
          <tr><td>Title</td><td><input type=text name='banner_title' size='60'></td></tr>
          <tr><td>Seq No</td><td><input type=text name='seq' size='10'></td></tr>
      <tr><td>Image</td><td><input type=file name='fupload' size='40'>Minimum Width 290px , height ...px </td></tr>
      <tr><td>Link URL</td><td><input type=text name='banner_link'  onKeyUp='this.value = String(this.value).toLowerCase()'><i>http://www.domainname.com/url/</i></td></tr>
      <tr><td>Status</td><td colspan=2 align=left>
      <input type=radio name='stsActive' value=1 checked>Enabled  
          <input type=radio name='stsActive' value=0> Disabled</td></tr>
      <tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
                            <input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;
  
  // Form Edit Kategori  
  case "editbanner":
  $sSQL="select * from tb_banner WHERE banner_id='$_GET[banner_id]' limit 1";
  $rslt=mysql_query($sSQL) or die ("error query");
  $i=0;
  while ($row=mysql_fetch_assoc($rslt))
  {
    $banner_id = $row['banner_id'];
    $seq = $row['seq'];
    $banner_title = $row['banner_title'];
    $banner_link = $row['banner_link'];
    $banner_descr = $row['banner_descr'];
    $banner_img =  $row['banner_img'];
    $stsActive=$row['banner_stsActive'];
  }
  mysql_free_result($rslt);
  /* Get small image */
  $real_gambar = "../".$banner_img;
    
    echo "<h2>Banner Edit</h2>
    <form method=POST action='$aksi?module=banner&act=update' name=formData onSubmit='return CekUpdate();' enctype='multipart/form-data'>
          <table>
      <input name='banner_id' type='hidden' value='$banner_id'><input name='banner_img' type='hidden' value='$banner_img'>
          <tr><td>Title :</td><td><input type=text name='banner_title' size='60' value='$banner_title'></td></tr>
          <tr><td>Seq No :</td><td><input type=text name='seq' size='10' value='$seq'></td></tr>
      <tr><td>Image</td><td><img src='$real_gambar' style='width:150px;'><a href='$aksi?module=banner&act=hapusgambar&id=$banner_id&namafile=$banner_img'><img src='images/cross.png' class='tombol'></a>290px x .... px  </td></tr>
      <tr><td >New Image :</td><td><input type=file name='fupload' size='40'></td></tr>
      <tr><td></td><td ><i>Leave it Blank if you won't change this image</i> (Minimum Width 1000px , height 381px)</td></tr>
      <tr><td>Link URL :</td><td><input type=text name='banner_link'  onKeyUp='this.value = String(this.value).toLowerCase()' value='$banner_link'><i>http://www.domainname.com/url/</i></td></tr>";
      if ($stsActive=='1') {
        echo "<tr><td>Status :</td><td colspan=2 align=left><input type=radio name='stsActive' value=1 checked>Enabled  
        <input type=radio name='stsActive' value=0> Disabled</td></tr>";
      }
      else
      {
        echo "<tr><td>Status</td><td colspan=2 align=left><input type=radio name='stsActive' value=1>Enabled
        <input type=radio name='stsActive' value=0 checked> Disabled</td></tr>";
      }
        echo "<tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
      <input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
    </table></form>";      
    break;    
  
}}
else{
  echo "<h2>Banner List</h2>
  </div>
          <button  style='margin-bottom:15px' type='button' onclick=\"window.location.href='?module=banner&act=tambahbanner ';\" class='btn btn-primary btn-fw'> <i class='mdi mdi-file-plus'></i>Add Banner</button>
          

          <table id='table_id' style='margin-top:15px' class='table table-striped table-bordered '>
                      <thead>
                        <tr><th>No</th>
                        <th>Banner Title</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th></tr>
                      </thead><tbody>
          "; 
    $tampil=mysql_query("SELECT * FROM tb_banner order by banner_id ");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
    if ($r['banner_stsActive'] == '1'){
      $blokir="<label class='badge badge-success'>Active</label>";
    }else{
      $blokir="<label class='badge badge-danger'>Not Active</label>";
    }

       echo "<tr><td>$no</td>
      <td>$r[banner_title]</td>
      <td align='center'><img src='../$r[banner_img]'/></td>
      <td>$blokir</td>";   
     echo "
             <td><a href=?module=banner&act=editbanner&banner_id=$r[banner_id] title='Edit'><button type='button' class='btn btn-dark btn-fw'>
                          <i class='mdi mdi-cloud-download'></i>Edit</button></a>  
          <a href=$aksi?module=banner&act=hapus&banner_id=$r[banner_id] title='Delete'><button type='button' class='btn btn-danger btn-fw'> X Delete</button></a>
           </td>";
     //<a href=$aksi?module=users_group&act=hapus&id=$r[id_user_group] title='Hapus' class='ask'><img src='images/trash.png' class='tombol'></a>  
    echo "</tr>";
      $no++;
    }
    echo "</tbody></table>";
}
?>

                  </div>
                  
                </div>
              </div>
            
          </div>
         
  </div>