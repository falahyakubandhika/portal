
<div class="content-wrapper">
          
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card ">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    
                 <style>

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>


<h2>Company Profile</h2>
<p>Click on the buttons inside the tabbed menu:</p>

<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'tab1')">Company</button>
  <button class="tablinks" onclick="openCity(event, 'tab2')">Welcome Message</button>
  <button class="tablinks" onclick="openCity(event, 'tab3')">Our Team</button>

  <button class="tablinks" onclick="openCity(event, 'tab4')">Meta</button>

 
</div>



<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
                      
                      <?php
$aksi="pages/view/mod_profil/aksi_profil.php";
 
    $sql  = mysql_query("SELECT * FROM company where id=1 limit 1");
    $r    = mysql_fetch_array($sql);

  $image = $r['gambar'];
  $real_gambar = str_replace("images/logo/","",$image);
  $real_gambar = trim($real_gambar);             
  echo "<div id='tab1' class='tabcontent'>";
  echo "<form method=POST enctype='multipart/form-data' action=$aksi?module=profil&act=update>
      <input type=hidden name=id value=$r[id]>
      <table>
      <tr><td>Nama Perusahaan </td><td><input type=text name='nama_perusahaan' value='$r[nama_perusahaan]' size=50></td></tr>
      <tr><td>Website </td><td><input type=text name='website' value='$r[website]' size=80></td></tr>
      <tr><td>Alamat En</td><td><textarea name='alamat' style='width: 680px; height:100px;' id='loko'>$r[alamat]</textarea></td></tr>
       <tr><td>Alamat Id</td><td><textarea name='alamat_id' style='width: 680px; height:100px;' id='loko2'>$r[alamat_id]</textarea></td></tr>
      <tr><td>Facebook </td><td><input type=text name='facebook' value='$r[facebook]' size=80></td></tr>
      <tr><td>Instagram </td><td><input type=text name='instagram' value='$r[instagram]' size=80></td></tr>
      <tr><td>Twitter </td><td><input type=text name='twitter' value='$r[twitter]' size=80></td></tr>
      <tr><td>Youtube </td><td><input type=text name='youtube' value='$r[youtube]' size=80></td></tr>
      <tr><td>Email </td><td><input type=text name='email_pengelola' value='$r[email_pengelola]' size=80></td></tr>
      <tr><td>Phone </td><td><input type=text name='nomor_tlp' value='$r[nomor_tlp]' size=60></td></tr>
      <tr><td>Fax </td><td><input type=text name='nomor_fax' value='$r[nomor_fax]'></td></tr>
      <tr><td>Logo </td><td><img src='../$image' style='max-width:300px;'></td></tr>
      <tr><td>New Logo </td><td><input type=file name='fupload' size=60>
      <tr><td colspan=2>*) Apabila file tidak diubah, dikosongkan saja.</td></tr>
      <tr><td colspan=2><input type=submit value=Save  class='button'>
      <input type=button value=Batal onclick=self.history.back()  class='button'></td></tr>
    </form></table>
  </div>";
  echo "<div id='tab2' class='tabcontent'>";
    echo" <form method=POST enctype='multipart/form-data' action=$aksi?module=profil&act=updatewm>
      <input type=hidden name=id value=$r[id]>
      <table style='width:100%;'>
      <tr><td><textarea name='wlcmessage' style='width:100%;height:400px;' id='loko3'>$r[wlcmessage]</textarea></td></tr>
      <tr><td><input type=submit value=Save class='button'>
      <input type=button value=Batal onclick=self.history.back() class='button'></td></tr>
    </form></table>";
  echo"</div>";
  echo "<div id='tab3' class='tabcontent'>";
    echo" <form method=POST enctype='multipart/form-data' action=$aksi?module=profil&act=updateou>
      <input type=hidden name=id value=$r[id]>
      <table style='width:100%;'>
      <tr><td><textarea name='ourteam' style='width:100%;height:400px;' id='loko4'>$r[wlcmessageEng]</textarea></td></tr>
      <tr><td><input type=submit value=Save class='button'>
      <input type=button value=Batal onclick=self.history.back() class='button'></td></tr>
    </form></table>";
  echo"</div>";
  echo "<div id='tab4' class='tabcontent'>";
    echo" <form method=POST enctype='multipart/form-data' action=$aksi?module=profil&act=updatemeta>
      <input type=hidden name=id value=$r[id]>
      <table>
      <tr><td>meta_title</td><td> <input type=text name='meta_title' value='$r[meta_title]' size=100></td></tr>
      <tr><td>meta_description</td><td><textarea name='meta_description' style='width: 600px;'>$r[meta_description]</textarea></td></tr>
      <tr><td>meta_keywords</td><td><textarea name='meta_keywords' style='width: 600px;'>$r[meta_keywords]</textarea></td></tr>
      <tr><td>meta_abstract</td><td><textarea name='meta_abstract' style='width: 600px;'>$r[meta_abstract]</textarea></td></tr>
      <tr><td>meta_keyphrases</td><td><textarea name='meta_keyphrases' style='width: 600px;'>$r[meta_keyphrases]</textarea></td></tr>
      <tr><td>meta_mytopic</td><td><textarea name='meta_mytopic' style='width: 600px;'>$r[meta_mytopic]</textarea></td></tr>
      <tr><td>meta_revesit_after</td><td><input type='text' name='meta_revesit_after' style='width: 80px;' value='$r[meta_revesit_after]'></td></tr>
      <tr><td>meta_robots</td><td><input type='text' name='meta_robots' style='width: 600px;' value='$r[meta_robots]'></td></tr>
      <tr><td>meta_distribution</td><td><input type='text' name='meta_distribution' style='width: 600px;' value='$r[meta_distribution]'></td></tr>
      <tr><td>meta_classification</td><td><textarea name='meta_classification' style='width: 600px;'>$r[meta_classification]</textarea></td></tr>
      <tr><td colspan=2><input type=submit value=Save class='button'>
      <input type=button value=Batal onclick=self.history.back() class='button'></td></tr>
    </form></table>";
  echo"</div>";
?>

                  </div>
                  
                </div>
              </div>
            
          </div>
         
  </div>