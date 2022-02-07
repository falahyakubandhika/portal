<?php 
ob_start();
session_start();
if(empty($_SESSION['login'])) echo '<p style="display:none"></p>';
else if($_SESSION['login'] == 1) echo '<script>window.location = "index.php";</script>';

?>
<html>
<head>
<title>Administrator Wika Bitumen</title>

  <link rel="shortcut icon" href="images/wikabitumen.ico" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<script language="javascript">
function validasi(form){
  if (form.username.value == ""){
    alert("Anda belum mengisikan Username.");
    form.username.focus();
    return (false);
  }
     
  if (form.password.value == ""){
    alert("Anda belum mengisikan Password.");
    form.password.focus();
    return (false);
  }
  return (true);
}
</script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    

</head>
<body OnLoad="document.login.username.focus();">
<div class="container" style="border:3px solid  #ffc100ad;">
  <div class="row py-5">
    <div class="col-sm-12 text-center" >
      <img src="images/logo/logo_bitumen.png">
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-4"></div>
    <div class="col-xs-12 col-sm-12 col-md-4 text-center">
      <form name="login" action="cek_login.php" method="POST" onSubmit="return validasi(this)">
        
          Username :<input type="text" name="username" class="form-control">
          Password :<input type="password" name="password"class="form-control">
          <br/>
          <input type="submit" value="Login" name="login" class="btn btn-success btn-block">
      </form>
    </div>
     <div class="col-xs-12 col-sm-12 col-md-4"></div>
    
  </div>
    

<div id="footer">
       @2019 <a href="http://wikabitumen.co.id">wikabitumen.co.id</a>. All Rights Reserved 
  </div>
</div>
	
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
