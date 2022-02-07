<script language ="javascript">
function CekField()
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
  /*
  if (document.formData.fupload.value=="")
  {
    alert("Imgpath Harus diinput !!!");
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
$aksi="pages/view/mod_news/aksi_news.php";
if (isset($_GET['act'])){
    switch($_GET['act']){
  // Tampil users_group
    // Tampil User
  default:
   
    break;
  
  case "tambahnews":  
  echo "<h2>New News</h2>
     <form method=POST action='$aksi?module=news&act=input' enctype='multipart/form-data' id='FormData' onSubmit='return CekField();' name=formData>
      <table class='hovertable'>
      <tr><td width=70>Title</td><td><input type=text name='Title' size=100% class='required'></td></tr>
      <tr><td width=70>Title Id</td><td><input type=text name='Title_id' size=100% class='required'></td></tr>
      <tr><td width=70>Date Posted</td><td><input type=text name='Date' size='100%'  class='datepicker'></td></tr>
      <tr><td>Content</td><td><textarea id='loko' name='Detail'  style='width: 710px; height: 350px;'></textarea></td></tr>
      <tr><td>Content Id</td><td><textarea id='loko2' name='Detail_id'  style='width: 710px; height: 350px;'></textarea></td></tr>
      <tr><td>Image</td><td><input type=file name='fupload' size=40><br>Tipe gambar harus JPG/JPEG dan ukuran lebar maks: 400 px</td></tr>";
            
      echo "
      <tr><td colspan=2><input type=submit value=Save>
        <input type=button value=Cancel onclick=self.history.back()></td></tr>
      </table>
    </form>";
      break;

   
  
}}
else{
  echo "<h2>Gallery List</h2>
  </div>
          <button  style='margin-bottom:15px' type='button' onclick=\"window.location.href='?module=news&act=tambahnews ';\" class='btn btn-primary btn-fw'> <i class='mdi mdi-file-plus'></i>Add Gallery</button>
          

          <table id='table_id' style='margin-top:15px' class='table table-striped table-bordered '>
                      <thead>
                        <tr><th>no</th><th>title</th><th>date posted </th><th>Image </th><th>Active</th><th>action</th></tr>
                      </thead><tbody>
          "; 
    $tampil=mysql_query("SELECT * FROM tb_article order by gal ");
    $no=1;
    while ($r=mysql_fetch_array($tampil)){
      $tgl_posting=tgl_indo($r['Date']);
    if ($r['fl_active'] == '1'){
      $blokir="<label class='badge badge-success'>Active</label>";
    }else{
      $blokir="<label class='badge badge-danger'>Not Active</label>";
    }

       echo "<tr><td>$no</td>
        <td>".substr($r['Title'],0,30)."...</td>
        <td>$tgl_posting</td>
      <td align='center'><img src='../$r[Imgpath]'/></td>
      <td>$blokir</td>";   
     echo "
             <td><a href=?module=news&act=editnews&id=$r[gal] title='Edit'><button type='button' class='btn btn-dark btn-fw'>
                          <i class='mdi mdi-cloud-download'></i>Edit</button></a>  
          <a href=$aksi?module=news&act=hapus&id=$r[gal] title='Delete'><button type='button' class='btn btn-danger btn-fw'> X Delete</button></a>
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