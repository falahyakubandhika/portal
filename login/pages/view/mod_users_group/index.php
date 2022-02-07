
<div class="content-wrapper">
          
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card ">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    
                 
                      
                      <?php
$aksi="pages/view/mod_users_group/aksi_users_group.php";
if (isset($_GET['act'])){
    switch($_GET['act']){
  // Tampil users_group
  default:
    echo "<h2>Group User</h2>
          <button style='margin-bottom:15px' type='button' onclick=\"window.location.href='?module=users_group&act=tambahgroup';\" class='btn btn-primary btn-fw'>Add Group</button>

          <table id='table_id'  class='table table-striped table-bordered '>
                      <thead>
                        <tr>
                          <th>
                            No
                          </th>
                          <th>
                            Name Group
                          </th>
                          <th>
                            Status
                          </th>
                          <th>
                            Action
                          </th>
                         </tr>
                      </thead>
          "; 
    $tampil=mysql_query("SELECT * FROM users_group ORDER BY id_user_group");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
    if ($r['aktif'] == 'Y'){
      $aktif="<label class='badge badge-success'>Active</label>";
    }else{
      $aktif="<label class='badge badge-danger'>Not Active</label>";
    }

       echo "<tr><td>$no</td>
             <td>$r[nama_user_group]</td>";   
     echo "<td align='center'><!--<a href=$aksi?module=users_group&act=aktifnonaktif&id=$r[id_user_group]&aktif=$r[aktif]>-->$aktif<!--</a>--></td>
             <td><a href=?module=users_group&act=editgroup&id=$r[id_user_group] title='Edit'><button type='button' class='btn btn-dark btn-fw'>
                          <i class='mdi mdi-cloud-download'></i>Edit</button></a>  
          
           <a href=?module=users_group&act=permissions&id=$r[id_user_group] title='Permissions'><button type='button' class='btn btn-secondary btn-fw'>
                          <i class='mdi mdi-file-document'></i>Permision</button></td>";
     //<a href=$aksi?module=users_group&act=hapus&id=$r[id_user_group] title='Hapus' class='ask'><img src='images/trash.png' class='tombol'></a>  
    echo "</tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  // Form Tambah users_group
  case "tambahgroup":
    echo "<h2  style='margin-bottom:25px'>Tambah Group User</h2>

            <form class='forms-sample' method='POST' action='$aksi?module=users_group&act=input'>
                       
                        <div class='form-group'>
                          <label for='exampleInputEmail1'>Nama User Group : </label>
                          <input type='text' class='form-control' name='nama_user_group'>
                        </div>
                        <div class='col-md-6'>
                        <div class='form-group row'>
                         <label >Aktif : </label>
                          <div class='col-sm-4'>
                            <div class='form-radio'>
                              <label class='form-check-label'>
                                <input type='radio' class='form-check-input' name='aktif' id='membershipRadios1' value='Y' checked> Active
                              </label>
                            </div>
                          </div>
                          <div class='col-sm-5'>
                            <div class='form-radio'>
                              <label class='form-check-label'>
                                <input type='radio' class='form-check-input' name='aktif' id='membershipRadios2' value='N'> Not Active
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
 <input type=submit name=submit value=Simpan  class='btn btn-success mr-2'>
                            <input type=button value=Batal onclick=self.history.back()  class='btn btn-light mr-2'>
                      </form>
        ";
     break;
  
  // Form Edit users_group  
  case "editgroup":
    $edit=mysql_query("SELECT * FROM users_group WHERE id_user_group='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "
          <h2 style='margin-bottom:25px' >Edit Group User</h2>
                      
                      <form class='forms-sample' method='POST' action='$aksi?module=users_group&act=update'>
                        <input type=hidden name=id value='$r[id_user_group]'>
                        <div class='form-group'>
                          <label for='exampleInputEmail1'>Nama User Group : </label>
                          <input type='text' class='form-control' name='nama_user_group' value='$r[nama_user_group]'>
                        </div>
                        
                        ";
if ($r['aktif']=='Y'){echo "
                      <div class='col-md-6'>
                        <div class='form-group row'>
                         <label >Aktif : </label>
                          <div class='col-sm-4'>
                            <div class='form-radio'>
                              <label class='form-check-label'>
                                <input type='radio' class='form-check-input' name='aktif' id='membershipRadios1' value='Y' checked> Active
                              </label>
                            </div>
                          </div>
                          <div class='col-sm-5'>
                            <div class='form-radio'>
                              <label class='form-check-label'>
                                <input type='radio' class='form-check-input' name='aktif' id='membershipRadios2' value='N'> Not Active
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                          
                          ";}else{
                              echo "
                        <div class='col-md-6'>
                        <div class='form-group row'>
                         <label >Aktif : </label>
                          <div class='col-sm-4'>
                            <div class='form-radio'>
                              <label class='form-check-label'>
                                <input type='radio' class='form-check-input' name='aktif' id='membershipRadios1' value='Y' checked> Active
                              </label>
                            </div>
                          </div>
                          <div class='col-sm-5'>
                            <div class='form-radio'>
                              <label class='form-check-label'>
                                <input type='radio' class='form-check-input' name='aktif' id='membershipRadios2' value='N' checked> Not Active
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                          ";

                          }
  
                          
                        echo"</div>
                        <input type=submit value=Update  class='btn btn-success mr-2'>
                            <input type=button value=Batal onclick=self.history.back()  class='btn btn-light mr-2'>
                      </form>

        ";
    
  
    break;  
  
  // Form Edit users_group  
  case "permissions":
    $edit=mysql_query("SELECT * FROM users_group WHERE id_user_group='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Permision <b style='color:red;'>$r[nama_user_group]</b></h2>";
    
  echo"<input type=button value='Aktifkan Semua' onclick=\"window.location.href='$aksi?module=users_group&act=aktifnonaktifmenuall&id=$r[id_user_group]&aktif=Y';\">
     <input type=button value='Non Aktifkan Semua' onclick=\"window.location.href='$aksi?module=users_group&act=aktifnonaktifmenuall&id=$r[id_user_group]&aktif=N';\">
     <input type=button value=Back onclick=self.history.back()>
     <br><br>";
    
    echo"<div style='background-color:#ccc; padding:10px;'>";
        
    function html_menu(&$strmenu="", $parent=0) {
    
  
  $query ="SELECT MN.id_menu, MN.id_user_group, MN.id_modul, MN.aktif, MN.id_parent, 
                   MD.id_modul, MD.nama_modul  
                   FROM menu_admin MN
                   INNER JOIN modul MD ON MD.id_modul=MN.id_modul
                   INNER JOIN users_group UG ON UG.id_user_group=MN.id_user_group
                   WHERE MN.id_user_group='$_GET[id]' 
                   AND MN.id_parent='$parent'";
    //die ($query);
    $sql = mysql_query($query);
     
    if (mysql_num_rows($sql) > 0) {
    $strmenu .= '<ul >';
    }
     
    // tampilkan anaknya
    while ($row = mysql_fetch_assoc($sql)) {
     
    $strmenu .= "<li><span class='aktifnonaktif-ul'>";
    $strmenu .= sprintf("%s </span> <span class='aktifnonaktif'> <a href='modul/mod_users_group/aksi_users_group.php?module=users_group&act=aktifnonaktifmenu&id=%s&aktif=%s'>%s</a> </span>"
            , $row['nama_modul'], $row['id_menu'], $row['aktif'], $row['aktif'] );
     
    //panggil diri sendiri
    html_menu($strmenu, $row['id_modul']);
    $strmenu .= "</li>";
    }
     
    if (mysql_num_rows($sql) > 0)
    $strmenu .= '</ul>';
     
    }
     
    $strmenu = "";
    html_menu($strmenu, 0);
    echo $strmenu;        
        echo"</div>";
    break;    
  
}}
else{
  echo "<h2>Group User</h2>
  </div>
          <button  style='margin-bottom:15px' type='button' onclick=\"window.location.href='?module=users_group&act=tambahgroup';\" class='btn btn-primary btn-fw'> <i class='mdi mdi-file-plus'></i>Add Group</button>

          <table id='table_id' style='margin-top:15px' class='table table-striped table-bordered '>
                      <thead>
                        <tr>
                          <th>
                            No
                          </th>
                          <th>
                            Name Group
                          </th>
                          <th>
                            Status
                          </th>
                          <th>
                            Action
                          </th>
                         </tr>
                      </thead><tbody>
          "; 
    $tampil=mysql_query("SELECT * FROM users_group ORDER BY id_user_group");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
    if ($r['aktif'] == 'Y'){
      $aktif="<label class='badge badge-success'>Active</label>";
    }else{
      $aktif="<label class='badge badge-danger'>Not Active</label>";
    }

       echo "<tr><td>$no</td>
             <td>$r[nama_user_group]</td>";   
     echo "<td align='center'><!--<a href=$aksi?module=users_group&act=aktifnonaktif&id=$r[id_user_group]&aktif=$r[aktif]>-->$aktif<!--</a>--></td>
             <td><a href=?module=users_group&act=editgroup&id=$r[id_user_group] title='Edit'><button type='button' class='btn btn-dark btn-fw'>
                          <i class='mdi mdi-cloud-download'></i>Edit</button></a>  
          
           <a href=?module=users_group&act=permissions&id=$r[id_user_group] title='Permissions'><button type='button' class='btn btn-secondary btn-fw'>
                          <i class='mdi mdi-file-document'></i>Permision</button></a></td>";
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