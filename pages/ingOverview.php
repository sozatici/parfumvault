<?php

require('../inc/sec.php');

require_once(__ROOT__.'/inc/config.php');
require_once(__ROOT__.'/inc/opendb.php');
require_once(__ROOT__.'/inc/settings.php');
require_once(__ROOT__.'/func/getCatByID.php');
require_once(__ROOT__.'/func/profileImg.php');
require_once(__ROOT__.'/func/getIngState.php');


if(empty($_GET["id"])){
	return;
}
$ingID = mysqli_real_escape_string($conn, $_GET["id"]);

$ingredient = mysqli_fetch_array(mysqli_query($conn, "SELECT category,profile,type,odor,physical_state,FEMA,INCI,reach FROM ingredients WHERE id = '$ingID'"));
if(empty($ingredient['category'])){
	return;
}

?>
<html>
<head>
<link href="../css/vault.css" rel="stylesheet">
<style>

.img_ing {
    max-height: 100px;
}
</style>
</head>
<div class="sub-2-container sub-2-header">
	<div class="sub-2-container">
        <span class="coh-inline-element sub-2-inci">INCI</span> 
        <span class="coh-inline-element sub-2-fema"><?=$ingredient['INCI']?:"Not Available"?></span>  
    </div>
    <div class="sub-2-container">
        <span class="sub-2-inci">FEMA#</span>
        <span class="sub-2-fema"><?=$ingredient['FEMA']?:"Not Available"?></span>
    </div>
    <div class="sub-2-container">
        <span class="sub-2-inci">REACH#</span>
        <span class="sub-2-fema"><?=$ingredient['reach']?:"Not Available"?></span>
    </div>
</div>
<table width="100%" border="0">
  <tr>
    <td width="33%" align="center"><h3 class="mgm-cat-in">Olfactive family</h3></td>
    <td width="33%" align="center"><h3 class="mgm-cat-in"><?php echo $ingredient['profile'].' note'; ?></h3></td>
    <td width="33%" align="center"><h3 class="mgm-cat-in">Physical State</h3></td>
  </tr>
  <tr>
    <td align="center"><?=getCatByID($ingredient['category'],TRUE,$conn)?></td>
    <td align="center"><img src="<?=profileImg($ingredient['profile'])?>" class="img_ing"/></td>
    <td align="center"><?=getIngState($ingredient['physical_state'],'img_ing')?></td>
  </tr>
</table>

</html>