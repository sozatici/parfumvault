<?php if (!defined('pvault_panel')){ die('Not Found');}  ?>
<?php
require_once('inc/product.php');
if($_GET['do']=='install'){		
	if(strlen($_POST['password']) < '5'){
		$msg ='<div class="alert alert-danger alert-dismissible"><strong>Error: </strong>Password must be at least 5 chars long!</div>';
	}else{
		if($_POST['dbhost'] && $_POST['dbuser'] && $_POST['dbpass'] && $_POST['dbname'] && $_POST['username'] && $_POST['password'] && $_POST['fullName'] && $_POST['email']){
		
			if(!$link = mysqli_connect($_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass'], $_POST['dbname'])){
				$msg = '<div class="alert alert-danger alert-dismissible">Error connecting to the database, make sure the details provided are correct. Make sure the database exists and the user has the write permissions.</div>';
			}else{
				$cmd = "mysql -u$_POST[dbuser] -p$_POST[dbpass] -h$_POST[dbhost] $_POST[dbname] < ./db/pvault.sql"; 
				passthru($cmd,$e);
				if(!$e){
					mysqli_query($link,"INSERT INTO users (username,password,fullName,email) VALUES ('$_POST[username]',PASSWORD('$_POST[password]'),'$_POST[fullName]','$_POST[email]')");
					
					$conf = '<?php
//AUTO GENERATED BY INSTALLATION WIZARD
if (!defined("pvault_panel")){ die("Not Found");}
$dbhost = "'.$_POST['dbhost'].'"; //MySQL Hostname
$dbuser = "'.$_POST['dbuser'].'"; //MySQL Username
$dbpass = "'.$_POST['dbpass'].'"; //MySQL Password
$dbname = "'.$_POST['dbname'].'"; //MySQL DB name


$SDS_path = "uploads/SDS/";
$tmp_path = "tmp/";
$allowed_ext = "pdf, doc, docx, xls, csv, xlsx, png, jpg, jpeg, gif";
$max_filesize = "4194304"; //in bytes
?>
';
					if(file_put_contents('inc/config.php', $conf) == FALSE){
						$msg = '<div class="alert alert-danger alert-dismissible">Error: failed to create config file! Make sure your web server has write permissions to the install directory.</div>';
					}else{
						$msg = '<div class="alert alert-success alert-dismissible">System configured!</div>';
						header('location: login.php');
					}

				}else{
					$msg = '<div class="alert alert-danger alert-dismissible">Error: failed to create user! '.mysqli_error($link).'</div>';
				}
			}
		
	

		}else{
			$msg = '<div class="alert alert-danger alert-dismissible">Error: all fields required!</div>';
		}//FIELDS VALIDATION
	}//PASS CHECK
}//SAVE
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $product.' - '.$ver;?>">
  <meta name="author" content="JBPARFUM">
  <title><?php echo $product;?> - First time setup!</title>

  <link href="css/sb-admin-2.css" rel="stylesheet">
  <link href="css/vault.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-install-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">First time setup</h1>
                  </div>
                  <?php echo $msg; ?>
                    <hr>
                    <strong>Database Settings:</strong>
                    <hr>
                  <form action="?do=install" method="post" enctype="multipart/form-data" name class="user">
                    <div class="form-group">
                      <input name="dbhost" type="text" class="form-control form-control-user" value="<?php echo $_POST['dbhost'];?>"  placeholder="Database Hostname or IP...">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="dbuser"  value="<?php echo $_POST['dbuser'];?>" placeholder="Database Username...">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="dbpass"  placeholder="Database Password...">
                    </div>
                     <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="dbname"  value="<?php echo $_POST['dbname'];?>" placeholder="Database Name...">
                    </div>
                    <hr>
                    <strong>User Settings:</strong>
                    <hr>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="fullName"  value="<?php echo $_POST['fullName'];?>" placeholder="Your full name...">
                    </div>      
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="email"  value="<?php echo $_POST['email'];?>" placeholder="Your email...">
                    </div>  
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="username"  value="<?php echo $_POST['username'];?>" placeholder="Username...">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" name="password" placeholder="Password...">
                    </div>
                    <div class="form-group"></div>
                    <hr>
                    <button name="save" class="btn btn-primary btn-user btn-block">
                      Save!
                    </button>
                    <p>&nbsp;</p>
                    <p>*All fields required</p>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 </body>
</html>