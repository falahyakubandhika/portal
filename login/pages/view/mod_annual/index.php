<script language ="javascript">
function CekField()
{
  if (document.formData.download_title.value=="")
  {
    alert(" Title must be no blank !!!");
    document.formData.download_title.focus();
    return false;
  } 
 /* if (document.formData.fupload.value=="")
  {
    alert("File must be no blank !!!");
    document.formData.fupload.focus();
    return false;
  }*/
   return true;
}   

function CekUpdate()
{
  if (document.formData.download_title.value=="")
  {
    alert(" Title must be no blank !!!");
    document.formData.download_title.focus();
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
$aksi="pages/view/mod_annual/aksi_download.php";
if (isset($_GET['act'])){
    switch($_GET['act']){
  // Tampil users_group
    // Tampil User
  default:
   
    break;
  
  case "tambahdownload":
       $sSQL = "  SELECT (download_id + 1) AS download_id FROM tb_annual ORDER BY download_id DESC LIMIT 1 ";
     $rslt=mysql_query($sSQL) or die ("error query");
     $i=0;
     while ($row=mysql_fetch_assoc($rslt))
      {
          $download_id = $row['download_id'];
      }
      mysql_free_result($rslt);
 
    echo "<h2>New File</h2>
          <form method=POST action='$aksi?module=annual&act=input' name=formData onSubmit='return CekField();' enctype='multipart/form-data'>
          <table>
      <input name='download_id' type='hidden' value='$download_id'>
          <tr><td>Title</td><td><input type=text name='download_title' size='60'></td></tr>
          <tr><td>Title Id</td><td><input type=text name='download_title_id' size='60'></td></tr>
          <tr><td>Seq No</td><td><input type=text name='seq' size='10'></td></tr>
      <tr><td>File PDF</td><td><input type=file accept='.pdf' name='fupload' size='40'></td></tr>
      
      <tr><td>Status</td><td colspan=2 align=left>
      <input type=radio name='stsActive' value=1 checked>Enabled  
          <input type=radio name='stsActive' value=0> Disabled</td></tr>
      <tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
                            <input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;
  
  // Form Edit Kategori  
  case "editdownload":
  $sSQL="select * from tb_annual WHERE download_id='$_GET[download_id]' limit 1";
  $rslt=mysql_query($sSQL) or die ("error query");
  $i=0;
  while ($row=mysql_fetch_assoc($rslt))
  {
    $download_id = $row['download_id'];
    $seq = $row['seq'];
    $download_title = $row['download_title'];
    $download_descr = $row['download_descr'];
     $download_title_id = $row['download_title_id'];
    $download_descr_id = $row['download_descr_id'];
    $download_img =  $row['download_img'];
    $stsActive=$row['download_stsActive'];
  }
  mysql_free_result($rslt);
  /* Get small image */
  $real_gambar = "../".$download_img;
    
    echo "<h2>Edit</h2>
    <form method=POST action='$aksi?module=annual&act=update' name=formData onSubmit='return CekUpdate();' enctype='multipart/form-data'>
          <table>
      <input name='download_id' type='hidden' value='$download_id'><input name='download_img' type='hidden' value='$download_img'>
          <tr><td>Title</td><td><input type=text name='download_title' size='60' value='$download_title'></td></tr>
          <tr><td>Title Id</td><td><input type=text name='download_title_id' size='60' value='$download_title_id'></td></tr>
          <tr><td>Seq No</td><td><input type=text name='seq' size='10' value='$seq'></td></tr>";

echo "<tr><td>Gambar</td><td>";
      if ($row['gambar']!=''){
        $real_gambar = str_replace("images/article/","",$r['gambar']);
        $real_gambar = trim($real_gambar);
        $gambar_small = "../images/article/small_".$real_gambar;
        echo "<img src='".$gambar_small."'/>";
        echo "<a href='$aksi?module=artikel&act=hapusgambar&id=$r[id_article]&namafile=$r[gambar]'><img src='images/cross.png' class='tombol'></a>";
      }
      echo "</td></tr>
      <tr><td>File PDF</td><td>".$download_img."<a href='$aksi?module=annual&act=hapusgambar&download_id=$download_id&namafile=$download_img'><img src='images/cross.png' class='tombol'></a></td></tr>
      <tr><td>New File PDF</td><td><input type=file accept='.pdf' name='fupload' size='40'><i>Leave it Blank if you won't change this file</i> </td></tr>";
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
  echo "<h2>Annual Report List</h2>
  </div>
          <button  style='margin-bottom:15px' type='button' onclick=\"window.location.href='?module=annual&act=tambahdownload ';\" class='btn btn-primary btn-fw'> <i class='mdi mdi-file-plus'></i>Add Annual Report</button>
          

          <table id='table_id' style='margin-top:15px' class='table table-striped table-bordered '>
                      <thead>
                        <tr><th>ID</th><th>Title</th><th>Status</th><th>Action</th></tr>
                      </thead><tbody>
          "; 
    $tampil=mysql_query("SELECT * FROM tb_annual ORDER BY download_id DESC ");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
    if ($r['download_stsActive'] == '1'){
      $blokir="<label class='badge badge-success'>Active</label>";
    }else{
      $blokir="<label class='badge badge-danger'>Not Active</label>";
    }

       echo "<tr><td>$no</td>
      <td>$r[download_title]</td>
      <td>$blokir</td>";   
     echo "
             <td><a href=?module=annual&act=editdownload&download_id=$r[download_id] title='Edit'><button type='button' class='btn btn-dark btn-fw'>
                          <i class='mdi mdi-cloud-download'></i>Edit</button></a>  
          <a href=$aksi?module=annual&act=hapus&download_id=$r[download_id] title='Delete'><button type='button' class='btn btn-danger btn-fw'> X Delete</button></a>
           </td>";
     //<a href=$aksi?module=users_group&act=hapus&download_id=$r[id_user_group] title='Hapus' class='ask'><img src='images/trash.png' class='tombol'></a>  
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