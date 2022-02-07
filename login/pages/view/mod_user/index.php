
<div class="content-wrapper">
          
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card ">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    
                 
                      
                      <?php
$aksi="pages/view/mod_user/aksi_users.php";
if (isset($_GET['act'])){
    switch($_GET['act']){
  // Tampil users_group
    // Tampil User
  default:
   $tampil = mysql_query("SELECT * FROM users ORDER BY username");
   echo "<h2>User</h2>
          <input type=button value='Tambah User' onclick=\"window.location.href='?module=user&act=tambahuser';\">";
   echo "<table>
          <tr><th>no</th><th>username</th><th>nama lengkap</th><th>email</th><th>No.Telp/HP</th><th>Marketing</th><th>Blokir</th><th>aksi</th></tr>"; 
   $no=1;
   while ($r=mysql_fetch_array($tampil)){
      if ($r['blokir'] == 'Y'){
      $blokir="<img src='images/aktif.png' class='tombol'>";
    }else{
      $blokir="<img src='images/nonaktif.png' class='tombol'>";
    }

       echo "<tr><td>$no</td>
             <td>$r[username]</td>
             <td>$r[nama_lengkap]</td>
             <td><a href=mailto:$r[email]>$r[email]</a></td>
             <td>$r[no_telp]</td>
         <td align=center>$r[is_marketing]</td>
             <td align=center><a href=$aksi?module=user&act=blokir&id=$r[id_user]&blokir=$r[blokir]>$blokir</a></td>
             <td><a href=?module=user&act=edituser&id=$r[id_session] title='Edit'><img src='images/user_edit.png' class='tombol'></a></td></tr>";
      $no++;
    }
    echo "</table>";
    break;
  
  case "tambahuser":
    echo "<h2>Tambah User</h2>
          <form method=POST action='$aksi?module=user&act=input' id='Form'>
          <table>
      <tr><td>Group User</td>  <td> : 
          <select name='usergroup'>
            <option value=0 selected>- User Group -</option>";
            $sql=mysql_query("SELECT * FROM users_group where aktif='Y' order by id_user_group");
            while($a=mysql_fetch_array($sql)){
              echo "<option value=$a[id_user_group]>$a[nama_user_group]</option>";
            }
    echo "</select>
      </td></tr>

          <tr><td>Username</td>     <td> : <input type=text name='username' class='required'></td></tr>
          <tr><td>Password</td>     <td> : <input type=text name='password' class='required'></td></tr>
          <tr><td>Nama Lengkap</td> <td> : <input type=text name='nama_lengkap' size=30 class='required'></td></tr>  
          <tr><td>E-mail</td>       <td> : <input type=text name='email' size=30 id='email' class='required email'></td></tr>
          <tr><td>No.Telp/HP</td>   <td> : <input type=text name='no_telp' size=20 class='required'></td></tr>
          <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
    
  case "edituser":
    $edit=mysql_query("SELECT * FROM users WHERE id_session='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit User</h2>
          <form method='POST' action='$aksi?module=user&act=update' id='Form'>
          <input type=hidden name=id value='$r[id_session]'>
          <table>
          <tr><td>Menu</td>  <td> : <select name='usergroup'>";
      echo "<option value=0 selected>- User Group -</option>";
      $sql=mysql_query("SELECT * FROM users_group ORDER BY id_user_group"); 
          while($w=mysql_fetch_array($sql)){
            if ($r[id_user_group]==$w[id_user_group]){
              echo "<option value=$w[id_user_group] selected>$w[nama_user_group]</option>";
            }
            else{
              echo "<option value=$w[id_user_group]>$w[nama_user_group]</option>";
            }
          }

    echo "</select>
       </td></tr>          
          <tr><td>Username</td>     <td> : <input type=text class='required' name='username' value='$r[username]' disabled> **)</td></tr>
          <tr><td>Password</td>     <td> : <input type=text name='password'> *) </td></tr>
          <tr><td>Nama Lengkap</td> <td> : <input type=text class='required' name='nama_lengkap' size=30  value='$r[nama_lengkap]'></td></tr>
          <tr><td>E-mail</td>       <td> : <input type=text name='email' size=30 value='$r[email]' id='email' class='required email'></td></tr>
          <tr><td>No.Telp/HP</td>   <td> : <input type=text class='required' name='no_telp' size=30 value='$r[no_telp]'></td></tr>";

    if ($r['blokir']=='N'){
      echo "<tr><td>Blokir</td>     <td> : <input type=radio name='blokir' value='Y'> Y   
                                           <input type=radio name='blokir' value='N' checked> N </td></tr>";
    }
    else{
      echo "<tr><td>Blokir</td>     <td> : <input type=radio name='blokir' value='Y' checked> Y  
                                          <input type=radio name='blokir' value='N'> N </td></tr>";
    }
    echo "<tr><td colspan=2>*) Apabila password tidak diubah, dikosongkan saja.<br />
                            **) Username tidak bisa diubah.</td></tr>
          <tr><td colspan=2><input type='submit' value='Update'>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";     

    break;

    case "deleteuser":
    $edit=mysql_query("SELECT * FROM users WHERE id_session='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Delete User</h2>
          <form method='POST' action='$aksi?module=user&act=delete' id='Form'>
          <input type=hidden name=id value='$r[id_session]'>
          Are you sure delete user <b>$r[username]</b> ? <br>
          <input type='submit' value='Delete'>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </form>";     

    break;    
  
}}
else{
  echo "<h2>User List</h2>
  </div>
          <button  style='margin-bottom:15px' type='button' onclick=\"window.location.href='?module=user&act=tambahuser';\" class='btn btn-primary btn-fw'> <i class='mdi mdi-file-plus'></i>Add User</button>
          

          <table id='table_id' style='margin-top:15px' class='table table-striped table-bordered '>
                      <thead>
                        <tr>
                          <th>no</th>
                          <th>username</th>
                          <th>nama lengkap</th>
                          <th>email</th>
                          <th>No.Telp/HP</th>
                          <th>Status</th>
                          <th>aksi</th>
                        </tr>
                      </thead><tbody>
          "; 
    $tampil=mysql_query("SELECT * FROM users ORDER BY username");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
    if ($r['blokir'] == 'N'){
      $blokir="<label class='badge badge-success'>Active</label>";
    }else{
      $blokir="<label class='badge badge-danger'>Not Active</label>";
    }

       echo "<tr><td>$no</td>
             <td>$r[username]</td>
             <td>$r[nama_lengkap]</td>
             <td><a href=mailto:$r[email]>$r[email]</a></td>
             <td>$r[no_telp]</td>";   
     echo "<td align='center'>$blokir</td>
             <td><a href=?module=user&act=edituser&id=$r[id_session] title='Edit'><button type='button' class='btn btn-dark btn-fw'>
                          <i class='mdi mdi-cloud-download'></i>Edit</button></a>  
          <a href=?module=user&act=deleteuser&id=$r[id_session] title='Delete'><button type='button' class='btn btn-danger btn-fw'> X Delete</button></a>
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