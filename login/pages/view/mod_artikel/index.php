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
$aksi="pages/view/mod_artikel/aksi_artikel.php";
if (isset($_GET['act'])){
    switch($_GET['act']){
  // Tampil users_group
    // Tampil User
  default:
   
    break;
  
  case "tambahartikel": 
 echo "<h2>New News</h2>
     <form method=POST action='$aksi?module=artikel&act=input' enctype='multipart/form-data' id='FormData' onSubmit='return CekField();' name=formData>
      <table class='hovertable'>
      <tr><td>Tampil </td><td><input type=radio name='fl_active' value='1'> Y  
        <input type=radio name='fl_active' value='0'> N</td></tr>
      <tr><td width=70>Title</td><td><input type=text name='Title' size=100% class='required'></td></tr>
      <tr><td width=70>Judul</td><td><input type=text name='Title_id' size=100% class='required'></td></tr>
      <tr><td width=70>Date Posted</td><td><input type=text name='Date' size='100%'  class='datepicker'></td></tr>
      <tr><td>Content</td><td><textarea id='loko' name='Detail'  style='width: 710px; height: 350px;'></textarea></td></tr>
      <tr><td>Isi</td><td><textarea id='loko2' name='Detail_id'  style='width: 710px; height: 350px;'></textarea></td></tr>
      
      <tr><td>Image</td><td><input type=file name='fupload' size=40><br>Tipe gambar harus JPG/JPEG dan ukuran lebar maks: 400 px</td></tr>

      ";
            
      echo "
      <tr><td colspan=2><input type=submit value=Save>
        <input type=button value=Cancel onclick=self.history.back()></td></tr>
      </table>
    </form>";
      break;

   case "editartikel":
      echo "<h2> Edit News </h2>";
    
    $edit = mysql_query("SELECT * FROM tb_article WHERE id_article='$_GET[id]' AND username='$_SESSION[namauser]'");
    $r    = mysql_fetch_array($edit);
    echo "<form method=POST action='$aksi?module=artikel&act=update' enctype='multipart/form-data' id='FormData' onSubmit='return CekField();' name=formData>
      <input type=hidden name=id value=$r[id_article]>
      <table class='hovertable'>";
       if ($r['fl_active']=='1'){
        echo "<tr><td>Tampil</td><td><input type=radio name='fl_active' value='1' checked>Y  
        <input type=radio name='fl_active' value='0'> N";
      } else {
        echo "<tr><td>Tampil</td><td><input type=radio name='fl_active' value='1'>Y  
        <input type=radio name='fl_active' value='0' checked>N";
      }
      echo "</td></tr>";
      echo"
      <tr><td width=70>Title</td><td><input type=text name='Title' size=100% class='required' value='$r[judul]'></td></tr>
      <tr><td width=70>Judul</td><td><input type=text name='Title_id' size=100% class='required' value='$r[judul_id]'></td></tr>
      <tr><td width=70>Date Posted</td><td><input type=text name='Date' size='100%'  class='datepicker' value='$r[tanggal]'></td></tr>
      <tr><td>Content</td><td><textarea id='loko' name='Detail'  style='width: 710px; height: 350px;'>$r[isi_berita]</textarea></td></tr>
      <tr><td>Isi</td><td><textarea id='loko2' name='Detail_id'  style='width: 710px; height: 350px;'>$r[isi_berita_id]</textarea></td></tr>
       
      ";
      echo "<tr><td>Gambar</td><td>";
      if ($r['gambar']!=''){
        $real_gambar = str_replace("images/article/","",$r['gambar']);
        $real_gambar = trim($real_gambar);
        $gambar_small = "../images/article/small_".$real_gambar;
        echo "<img src='".$gambar_small."'/>";
        echo "<a href='$aksi?module=artikel&act=hapusgambar&id=$r[id_article]&namafile=$r[gambar]'><img src='images/cross.png' class='tombol'></a>";
      }
      echo "</td></tr>
      <tr><td>Ganti Gbr</td><td><input type=file name='fupload' size=40> *)</td></tr>
      <tr><td colspan=2>*) Apabila gambar tidak diubah, dikosongkan saja.</td></tr>
      ";  
     
      echo "
      <tr><td colspan=2><input type=submit value=Save>
      <input type=button value=Cancel onclick=self.history.back()></td></tr>
    </table></form>";
    break;    
  
}}
else{
  echo "<h2>News List</h2>
  </div>
          <button  style='margin-bottom:15px' type='button' onclick=\"window.location.href='?module=artikel&act=tambahartikel ';\" class='btn btn-primary btn-fw'> <i class='mdi mdi-file-plus'></i>Add News</button>
          

          <table id='table_id' style='margin-top:15px' class='table table-striped table-bordered '>
                      <thead>
                        <tr><th>no</th><th>title</th><th>headline</th><th>date posted </th><th>Active</th><th>action</th></tr>
                      </thead><tbody>
          "; 
    $tampil=mysql_query("SELECT * FROM tb_article ORDER BY tanggal DESC ");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
      $tgl_posting=tgl_indo($r['tanggal']);
    if ($r['fl_active'] == '1'){
      $blokir="<label class='badge badge-success'>Active</label>";
    }else{
      $blokir="<label class='badge badge-danger'>Not Active</label>";
    }

       echo "<tr><td>$no</td>
        <td>".substr($r['judul'],0,30)."...</td>
        <td>$r[headline]</td>
        <td>$tgl_posting</td>
      <td>$blokir</td>";   
     echo "
             <td><a href=?module=artikel&act=editartikel&id=$r[id_article] title='Edit'><button type='button' class='btn btn-dark btn-fw'>
                          <i class='mdi mdi-cloud-download'></i>Edit</button></a>  
          <a href=$aksi?module=artikel&act=hapus&id=$r[id_article] title='Delete'><button type='button' class='btn btn-danger btn-fw'> X Delete</button></a>
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