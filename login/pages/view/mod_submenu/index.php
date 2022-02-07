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
$aksi="pages/view/mod_submenu/aksi_menu.php";
if (isset($_GET['act'])){
    switch($_GET['act']){
  // Tampil users_group
    // Tampil User
  default:
   
    break;
  
  case "tambahsubmenu": 
  echo "<h2>Add Sub Menu</h2>
    <form method=POST action='$aksi?module=submenu&act=input' enctype='multipart/form-data' id='FormData' onSubmit='return CekField();' name=formData>
      <table class='hovertable'>
      <tr><td width=70>Title</td><td><input type=text name='Title' size=60 class='required'></td></tr>
      <tr><td width=70>Title_id</td><td><input type=text name='Title_id' size=60 class='required'></td></tr>
      <tr><td width=70>Date Posted</td><td><input type=text name='Date' size='20'  class='datepicker'></td></tr>
      <tr><td>Link</td><td> <input type=text name='Subtitle' size=60 class='required'></td></tr>
      <tr><td>Content</td><td><textarea id='loko' name='Detail'  style='width: 710px; height: 350px;'></textarea></td></tr>
      <tr><td>Content_id</td><td><textarea id='loko2' name='Detail_id'  style='width: 710px; height: 350px;'></textarea></td></tr>
      <tr><td>Image</td><td><input type=file name='fupload' size=40><br>Tipe gambar harus JPG/JPEG dan ukuran lebar maks: 400 px</td></tr>";
      echo "<tr><td>Kelompok</td>  <td> : 
          <select name='brand_id' id='brand_id'>
            <option value='' selected>- Pilih Merk -</option>";
              $tampil=mysql_query("select * from tb_brand where fl_active =1  order by brand_name");
              while($r=mysql_fetch_array($tampil))
              {
                echo "<option value=$r[brand_id]>$r[brand_name]</option>";
              }
      echo "</select></td></tr>";         
      echo "
      <tr><td colspan=2><input type=submit value=Save>
        <input type=button value=Cancel onclick=self.history.back()></td></tr>
      </table>
    </form>";
      break;

   case "editsubmenu":
      echo "<h2> Edit Sub Menu </h2>";
    
    $edit = mysql_query("SELECT * FROM tb_catdetail WHERE tip='$_GET[id]'");
    $r    = mysql_fetch_array($edit);
    echo "<form method=POST action='$aksi?module=submenu&act=update' enctype='multipart/form-data' id='Form'  onSubmit='return CekUpdate();' name=formData>
      <input type=hidden name=id value=$r[tip]>
      <table class='hovertable'>
      <tr><td width=70>Title</td><td><input type=text name='Title' size=60 class='required' value='$r[Title]'></td></tr>
       <tr><td width=70>Title Id</td><td><input type=text name='Title_id' size=60 class='required' value='$r[Title_id]'></td></tr>
      <tr><td width=70>Date Posted</td><td><input type=text name='Date' size='20' value='$r[Date]' class='datepicker'></td></tr>";
      echo "<tr><td>Link</td>  <td> 
      <input type=text name='Subtitle' size=60 class='required' value='$r[Subtitle]'>
      </td></tr>
      <tr><td>Content</td>  <td> <textarea id='loko' name='Detail'  style='width: 710px; height: 350px;'>$r[Detail]</textarea></td></tr>
      <tr><td>Content_id</td>  <td> <textarea id='loko2' name='Detail_id'  style='width: 710px; height: 350px;'>$r[Detail_id]</textarea></td></tr>";

      echo "<tr><td>Gambar</td><td>";
      if ($r['Imgpath']!=''){
        $real_Imgpath = $r['Imgpath'];//str_replace("images/catdetail/","",$r[Imgpath]);
        $real_Imgpath = "../".trim($real_Imgpath);
        $Imgpath_small = "../images/catdetail/small_".$real_Imgpath;
        echo "<img src='".$real_Imgpath."' width='100'/>";
        echo "<a href='$aksi?module=submenu&act=hapusgambar&id=$r[tip]&namafile=$r[Imgpath]'><img src='images/cross.png' class='tombol'></a>";
      }
      echo "</td></tr>
      <tr><td>Ganti Gbr</td><td><input type=file name='fupload' size=30> *)</td></tr>
      <tr><td colspan=2>*) Apabila Gambar tidak diubah, dikosongkan saja.</td></tr>
      ";  
          echo "<tr><td>Parent</td>  <td> : 
          <select name='brand_id'>
       <option value='' >- Pilih Merk -</option>";
      $tampil=mysql_query("SELECT * FROM tb_brand ORDER BY brand_name");
      
        while($w=mysql_fetch_array($tampil))
    {
            if ($r[cat]==$w[brand_id])
      {
              echo "<option value=$w[brand_id] selected>$w[brand_name]</option>";
            }
            else
      {
              echo "<option value=$w[brand_id]>$w[brand_name]</option>";
            }
        }
    
    echo "</select></td></tr>";
      if ($r['fl_active']==1)
      {
        echo "<tr><td>Enabled</td><td><input type=radio name='fl_active' value='1' checked>Y  
        <input type=radio name='fl_active' value='0'> N";
      }
      else
      {
        echo "<tr><td>Enabled</td><td><input type=radio name='fl_active' value='1'>Y  
        <input type=radio name='fl_active' value='0' checked>N";
      }
      echo "</td></tr>
      <tr><td colspan=2><input type=submit value=Save>
      <input type=button value=Cancel onclick=self.history.back()></td></tr>
    </table></form>";
    break;    
  
}}
else{
  echo "<h2>Sub Menu List</h2>
  </div>
          <button  style='margin-bottom:15px' type='button' onclick=\"window.location.href='?module=submenu&act=tambahsubmenu';\" class='btn btn-primary btn-fw'> <i class='mdi mdi-file-plus'></i>Add Sub Menu</button>
          

          <table id='table_id' style='margin-top:15px' class='table table-striped table-bordered '>
                      <thead>
                        <tr><th>no</th><th>sub menu</th><th>parent </th><th>link </th><th>active</th><th>action</th></tr>
                      </thead><tbody>
          "; 
    $tampil=mysql_query("SELECT a.*, b.brand_name
FROM tb_catdetail a
left JOIN tb_brand b ON a.cat = b.brand_id order by a.cat ");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
      $tgl_posting=tgl_indo($r['Date']);
      $active=$r['fl_active'];
    if ($active == '1'){
      $blokir="<label class='badge badge-success'>Active</label>";
    }else{
      $blokir="<label class='badge badge-danger'>Not Active</label>";
    }

       echo "<tr><td>$no</td>
        
             <td>".substr($r['Title'],0,30)."...</td>
             <td>$r[brand_name]</td>
        <td>$r[Subtitle]</td>
         <td>$blokir</td>";   
     echo "
             <td><a href=?module=submenu&act=editsubmenu&id=$r[tip] title='Edit'><button type='button' class='btn btn-dark btn-fw'>
                          <i class='mdi mdi-cloud-download'></i>Edit</button></a>  
          <a href=$aksi?module=submenu&act=hapus&id=$r[tip] title='Delete'><button type='button' class='btn btn-danger btn-fw'> X Delete</button></a>
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