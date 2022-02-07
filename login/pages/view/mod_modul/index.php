
<div class="content-wrapper">
          
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card ">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    
                 
                      
                      <?php
$aksi="pages/view/mod_modul/aksi_modul.php";
if (isset($_GET['act'])){
    switch($_GET['act']){
  // Tampil users_group
    // Tampil User
  default:
    echo "<h2>Modul</h2>
          <input type=button value='Tambah Modul' onclick=\"window.location.href='?module=modul&act=tambahmodul';\" class='button'><br /><br />
          <div id=paging>
          *) Apabila PUBLISH = Y, maka Modul ditampilkan di halaman pengunjung. <br />
          **) Apabila AKTIF = Y, maka Modul ditampilkan di halaman administrator pada daftar menu yang berada di bagian kiri.</div>
          <table>
          <tr><th>no</th><th>nama modul</th><th>link</th><th>link file</th><th>publish</th><th>aktif</th><th>status</th><th>aksi</th></tr>";
    $tampil=mysql_query("SELECT * FROM modul ORDER BY urutan");
    while ($r=mysql_fetch_array($tampil)){
    if ($r['aktif'] == 'Y'){
      $aktif="<img src='images/aktif.png' class='tombol'>";
    }else{
      $aktif="<img src='images/nonaktif.png' class='tombol'>";
    }

    if ($r['publish'] == 'Y'){
      $publish="<img src='images/aktif.png' class='tombol'>";
    }else{
      $publish="<img src='images/nonaktif.png' class='tombol'>";
    }


      echo "<tr><td>$r[urutan]</td>
            <td>$r[nama_modul]</td>
            <td><a href=?module=$r[link]>$r[link]</a></td>
      <td>$r[link_file]</td>
            <td align=center><a href=$aksi?module=modul&act=publish&id=$r[id_modul]&publish=$r[publish]>$publish</a></td>
            <td align=center><a href=$aksi?module=modul&act=aktifnonaktif&id=$r[id_modul]&aktif=$r[aktif]>$aktif</a></td>
            <td>$r[status]</td>
            <td><a href=?module=modul&act=editmodul&id=$r[id_modul]><img src='images/edit.png' class='tombol'></a>  
                <a href=$aksi?module=modul&act=hapus&id=$r[id_modul] class='ask'><img src='images/trash.png' class='tombol'></a>
            </td></tr>";
    }
    echo "</table>";
    break;

  case "tambahmodul":
    echo "<h2>Tambah Modul</h2>
          <form method=POST action='$aksi?module=modul&act=input'>
          <table>
          <tr><td>Nama Modul</td> <td> : <input type=text name='nama_modul'></td></tr>
          <tr><td>Menu</td>  <td> : 
          <select name='mainmenu'>
            <option value=0 selected>- Main Menu -</option>";
            $sql=mysql_query("SELECT * FROM modul where link='#' and id_group='0'  ORDER BY nama_modul ASC");
            while($a=mysql_fetch_array($sql)){
              echo "<option value=$a[id_modul]>$a[nama_modul]</option>";
            }
    echo "</select>
      </td></tr>
          <tr><td>Link</td>       <td> : <input type=text name='link' size=30></td></tr>
      <tr><td>Link File</td>       <td> : <input type=text name='link_file' size=100></td></tr>
          <tr><td>Publish</td>    <td> : <input type=radio name='publish' value='Y' checked>Y  
                                         <input type=radio name='publish' value='N'> N</td></tr>
          <tr><td>Aktif</td>      <td> : <input type=radio name='aktif' value='Y' checked>Y  
                                         <input type=radio name='aktif' value='N'> N</td></tr>
          <tr><td>Status</td>     <td> : <input type=radio name='status' value='admin' checked>admin 
                                         <input type=radio name='status' value='user'>user</td></tr>
      
          <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
 
  case "editmodul":
    $edit = mysql_query("SELECT * FROM modul WHERE id_modul='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

    echo "<h2>Edit Modul</h2>
          <form method=POST action=$aksi?module=modul&act=update>
          <input type=hidden name=id value='$r[id_modul]'>
          <table>
          <tr><td>Nama Modul</td>     <td> : <input type=text name='nama_modul' value='$r[nama_modul]'></td></tr>
          <tr><td>Menu</td>  <td> : <select name='mainmenu'>";

      echo "<option value=0 selected>- Main Menu -</option>";
      $sql=mysql_query("SELECT * FROM modul where link='#' AND id_group='0' ORDER BY id_modul");  
          while($w=mysql_fetch_array($sql)){
            if ($r[id_group]==$w[id_modul]){
              echo "<option value=$w[id_modul] selected>$w[nama_modul]</option>";
            }
            else{
              echo "<option value=$w[id_modul]>$w[nama_modul]</option>";
            }
          }

    echo "</select>
       </td></tr>          
       <tr><td>Link</td>     <td> : <input type=text name='link' size=30 value='$r[link]'></td></tr>
        <tr><td>Link File</td>       <td> : <input type=text name='link_file' size=100 value='$r[link_file]'></td></tr>";
    if ($r['publish']=='Y'){
      echo "<tr><td>Publish</td> <td> : <input type=radio name='publish' value='Y' checked>Y  
                                        <input type=radio name='publish' value='N'> N</td></tr>";
    }
    else{
      echo "<tr><td>Publish</td> <td> : <input type=radio name='publish' value='Y'>Y  
                                        <input type=radio name='publish' value='N' checked>N</td></tr>";
    }
    if ($r['aktif']=='Y'){
      echo "<tr><td>Aktif</td> <td> : <input type=radio name='aktif' value='Y' checked>Y  
                                      <input type=radio name='aktif' value='N'> N</td></tr>";
    }
    else{
      echo "<tr><td>Aktif</td> <td> : <input type=radio name='aktif' value='Y'>Y  
                                      <input type=radio name='aktif' value='N' checked>N</td></tr>";
    }
    if ($r['status']=='user'){
      echo "<tr><td>Status</td> <td> : <input type=radio name='status' value='user' checked>user  
                                       <input type=radio name='status' value='admin'> admin</td></tr>";
    }
    else{
      echo "<tr><td>Status</td> <td> : <input type=radio name='status' value='user'>user  
                                       <input type=radio name='status' value='admin' checked>admin</td></tr>";
    }
    echo "<tr><td>Urutan</td>       <td> : <input type=text name='urutan' size=1 value='$r[urutan]'></td></tr>
          <tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;    
  
}}
else{
  echo "<h2>Modul</h2>
  </div>
          <button  style='margin-bottom:15px' type='button' onclick=\"window.location.href='?module=modul&act=tambahmodul';\" class='btn btn-primary btn-fw'> <i class='mdi mdi-file-plus'></i>Add Modul</button>
          <div id=paging>
          *) Apabila PUBLISH = Y, maka Modul ditampilkan di halaman pengunjung. <br />
          **) Apabila AKTIF = Y, maka Modul ditampilkan di halaman administrator pada daftar menu yang berada di bagian kiri.</div>

          <table id='table_id' style='margin-top:15px' class='table table-striped table-bordered '>
                      <thead>
                        <th>no</th><th>nama modul</th><th>link</th><th>link file</th><th>publish</th><th>aktif</th><th>status</th><th>aksi</th>
                      </thead><tbody>
          "; 
    $tampil=mysql_query("SELECT * FROM modul ORDER BY urutan");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
    if ($r['publish'] == 'Y'){
      $publish="<label class='badge badge-success'>Active</label>";
    }else{
      $publish="<label class='badge badge-danger'>Not Active</label>";
    }

       echo "<tr><td>$no</td>
            <td>$r[nama_modul]</td>
            <td><a href=?module=$r[link]>$r[link]</a></td>
      <td>$r[link_file]</td>
            <td align=center><a href=$aksi?module=modul&act=publish&id=$r[id_modul]&publish=$r[publish]>$publish</a></td>
            <td align=center><a href=$aksi?module=modul&act=aktifnonaktif&id=$r[id_modul]&aktif=$r[aktif]>$publish</a></td>
            <td>$r[status]</td>
            <td><a href=?module=modul&act=editmodul&id=$r[id_modul]><img src='images/edit.png' class='tombol'></a>  
                <a href=$aksi?module=modul&act=hapus&id=$r[id_modul] class='ask'><img src='images/trash.png' class='tombol'></a>
            </td></tr>";
     
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