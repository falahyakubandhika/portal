<?php
  include "../../../config/koneksi.php";
?>

<?php



if(isset($_POST['pc_id']) && $_POST['pc_id'] != '')
{
  $pc_id = $_POST['pc_id'];
  $pc_id = mysql_real_escape_string($pc_id);
  $query = "select * from tb_subcategory where category_id='".$pc_id."'";
  $res = mysql_query($query);
  if(mysql_num_rows($res))
  {
	echo "<option value=''>-- No Subcategory selected --</option>";
    while($row = mysql_fetch_array($res))
	{
	  echo "<option value='".$row['subcategory_id']."'>".ucfirst($row['subcategory_name'])."</option>";
	}
  }
}


?>