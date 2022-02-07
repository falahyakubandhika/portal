<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="index.php">
          <img src="images/logo/logo_bitumen.png">
          <!--<span class="text-danger arialround">Amarta </span><span class="cursive text-success" style="font-size: 24px"> Consulting</span>-->
        </a>
        <a class="navbar-brand brand-logo-mini" href="index.php">
          <img src="images/logo/logo_bitumen.png" style="width: 50%; height: auto;" class="img-fluid" alt="logo" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
          
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          
          <li class="nav-item dropdown d-none d-xl-inline-block">
            <a id="logout" class="nav-link dropdown-toggle" style="cursor: pointer;" id="UserDropdown" data-toggle="dropdown" aria-expanded="false">
              <span class="profile-text">Logout <i class="fa fa-power-off" style="font-size: 12px"></i></span>
              
            </a>
            <script type="text/javascript">
              document.getElementById("logout").onclick = function () {
                  if(confirm('Are you sure ?')) location.href = "logout.php";
              };
          </script>
            
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>