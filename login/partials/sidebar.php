  <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <!--<li class="nav-item nav-profile">
            <div class="nav-link">
              <div class="user-wrapper">
                <!--<div class="profile-image">
                  <img src="images/faces/face1.jpg" alt="profile image">
                </div>
                <div class="text-wrapper">
                  <p class="profile-name"><?php echo $_SESSION['namauser']  ;?></p>
                  
                </div>
              </div>
             <!-- <button class="btn btn-success btn-block">New Project
                <i class="mdi mdi-plus"></i>
              </button>
            </div>
          </li>-->
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <?php 
$id_leveluser = ($_SESSION['id_leveluser']);
$leveluser = ($_SESSION['leveluser']);
$sql = mysql_query("SELECT * from modul where link='#' and publish='Y'");  
$cek=mysql_num_rows($sql);
if ($cek > 0 ){
  $num = 1;
   while ($row=mysql_fetch_assoc($sql))
    { 
      $h_title = $row['nama_modul'];
      $h_id = $row['id_modul'];
      
      echo '
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth'.$num.'" aria-expanded="false" aria-controls="auth">
              <i class="menu-icon mdi mdi-restart"></i>
              <span class="menu-title">'. $h_title .'</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth'.$num.'">
              <ul class="nav flex-column sub-menu">';
$ssql=mysql_query("SELECt * from modul where id_group=$h_id and publish='Y' order by nama_modul ASC");
$scek=mysql_num_rows($ssql);
if($scek>0){
  while ($row=mysql_fetch_assoc($ssql))
  {
    $mod_title = $row['nama_modul'];
    $mod_link = $row['link'];
    echo '          
                <li class="nav-item">
                  <a class="nav-link" href="?module='.$mod_link.'"> '.$mod_title.' </a>
                </li>';
  }
}  


                
echo      '</ul>
            </div>
          </li>';
          $num++;
        }
}
            
?>
         <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Basic UI Elements</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="pages/ui-features/typography.html">Typography</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/forms/basic_elements.html">
              <i class="menu-icon mdi mdi-backup-restore"></i>
              <span class="menu-title">Form elements</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/charts/chartjs.html">
              <i class="menu-icon mdi mdi-chart-line"></i>
              <span class="menu-title">Charts</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/tables/basic-table.html">
              <i class="menu-icon mdi mdi-table"></i>
              <span class="menu-title">Tables</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/icons/font-awesome.html">
              <i class="menu-icon mdi mdi-sticker"></i>
              <span class="menu-title">Icons</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="menu-icon mdi mdi-restart"></i>
              <span class="menu-title">User Pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="pages/samples/login.html"> Login </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="pages/samples/register.html"> Register </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="pages/samples/error-404.html"> 404 </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="pages/samples/error-500.html"> 500 </a>
                </li>
              </ul>
            </div>
          </li>-->
        </ul>
      </nav>