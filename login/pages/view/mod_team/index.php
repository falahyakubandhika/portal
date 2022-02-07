<script language ="javascript">
function CekField()
{
  if (document.formData.team_title.value=="")
  {
    alert("Nama Harus diinput !!!");
    document.formData.team_title.focus();
    return false;
  } 
    if (document.formData.Date.value=="")
  {
    alert("Date Harus diinput !!!");
    document.formData.Date.focus();
    return false;
  }
  /*
  if (document.formData.fupload.value=="")
  {
    alert("team_img Harus diinput !!!");
    document.formData.fupload.focus();
    return false;
  }
  */
   return true;
}
function CekUpdate()
{
  if (document.formData.Title.value=="")
  {
    alert("Title Harus diinput !!!");
    document.formData.Title.focus();
    return false;
  } 
    if (document.formData.Date.value=="")
  {
    alert("Date Harus diinput !!!");
    document.formData.Date.focus();
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
$aksi="pages/view/mod_team/aksi_team.php";
if (isset($_GET['act'])){
    switch($_GET['act']){
  // Tampil users_group
    // Tampil User
  default:
   
    break;
  
  case "tambahteam":  
  echo "<h2>New Team</h2>
    <form method=POST action='$aksi?module=team&act=input' enctype='multipart/form-data' id='FormData' onSubmit='return CekField();' name=formData>
      <table class='hovertable'>
      <tr><td width=70>Nama</td><td> : <input type=text name='team_title' size=100% class='required'></td></tr>
      <tr><td width=70>Kategori</td><td> : 
      <select name='team_cat'>
       		<option value=''>- Pilih Merk -</option>
     		<option value='1'>Komisaris</option>
			<option value='2'>Direktur</option>
			<option value='3'>Manager</option>
		</select></td></tr>
       <tr><td width=70>Jabatan</td><td> : <input type=text name='team_position' size=100% class='required'></td></tr>
      <tr><td>Image</td><td><input type=file name='fupload' size=40><br>Tipe gambar harus JPG/JPEG dan ukuran lebar maks: 400 px</td></tr>";
            
      echo "
      <tr><td colspan=2><input type=submit value=Save>
        <input type=button value=Cancel onclick=self.history.back()></td></tr>
      </table>
    </form>";
      break;

   case "editteam":
      echo "<h2> Edit Our Business </h2>";
    
    $edit = mysql_query("SELECT * FROM tb_team WHERE team_id='$_GET[team_id]'");
    $r    = mysql_fetch_array($edit);

    echo "<form method=POST action='$aksi?module=team&act=update' enctype='multipart/form-data' id='Form'  onSubmit='return CekUpdate();' name=formData>
      <input type=hidden name='team_id' value=$r[team_id]>
      <table class='hovertable'>
      <tr><td width=70>Nama</td><td><input type=text name='team_title' size=60 class='required' value='$r[team_title]'></td></tr>
      <tr><td width=70>Kategori</td><td> : 
      <select name='team_cat'>
       		<option value=''>- Pilih Merk -</option>
     		<option value='1' "; if($r[team_cat] == 1) {echo 'selected'; } echo ">Komisaris</option>
			<option value='2' "; if($r[team_cat] == 2) {echo 'selected'; } echo ">Direktur</option>
			<option value='3' "; if($r[team_cat] == 3) {echo 'selected'; } echo ">Manager</option>
		</select></td></tr>
      <tr><td width=70>Jabatan</td><td><input type=text name='team_position' size=60 class='required' value='$r[team_position]'></td></tr>";
     
      echo "<tr><td>Gambar</td><td>";
      if ($r['team_img']!=''){
        $real_team_img = $r['team_img'];//str_replace("images/team/","",$r[team_img]);
        $real_team_img = "../".trim($real_team_img);
        $team_img_small = "../images/team/small_".$real_team_img;
        echo "<img src='".$real_team_img."' width='100'/>";
        echo "<a href='$aksi?module=team&act=hapusgambar&team_id=$r[team_id]&namafile=$r[team_img]'><img src='images/cross.png' class='tombol'></a>";
      }
      echo "</td></tr>
      <tr><td>Ganti Gbr</td><td><input type=file name='fupload' size=30> *)</td></tr>
      <tr><td colspan=2>*) Apabila Gambar tidak diubah, dikosongkan saja.</td></tr>
      ";  
         
      
      echo "</td></tr>
      <tr><td colspan=2><input type=submit value=Save>
      <input type=button value=Cancel onclick=self.history.back()></td></tr>
    </table></form>";
    break;   
  
}}
else{
  echo "<h2>Team List</h2>
  </div>
          <button  style='margin-bottom:15px' type='button' onclick=\"window.location.href='?module=team&act=tambahteam ';\" class='btn btn-primary btn-fw'> <i class='mdi mdi-file-plus'></i>Add Team</button>
          

          <table id='table_id' style='margin-top:15px' class='table table-striped table-bordered '>
                      <thead>
                        <tr><th>ID</th><th>Nama</th><th>Jabatan</th><th>Foto</th><th>Action</th></tr>
                      </thead><tbody>
          "; 
    $tampil=mysql_query("SELECT * FROM tb_team order by team_id ");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
      $team_id = $r['team_id'];
		$team_title = $r['team_title'];
		$team_position = $r['team_position'];
		$team_img =  $r['team_img'];

       echo "<tr><td>$no</td>
        <td>$team_title</td>
        <td>$team_position</td>
      <td align='center'><img src='../$team_img'/></td>
      ";   
     echo "
             <td><a href=?module=team&act=editteam&team_id=$r[team_id] title='Edit'><button type='button' class='btn btn-dark btn-fw'>
                          <i class='mdi mdi-cloud-download'></i>Edit</button></a>  
          <a href=$aksi?module=team&act=hapus&team_id=$r[team_id] title='Delete'><button type='button' class='btn btn-danger btn-fw'> X Delete</button></a>
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