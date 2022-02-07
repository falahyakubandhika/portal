<?php
function BuatSandi($kataasli)
{
	$panjangasli = strlen($kataasli); 
	for ($i=0;$i < $panjangasli;$i++)
	{
		$huruf[$i] = substr($kataasli,$i,1);
	}

	$sandi[0]=rand(0,700);
	srand((double)microtime()*1000000);
	$acak = rand(0,8);
	$sSandi =($acak +1)* 1000 + $sandi[0];
	$sSandi = $sSandi . "" ;  	

	for ($i=1; $i<= $panjangasli;$i++)
	{
		$acak = rand(0,8);
		$sandi[$i]=($acak +1 )*1000 + $sandi[0] + ord($huruf[$i-1]); 
		$sSandi = $sSandi . $sandi[$i];
	}

	return $sSandi;
}

function PecahSandi($sSandi)
{
	$panjangsandi =strlen($sSandi);
	$panjangkata = ($panjangsandi/4) -1;
	$sandi[0]= substr($sSandi,0,4);
	$sandi[0]= $sandi[0] % 1000;
	$kataasli="";

	for ($i=1;$i<=$panjangkata;$i++)
	{
		$sandi[$i]= substr($sSandi,$i*4,4);
		$sandi[$i]= $sandi[$i] % 1000;
		$sandi[$i]= $sandi[$i] - $sandi[0]; 
		$kataasli = $kataasli . chr($sandi[$i]); 
	}

 	return $kataasli;
}

 function display_footer()
 {
 echo "<div class='follow'>
	<div class='followus'>
	<h5>Follow Us on the Social Sites  -  
		<a href='#'><img src='images/book_icon.png' alt='Book' /></a> 
		<a href='#'><img src='images/facebook_icon.png' alt='FaceBook' /></a> 
		<a href='#'><img src='images/twitter_icon.png' alt='Twitter' /></a> 
		<a href='#'><img src='images/rss_icon.png' alt='RSS' /></a>
	</h5>
	</div>
</div> ";

echo "<div id='footer_wrap'>
	<div id='footer'>
	<div class='f_img'></div>	
	

	<div class='footerlistbox'>
		<h4>PROFIL</h4>
			<ul>";
				$sqlP=mysql_query("SELECT * FROM tb_profile where aktif = 'Y'");
				while($r=mysql_fetch_array($sqlP)){
					echo"<li><a href='tentang.php?id=$r[id_profile]'>$r[judul]</a></li>";
				}
				/*
				<li><a href='visi.php'>Visi Misi</a></li>
				<li><a href='prioritas.php'>Prioritas</a></li>
				<li><a href='legal.php'>Aspek Legal</a></li>
				<li><a href='sdm.php'>SDM</a></li>
				*/
				echo"
			</ul>
		</div> ";
	

	echo " <div class='footerlistbox'>
			<h4>INFO</h4>
			<ul>
				<li><a href='layanan.php'>Layanan</a></li>
				<li><a href='k3lh.php'>K3LH</a></li>
				<li><a href='training.php'>Training</a></li>
				<li><a href='loker.php'>Lowongan Kerja</a></li>
				<li><a href='klien.php'>List Client</a></li>
				<li><a href='mcu.php'>Hasil Medical Check Up</a></li>
		
			</ul>
		</div> ";

	
	echo "	<div class='footerlistbox'>
			<h4>LAINNYA</h4>
			<ul>
				<li><a href='display_news_more.php'>Berita Terkini</a></li>
				<li><a href='display_article_more.php'>Artikel</a></li>
				<li><a href='agenda.php'>Agenda</a></li>
				<li><a href='gallery.php'>Foto Galeri</a></li>
			</ul>
		</div> ";
	
		
	echo " <div class='footerlistbox'>
		</div> ";
	
	echo "	<div class='footerlistbox quick'>
		<h4>Location</h4>
			<p class='small'>AMC Balikpapan<br />
			Jl. Indrakila (Strat 03) No.05, Kel. Gunung Samarinda<br />
			Balikpapan - Kalimantan Timur,
			Indonesia - 76125<br /><br />
			Phone : ( 0542 )-440404,<br />
			 &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;( 0542 )-444055, <br />
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;( 0542 )-415366 <br />
			E-mail : amc_clinic@yahoo.com
			</p>				
			
				
		</div>


	</div>

</div>


<div class='clear'></div> ";


echo "<div id='copyright'>
	<div class='content'>
	
		
		<div class='copyrighttext'>
	<p>Copyright &copy; 2013 amc-balikpapan.com   Powered By <a href='http://www.permatatechnology.com' target='_self'>Permatatechnology.com</a></p>
		</div>

	</div>
</div>";


 }
 
 function display_top_menu()
 {
   echo "<li class='current'> <a href='index.php'>Beranda</a></li>
				<li> <a href='#'>Profil</a>
					<ul>";
					$sqlP=mysql_query("SELECT * FROM tb_profile where aktif = 'Y'");
					while($r=mysql_fetch_array($sqlP)){
						echo"<li><a href='tentang.php?id=$r[id_profile]'>$r[judul]</a></li>";
					}
					
				echo"	
				</li>
				
				</ul>
				</li>
				
				
				<li> <a href='k3lh.php'>K3LH</a>
				</li>
				
				<li><a href='#'>Foto Galeri</a>
				<ul>
					<li><a href='gallery.php'>Gallery</a></li>
				</ul>
				</li>

				<li><a href='layanan.php'>Layanan</a>
				</li>
				
				<li><a href='klien.php'>Klien</a></li>
				
				<li><a href='#'>Info</a>
				<ul>";
					include "config/koneksi.php";
					$sqlP=mysql_query("SELECT * FROM kategori_agenda where aktif = 'Y'");
					while($r=mysql_fetch_array($sqlP)){
						echo"<li><a href='info.php?id=$r[id_kategori]'>$r[nama_kategori]</a></li>";
					}
					
					if(!empty($_SESSION['mem_username'])){
						echo "<li><a href='#'>Medical Check Up</a></li>";
					}
				echo"	
				</ul>
				</li>
				
			
				
				
				<li><a href='contactus.php'>Hubungi Kami</a> </li>
			</ul> ";
 }
 
 function display_accordion()
 {
 
 		   $sSQL = " select * from tb_accordion where fl_active = 1 order by no_seq";			   
					$rslt=mysql_query($sSQL) or die ("error query");
					$i=0;
					while ($row=mysql_fetch_assoc($rslt))
					{
					    echo "<li>
			            <div class='headerbox'>";
						 
							echo "<h1>".$row['title']."</h1>"."<p>".$row['detail']."<p>";
					
		          			echo "</div>
          						  <div class='handle'><div class='slideinfo'>";
								echo "<p class='icon'>
										<img src='images/$row[logo]' alt='$row[logo]'";
								echo "/></p>";
								
	            		  	echo "<span>".$row['title']."
	 					  		  </div></div>
								  </li>";
							}
						mysql_free_result($rslt);	
 }
 
 function  display_topbar()
 {
	if(!empty($_SESSION['mem_username'])){
			echo "<div class='tollfree'><a href='#'>"."Click Here</a> to chat with live Support | Call Us : ( 0542 )-440-404 , ( 0542 )-444-055 , ( 0542 )-415-366</div>
			<div class='clientlogin'> Welcome , ".$_SESSION['mem_name']."&nbsp;&nbsp;
			 <a href='logout.php' class='selengkapnya'>Logout</a></div>";
	}else{
		echo "<div class='tollfree'>
			<a href='#'>"."Click Here</a> to chat with live Support | Call Us : ( 0542 )-440-404 , ( 0542 )-444-055 , ( 0542 )-415-366</div>
			<div class='clientlogin'>  
				<a id='loginform' href='register.php'>Register</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a id='loginform' href='loginform.php' class='iframe'>Client Login</a>"." &nbsp;<img src='images/lock.png' alt='' />"."</div>";
	}
 }
 
 function  display_topbar_pass()
 {
   	echo "<div class='tollfree'><a href='#'>"."Click Here</a> to chat with live Support | Call Us : ( 0542 )-440-404 , ( 0542 )-444-055 , ( 0542 )-415-366</div>
			<div class='clientlogin'> Welcome , ".$_SESSION['smUser']."&nbsp;&nbsp;
			 <a href='logout.php' class='selengkapnya'>Logout</a></div>";
 }
 
 
 
 
?>
