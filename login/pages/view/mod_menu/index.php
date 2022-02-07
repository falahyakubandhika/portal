<script language ="javascript">
function CekField()
{
  if (document.formData.judul.value=="")
  {
    alert("Judul Artikel Harus diinput !!!");
    document.formData.judul.focus();
    return false;
  } 
    if (document.formData.tanggal.value=="")
  {
    alert("Tanggal Artikel Harus diinput !!!");
    document.formData.tanggal.focus();
    return false;
  }
    if (document.formData.isi_artikel.value=="")
  {
    alert("Isi Artikel Harus diinput !!!");
    document.formData.isi_artikel.focus();
    return false;
  }
  /*
  if (document.formData.fupload.value=="")
  {
    alert("Gambar Artikel Harus diinput !!!");
    document.formData.fupload.focus();
    return false;
  }
  */
   return true;
}
function CekUpdate()
{
  if (document.formData.judul.value=="")
  {
    alert("Judul Artikel Harus diinput !!!");
    document.formData.judul.focus();
    return false;
  } 
    if (document.formData.tanggal.value=="")
  {
    alert("Tanggal Artikel Harus diinput !!!");
    document.formData.tanggal.focus();
    return false;
  }
    if (document.formData.isi_artikel.value=="")
  {
    alert("Isi Artikel Harus diinput !!!");
    document.formData.isi_artikel.focus();
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
$aksi="pages/view/mod_menu/aksi_menu.php";
if (isset($_GET['act'])){
    switch($_GET['act']){
  // Tampil users_group
    // Tampil User
  default:
   
    break;
  
  case "tambahmenu":
   
 
    echo "<h2>New Menu</h2>
          <form method=POST action='$aksi?module=menu&act=input' name=formData onSubmit='return CekField();' enctype='multipart/form-data'>
          <table>
         <tr><td>Menu Name</td><td> : <input type=text name='brand_name' size='30' ></td></tr>
         <tr><td>Menu Name Id</td><td> : <input type=text name='brand_name_id' size='30' ></td></tr>


       <tr><td>Link</td><td> : <input type=text name='link' size='30'></td></tr>
        <tr><td>Content</td><td> : <textarea id='loko' name='brand_desc'  style='width: 710px; height: 350px;'></textarea></td></tr>
      <tr><td>Content Id</td><td> : <textarea id='loko2' name='brand_desc_id'  style='width: 710px; height: 350px;'></textarea></td></tr>
      <tr><td>Status</td><td colspan=2 align=left>:
      <input type=radio name='stsActive' value=1 checked>Enabled 
          <input type=radio name='stsActive' value=0> Disabled</td></tr>
      
      
          <tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
                            <input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    
     break;
  
  // Form Edit brand
  case "editmenu":

   $sSQL="select * from tb_brand WHERE brand_id='$_GET[id]' limit 1";
     $rslt=mysql_query($sSQL) or die ("error query");
     $i=0;
     while ($row=mysql_fetch_assoc($rslt))
     {
          $brand_id = $row['brand_id'];
      $brand_name = $row['brand_name'];
      $brand_desc = $row['brand_desc'];
       $link = $row['link'];
      $stsActive=$row['fl_active'];
      $brand_name_id = $row['brand_name_id'];
       $brand_desc_id = $row['brand_desc_id'];

     }
      mysql_free_result($rslt);
    
    
      
    echo "<h2>Menu Edit</h2>
    <form method=POST action='$aksi?module=menu&act=update' name=formData onSubmit='return CekUpdate();' enctype='multipart/form-data'>
          <table>
      <input name='brand_id' type='hidden' value='$brand_id'>
                <tr><td>Menu Name</td><td> : <input type=text name='brand_name' size='30' value='$brand_name'></td></tr>
                <tr><td>Menu Name Id</td><td> : <input type=text name='brand_name_id' size='30' value='$brand_name_id'></td></tr>
      <tr><td>Link</td><td> : <input type=text name='link' size='30' value='$link'>
     </td></tr>
     <tr><td>Content</td><td> : <textarea id='loko' name='brand_desc'  style='width: 710px; height: 350px;'>$brand_desc</textarea></td></tr>
     <tr><td>Content Id</td><td> : <textarea id='loko2' name='brand_desc_id'  style='width: 710px; height: 350px;'>$brand_desc_id</textarea></td></tr>
      ";
      
  if ($stsActive=='1') {
      echo "<tr><td>Status</td><td colspan=2 align=left>:<input type=radio name='stsActive' value=1 checked>Enabled 
             <input type=radio name='stsActive' value=0> Disabled</td></tr>";
    }
  else
  {
      echo "<tr><td>Status</td><td colspan=2 align=left>:<input type=radio name='stsActive' value=1>Enabled
              <input type=radio name='stsActive' value=0 checked> Disabled</td></tr>";
  }     
      
      
      
        echo  "<tr><td colspan=2><input type=submit name=submit class='button'  value=Simpan>
                            <input type=button class='button'  value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    
              
    break;     
  
}}
else{
  echo "<h2>Menu List</h2>
  </div>
          <button  style='margin-bottom:15px' type='button' onclick=\"window.location.href='?module=menu&act=tambahmenu ';\" class='btn btn-primary btn-fw'> <i class='mdi mdi-file-plus'></i>Add Menu</button>
          

          <table id='table_id' style='margin-top:15px' class='table table-striped table-bordered '>
                      <thead>
                        <tr><th>No</th><th>Menu</th><th>Link</th><th>Active</th><th>action</th></tr>
                      </thead><tbody>
          "; 
    $tampil=mysql_query("SELECT * FROM tb_brand ORDER BY brand_id DESC ");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
      
    if ($r['fl_active'] == '1'){
      $blokir="<label class='badge badge-success'>Active</label>";
    }else{
      $blokir="<label class='badge badge-danger'>Not Active</label>";
    }

       echo "<tr><td>$no</td>
        
             <td>$r[brand_name]</td>
             <td>$r[link]</td>
      <td>$blokir</td>";   
     echo "
             <td><a href=?module=menu&act=editmenu&id=$r[brand_id] title='Edit'><button type='button' class='btn btn-dark btn-fw'>
                          <i class='mdi mdi-cloud-download'></i>Edit</button></a>  
          <a href=$aksi?module=menu&act=hapus&id=$r[brand_id] title='Delete'><button type='button' class='btn btn-danger btn-fw'> X Delete</button></a>
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