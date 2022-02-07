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
$aksi="pages/view/mod_award/aksi_artikel.php";
if (isset($_GET['act'])){
    switch($_GET['act']){
  // Tampil users_group
    // Tampil User
  default:
   
    break;
  
  case "tambahartikel": 
  echo "<h2>New Award</h2>
    <form method=POST action='$aksi?module=award&act=input' enctype='multipart/form-data' id='FormData' onSubmit='return CekField();' name=formData>
      <table class='hovertable'>
      <tr><td width=70>Title</td><td><input type=text name='judul' size=60 class='required'></td></tr>
      <tr><td width=70>Title Id</td><td><input type=text name='judul_id' size=60 class='required'></td></tr>
      <tr><td width=70>Date Posted</td><td><input type=text name='tanggal' size='20'  class='datepicker'></td></tr>
      <tr><td>Headline</td>
        <td><input type=radio name='headline' value='Y' checked>Y  
          <input type=radio name='headline' value='N'> N 
        </td>
      </tr>
      <tr><td>Headline Text</td><td> <textarea name='cuplikan' style='width: 710px; height: 50px;'></textarea></td></tr>
      <tr><td>Content</td><td><textarea id='loko' name='isi_artikel'  style='width: 710px; height: 350px;'></textarea></td></tr>
      <tr><td>Content Id</td><td><textarea id='loko2' name='isi_artikel_id'  style='width: 710px; height: 350px;'></textarea></td></tr>
      <tr><td>Image</td><td><input type=file name='fupload' size=40><br>Tipe gambar harus JPG/JPEG dan ukuran lebar maks: 400 px</td></tr>
      <tr><td width=70>Link Video</td><td><input type=text name='link_video' size=100 class='required'></td></tr>
      <tr><td colspan=2><input type=submit value=Save>
        <input type=button value=Cancel onclick=self.history.back()></td></tr>
      </table>
    </form>";
      break;

   case "editartikel":
      echo "<h2> Edit Award </h2>";
    
    $edit = mysql_query("SELECT * FROM tb_award WHERE id_article='$_GET[id]' AND username='$_SESSION[namauser]'");
    $r    = mysql_fetch_array($edit);
    echo "<form method=POST action='$aksi?module=award&act=update' enctype='multipart/form-data' id='Form'  onSubmit='return CekUpdate();' name=formData>
      <input type=hidden name=id value=$r[id_article]>
      <table class='hovertable'>
      <tr><td width=100>Title</td><td><input type=text name='judul' size=60 class='required' value='$r[judul]'></td></tr>
      <tr><td width=100>Title Id</td><td><input type=text name='judul_id' size=60 class='required' value='$r[judul_id]'></td></tr>
      <tr><td width=100>Date Posted</td><td><input type=text name='tanggal' size='20' value='$r[tanggal]' class='datepicker'></td></tr>";
      if ($r['headline']=='Y'){
        echo "<tr><td>Headline</td><td><input type=radio name='headline' value='Y' checked>Y  
        <input type=radio name='headline' value='N'> N";
      } else {
        echo "<tr><td>Headline</td><td><input type=radio name='headline' value='Y'>Y  
        <input type=radio name='headline' value='N' checked>N";
      }
      echo "</td></tr>";
      echo "<tr><td>Headline Text</td>  <td> <textarea name='cuplikan'  style='width: 710px; height: 50px;' >$r[headlinetext]</textarea></td></tr>
      <tr><td>Content</td>  <td> <textarea id='loko' name='isi_artikel'  style='width: 710px; height: 350px;'>$r[isi_berita]</textarea></td></tr>
      <tr><td>Content Id</td>  <td> <textarea id='loko2' name='isi_artikel_id'  style='width: 710px; height: 350px;'>$r[isi_berita_id]</textarea></td></tr>";
      echo "<tr><td>Gambar</td><td>";
      if ($r['gambar']!=''){
        $real_gambar = str_replace("images/article/","",$r['gambar']);
        $real_gambar = trim($real_gambar);
        $gambar_small = "../images/article/small_".$real_gambar;
        echo "<img src='".$gambar_small."'/>";
        echo "<a href='$aksi?module=award&act=hapusgambar&id=$r[id_article]&namafile=$r[gambar]'><img src='images/cross.png' class='tombol'></a>";
      }
      echo "</td></tr>
      <tr><td>Ganti Gbr</td><td><input type=file name='fupload' size=30> *)</td></tr>
      <tr><td colspan=2>*) Apabila gambar tidak diubah, dikosongkan saja.</td></tr>
      <tr><td width=70>Link Video</td><td><input type=text name='link_video' size=100 class='required' value='$r[link_video]'></td></tr>";  
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
  echo "<h2>Award List</h2>
  </div>
          <button  style='margin-bottom:15px' type='button' onclick=\"window.location.href='?module=award&act=tambahartikel ';\" class='btn btn-primary btn-fw'> <i class='mdi mdi-file-plus'></i>Add Award</button>
          

          <table id='table_id' style='margin-top:15px' class='table table-striped table-bordered '>
                      <thead>
                        <tr><th>no</th><th>title</th><th>headline</th><th>date posted </th><th>Active</th><th>action</th></tr>
                      </thead><tbody>
          "; 
    $tampil=mysql_query("SELECT * FROM tb_award ORDER BY tanggal DESC ");
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
             <td><a href=?module=award&act=editartikel&id=$r[id_article] title='Edit'><button type='button' class='btn btn-dark btn-fw'>
                          <i class='mdi mdi-cloud-download'></i>Edit</button></a>  
          <a href=$aksi?module=award&act=hapus&id=$r[id_article] title='Delete'><button type='button' class='btn btn-danger btn-fw'> X Delete</button></a>
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