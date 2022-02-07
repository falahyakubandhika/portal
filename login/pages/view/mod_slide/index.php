<script language ="javascript">
function CekField()
{
  if (document.formData.slide_title.value=="")
  {
    alert("Slide Title must be no blank !!!");
    document.formData.slide_title.focus();
    return false;
  } 
  if (document.formData.fupload.value=="")
  {
    alert("Slide Image must be no blank !!!");
    document.formData.fupload.focus();
    return false;
  }
   return true;
}   

function CekUpdate()
{
  if (document.formData.slide_title.value=="")
  {
    alert("Slide Title must be no blank !!!");
    document.formData.slide_title.focus();
    return false;
  }
   return true;
}
</script>
<div class="content-wrapper">
          
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card ">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    
                 
                      
                      <?php
$aksi="pages/view/mod_slide/aksi_slide.php";
if (isset($_GET['act'])){
    switch($_GET['act']){
  // Tampil users_group
    // Tampil User
  default:
   
    break;
  
  case "tambahslide":
       $sSQL = "  SELECT (slide_id + 1) AS slide_id FROM tb_slidenew ORDER BY slide_id DESC LIMIT 1 ";
     $rslt=mysql_query($sSQL) or die ("error query");
     $i=0;
     while ($row=mysql_fetch_assoc($rslt))
      {
          $slide_id = $row['slide_id'];
      }
      mysql_free_result($rslt);
 
    echo "<h2>New Slide</h2>
          <form method=POST action='$aksi?module=slide&act=input' name=formData onSubmit='return CekField();' enctype='multipart/form-data'>
          <table>
      <input name='slide_id' type='hidden' value='$slide_id'>
          <tr><td>Title</td><td><input type=text name='slide_title' size='100%' ></td></tr>
          <tr><td>Title Id</td><td><input type=text name='slide_title_id' size='100%' ></td></tr>
          <tr><td>Desc</td><td><input type=text name='slide_descr' size='100%'></td></tr>
          <tr><td>Desc Id</td><td><input type=text name='slide_descr_id' size='100%'></td></tr>
      <tr><td>Link URL</td><td><input type=text name='slide_link' size='100'><i>http://www.domainname.com/url/</i></td></tr>
      <tr><td>Image</td><td><input type=file name='fupload' size='40'>Minimum Width 1300px , height 406px </td></tr>
      <tr><td>Status</td><td colspan=2 align=left>
      <input type=radio name='stsActive' value=1 checked>Enabled  
          <input type=radio name='stsActive' value=0> Disabled</td></tr>
      <tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
                            <input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;
  
  // Form Edit Kategori  
  case "editslide":
  $sSQL="select * from tb_slidenew WHERE slide_id='$_GET[slide_id]' limit 1";
  $rslt=mysql_query($sSQL) or die ("error query");
  $i=0;
  while ($row=mysql_fetch_assoc($rslt))
  {
    $slide_id = $row['slide_id'];
    $slide_descr = $row['slide_descr'];
    $slide_title = $row['slide_title'];
     $slide_descr_id = $row['slide_descr_id'];
    $slide_title_id = $row['slide_title_id'];
    $slide_link = $row['slide_link'];
    $slide_img =  $row['slide_img'];
    $stsActive=$row['slide_stsActive'];
  }
  mysql_free_result($rslt);
  /* Get small image */
  $real_gambar = "../".$slide_img;
    
    echo "<h2>Slide Edit</h2>
    <form method=POST action='$aksi?module=slide&act=update' name=formData onSubmit='return CekUpdate();' enctype='multipart/form-data'>
          <table>
      <input name='slide_id' type='hidden' value='$slide_id'><input name='slide_img' type='hidden' value='$slide_img'>
          <tr><td>Title</td><td><input type=text name='slide_title' size='100%'   value='$slide_title'></td></tr>
          <tr><td>Title Id</td><td><input type=text name='slide_title_id' size='100%'   value='$slide_title_id'></td></tr>
          <tr><td>Desc</td><td><input type=text name='slide_descr' size='100%' value='$slide_descr'></td></tr>
          <tr><td>Desc Id</td><td><input type=text name='slide_descr_id' size='100%' value='$slide_descr_id'></td></tr>
      <tr><td>Link URL</td><td><input type=text name='slide_link' size='100%'  value='$slide_link'><i>http://www.domainname.com/url/</i></td></tr>
      <tr><td>Image</td><td><img src='$real_gambar' style='width:300px;'>
      <a href='$aksi?module=slide&act=hapusgambar&id=$slide_id&namafile=$slide_img'><img src='images/cross.png' class='tombol'></a>1300 x 406 px  
      </td></tr>
      <tr><td>New Image</td><td><input type=file name='fupload' size='40'><i>Leave it Blank if you won't change this image</i> (Minimum Width 670px , height 450px)</td></tr>";
      if ($stsActive=='1') {
        echo "<tr><td>Status</td><td colspan=2 align=left><input type=radio name='stsActive' value=1 checked>Enabled  
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
  echo "<h2>Slider List</h2>
  </div>
          <button  style='margin-bottom:15px' type='button' onclick=\"window.location.href='?module=slide&act=tambahslide ';\" class='btn btn-primary btn-fw'> <i class='mdi mdi-file-plus'></i>Add Slider</button>
          

          <table id='table_id' style='margin-top:15px' class='table table-striped table-bordered '>
                      <thead>
                        <tr><th>No</th>
                        <th>Slider Title</th>
                        <th>Slider Desc</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th></tr>
                      </thead><tbody>
          "; 
    $tampil=mysql_query("SELECT * FROM tb_slidenew order by slide_id ");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
    if ($r['slide_stsActive'] == '1'){
      $blokir="<label class='badge badge-success'>Active</label>";
    }else{
      $blokir="<label class='badge badge-danger'>Not Active</label>";
    }

       echo "<tr><td>$no</td>
      <td>$r[slide_title]</td>
       <td>$r[slide_descr]</td>
      <td align='center'><img src='../$r[slide_img]'/></td>
      <td>$blokir</td>";   
     echo "
             <td><a href=?module=slide&act=editslide&slide_id=$r[slide_id] title='Edit'><button type='button' class='btn btn-dark btn-fw'>
                          <i class='mdi mdi-cloud-download'></i>Edit</button></a>  
          <a href=$aksi?module=slide&act=hapus&slide_id=$r[slide_id] title='Delete'><button type='button' class='btn btn-danger btn-fw'> X Delete</button></a>
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