<link href="../../style_table.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function getSelected(no_int_prd,parent_id,parent_nm,weight,length,width,height,volume,qty,price_1,price_2,id_brand,parent_category,child_category,weightunit,volumeunit,unit,link_video,fl_promo){	
	var args = new Array();
	for (var i = 0; i < arguments.length; i++)
		window.parent.my_variable[i+1] = arguments[i];
		
		
	window.parent.passingToParent();
}
</script>
<?php
include "../../../config/koneksi.php";
include "../../../config/class_paging.php";
$id=$_GET['id'];

echo "<h2>Product</h2>";
	
	$p      = new Paging;
	$batas  = 50;
	$posisi = $p->cariPosisi($batas);
	
	
	
	$sSQL = " SELECT * FROM tb_product WHERE fl_active='1' ";
	
	$jmldata = mysql_num_rows(mysql_query($sSQL));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);
	if($jmldata > $batas){
    	echo "<div id=paging>Hal: $linkHalaman</div><br>";
	}
	
	
	
	$sSQL2 = " SELECT * FROM tb_product WHERE fl_active=1  ORDER BY product_name ASC LIMIT $posisi,$batas "	;
	
	
	
	$result = mysql_query($sSQL2);
	$no = $posisi+1;
	echo"
	<table class='hovertable'>
		<tr><th>No</th><th>Product ID</th><th>Product Name</th><th>Main Image</th><th>#</th></tr>";
		while($r=mysql_fetch_array($result)){
			
			if($id==$r['no_int_product']){
			
				$icon="<img src='../../images/icons/tick.png'>";
			}else{
				$icon="<img src='../../images/icons/stop.png'>";
			}
			
			$image = $r[image_1];
	        $real_gambar = str_replace("images/product/","",$image);
			$real_gambar = trim($real_gambar);
					   
	    	$gambar_small = "../../../images/product/small_".$real_gambar;
		 
			echo"
			<tr>
				<td>$no</td>
				<td><a href='javascript:getSelected($r[no_int_product],\"$r[product_id]\",\"$r[product_name]\",\"$r[weight]\",\"$r[length]\",\"$r[width]\",\"$r[height]\",\"$r[volume]\",\"$r[qty]\",\"$r[price_1]\",\"$r[price_2]\",\"$r[brand_id]\",\"$r[category_id]\",\"$r[subcategory_id]\",\"$r[weight_unit_id]\",\"$r[volume_unit_id]\",\"$r[unit_id]\",\"$r[link_video]\",\"$r[fl_promo]\")'>$r[product_id]</a></td><td>$r[product_name]</td><td><img src='$gambar_small'></td>
				
		<td><a href='javascript:getSelected($r[no_int_product],\"$r[product_id]\",\"$r[product_name]\",\"$r[weight]\",\"$r[length]\",\"$r[width]\",\"$r[height]\",\"$r[volume]\",\"$r[qty]\",\"$r[price_1]\",\"$r[price_2]\",\"$r[brand_id]\",\"$r[category_id]\",\"$r[subcategory_id]\",\"$r[weight_unit_id]\",\"$r[volume_unit_id]\",\"$r[unit_id]\",\"$r[link_video]\",\"$r[fl_promo]\")'>$icon</a></td>
				
			</tr>";
		
	
			
			
		
			
			
			
			
		$no++;
		}
	echo"
	</table>";
	
	if($jmldata > $batas){
    	echo "<div id=paging>Hal: $linkHalaman</div><br>";
	}
	
?>