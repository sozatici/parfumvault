<?php
define('__ROOT__', dirname(dirname(__FILE__))); 

require(__ROOT__.'/inc/sec.php');

require_once(__ROOT__.'/inc/config.php');
require_once(__ROOT__.'/inc/opendb.php');
require_once(__ROOT__.'/func/validateInput.php');
require_once(__ROOT__.'/inc/settings.php');
require_once(__ROOT__.'/func/sanChar.php');
require_once(__ROOT__.'/func/priceScrape.php');
require_once(__ROOT__.'/func/create_thumb.php');

//UPDATE LID PIC
if($_GET['update_lid_pic']){
	$allowed_ext = "png, jpg, jpeg, gif, bmp";

	$filename = $_FILES["lid_pic"]["tmp_name"];  
    $file_ext = strtolower(end(explode('.',$_FILES['lid_pic']['name'])));
	$file_tmp = $_FILES['lid_pic']['tmp_name'];
    $ext = explode(', ',strtolower($allowed_ext));

	if(!$filename){
		return;
	}	
	
	if (!file_exists(__ROOT__."/uploads/tmp/")) {
		mkdir(__ROOT__."/uploads/tmp/", 0740, true);
	}
		
	if(in_array($file_ext,$ext)===false){
		$response["error"] = 'Extension not allowed, please choose a '.$allowed_ext.' file';
		echo json_encode($response);
		return;
	}
	$lid = $_GET['lid_id'];
	if($_FILES["lid_pic"]["size"] > 0){
		move_uploaded_file($file_tmp,__ROOT__."/uploads/tmp/".base64_encode($filename));
		$pic = "/uploads/tmp/".base64_encode($filename);		
		create_thumb(__ROOT__.$pic,250,250); 
		$docData = 'data:application/' . $file_ext . ';base64,' . base64_encode(file_get_contents(__ROOT__.$pic));
		
		mysqli_query($conn, "DELETE FROM documents WHERE ownerID = '".$lid."' AND type = '5'");
		if(mysqli_query($conn, "INSERT INTO documents (ownerID,name,type,notes,docData) VALUES ('".$lid."','-','5','-','$docData')")){	
			unlink(__ROOT__.$pic);
			$response["success"] = array( "msg" => "Pic updated!", "lid_pic" => $docData);
			echo json_encode($response);
			return;
		}
		$response["error"] = mysqli_error($conn);
		echo json_encode($response);
		return;
	}

	return;
}

//UPDATE BOTTLE PIC
if($_GET['update_bottle_pic']){
	$allowed_ext = "png, jpg, jpeg, gif, bmp";

	$filename = $_FILES["bottle_pic"]["tmp_name"];  
    $file_ext = strtolower(end(explode('.',$_FILES['bottle_pic']['name'])));
	$file_tmp = $_FILES['bottle_pic']['tmp_name'];
    $ext = explode(', ',strtolower($allowed_ext));

	
	if(!$filename){
		//$response["error"] = 'Please choose a file to upload';
		//echo json_encode($response);
		return;
	}	
	
	if (!file_exists(__ROOT__."/uploads/tmp/")) {
		mkdir(__ROOT__."/uploads/tmp/", 0740, true);
	}
		
	if(in_array($file_ext,$ext)===false){
		$response["error"] = '<strong>File upload error: </strong>Extension not allowed, please choose a '.$allowed_ext.' file';
		echo json_encode($response);
		return;
	}
	$bottle = $_GET['bottle_id'];
	if($_FILES["bottle_pic"]["size"] > 0){
		move_uploaded_file($file_tmp,__ROOT__."/uploads/tmp/".base64_encode($filename));
		$bottle_pic = "/uploads/tmp/".base64_encode($filename);		
		create_thumb(__ROOT__.$bottle_pic,250,250); 
		$docData = 'data:application/' . $file_ext . ';base64,' . base64_encode(file_get_contents(__ROOT__.$bottle_pic));
		
		mysqli_query($conn, "DELETE FROM documents WHERE ownerID = '".$bottle."' AND type = '4'");
		if(mysqli_query($conn, "INSERT INTO documents (ownerID,name,type,notes,docData) VALUES ('".$bottle."','-','4','-','$docData')")){	
			unlink(__ROOT__.$bottle_pic);
			$response["success"] = array( "msg" => "Pic updated!", "bottle_pic" => $docData);
			echo json_encode($response);
			return;
		}
		$response["error"] = mysqli_error($conn);
		echo json_encode($response);
		return;
	}

	return;
}

//UPDATE BOTTLE DATA
if($_POST['update_bottle_data']){
	
	if(!$_POST['name']){
		$response["error"] = "Name is required";
		echo json_encode($response);
		return;
	}
	$id = $_POST['bottle_id'];
	$name = $_POST['name'];
	$ml = $_POST['size'];
	$price = $_POST['price'];
	$height = $_POST['height'];
	$width = $_POST['width'];
	$diameter = $_POST['diameter'];
	$supplier = $_POST['supplier'];
	$supplier_link = $_POST['supplier_link'];
	$notes = $_POST['notes'];
	$pieces = $_POST['pieces']?:0;
	
	$q = mysqli_query($conn,"UPDATE bottles SET name= '$name', ml = '$ml', price = '$price', height = '$height', width = '$width', diameter = '$diameter', supplier = '$supplier', supplier_link = '$supplier_link', notes = '$notes', pieces = '$pieces' WHERE id = '$id'");
	

	if($q){
		$response['success'] = "Bottle updated";
	}else{
		$response['error'] = "Error updating bottle data ".mysqli_error($conn);
	}
	
	echo json_encode($response);
	
	

	return;
}

//UPDATE LID DATA
if($_POST['update_lid_data']){
	
	if(!$_POST['style']){
		$response["error"] = "Style is required";
		echo json_encode($response);
		return;
	}
	$id = $_POST['lid_id'];
	$style = $_POST['style'];
	$colour = $_POST['colour'];
	$price = $_POST['price'];
	$supplier = $_POST['supplier'];
	$supplier_link = $_POST['supplier_link'];
	$pieces = $_POST['pieces']?:0;
	
	$q = mysqli_query($conn,"UPDATE lids SET style= '$style', colour = '$colour', price = '$price', supplier = '$supplier', supplier_link = '$supplier_link', pieces = '$pieces' WHERE id = '$id'");
	

	if($q){
		$response['success'] = "Lid updated";
	}else{
		$response['error'] = "Error updating lid data ".mysqli_error($conn);
	}
	
	echo json_encode($response);
	
	

	return;
}
//DELETE BOTTLE
if($_POST['action'] == 'delete' && $_POST['btlId'] && $_POST['type'] == 'bottle'){
	$id = mysqli_real_escape_string($conn, $_POST['btlId']);
	
	if(mysqli_query($conn, "DELETE FROM bottles WHERE id = '$id'")){
		mysqli_query($conn, "DELETE FROM documents WHERE ownerID = '$id' AND type = '4'");
		$response["success"] = 'Bottle deleted';
	}else{
		$response["error"] = 'Something went wrong '.mysqli_error($conn);
	}
	
	echo json_encode($response);
	return;	
}

//DELETE LID
if($_POST['action'] == 'delete' && $_POST['lidId'] && $_POST['type'] == 'lid'){
	$id = mysqli_real_escape_string($conn, $_POST['lidId']);
	
	if(mysqli_query($conn, "DELETE FROM lids WHERE id = '$id'")){
		mysqli_query($conn, "DELETE FROM documents WHERE ownerID = '$id' AND type = '5'");
		$response["success"] = 'Lid deleted';
	}else{
		$response["error"] = 'Something went wrong '.mysqli_error($conn);
	}
	
	echo json_encode($response);
	return;	
}

//IMPORT IMAGES FROM PUBCHEM
if($_GET['IFRA_PB'] == 'import'){
	require_once(__ROOT__.'/func/pvFileGet.php');
	$i = 0;
	$qCas = mysqli_query($conn,"SELECT cas FROM IFRALibrary");
	$view =  $settings['pubchem_view'];
	while($cas = mysqli_fetch_array($qCas)){
		$image = base64_encode(pv_file_get_contents($pubChemApi.'/pug/compound/name/'.$cas['cas'].'/PNG?record_type='.$view.'&image_size=small'));
		
		$imp = mysqli_query($conn,"UPDATE IFRALibrary SET image = '$image' WHERE cas = '".$cas['cas']."'");
		$i++;
		
		usleep(.1 * 1000000);
	}
	if($imp){
		$response["success"] = $i.' images updated!';
	}else{
		$response["error"] = 'Something went wrong '.mysqli_error($conn);
	}
	echo json_encode($response);
	return;
}

//IMPORT SYNONYMS FROM PubChem
if($_POST['pubChemData'] == 'update' && $_POST['cas']){
	$cas = trim($_POST['cas']);
	$molecularWeight = $_POST['molecularWeight'];
	$logP = trim($_POST['logP']);
	$molecularFormula = $_POST['molecularFormula'];
	$InChI = $_POST['InChI'];
	$CanonicalSMILES = $_POST['CanonicalSMILES'];
	$ExactMass = trim($_POST['ExactMass']);
	
	if($molecularWeight){
		$q = mysqli_query($conn, "UPDATE ingredients SET molecularWeight = '$molecularWeight' WHERE cas='$cas'");
	}
	if($logP){
		$q.= mysqli_query($conn, "UPDATE ingredients SET logp = '$logP' WHERE cas='$cas'");
	}
	if($molecularFormula){
		$q.= mysqli_query($conn, "UPDATE ingredients SET formula = '$molecularFormula' WHERE cas='$cas'");
	}
	if($InChI){
		$q.= mysqli_query($conn, "UPDATE ingredients SET INCI = '$InChI' WHERE cas='$cas'");
	}
	if($q){
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Data updated!</div>';
	}else{
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Unable to update data!</div>';
	}
	return;
}

//IMPORT SYNONYMS FROM PubChem
if($_POST['synonym'] == 'import' && $_POST['method'] == 'pubchem'){
	$ing = base64_decode($_POST['ing']);
	$cas = trim($_POST['cas']);

	$u = $pubChemApi.'/pug/compound/name/'.$cas.'/synonyms/JSON';
	$json = file_get_contents($u);
	$json = json_decode($json);
	$data = $json->InformationList->Information[0]->Synonym;
	$cid = $json->InformationList->Information[0]->CID;
	$source = 'PubChem';
	if(empty($data)){
		echo '<div class="alert alert-info alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>No data found!</div>';
		return;
	}
	$i=0;
	foreach($data as $d){
		$einecs = explode('EINECS ',$d);
		if($einecs['1']){
			mysqli_query($conn, "UPDATE ingredients SET einecs = '".$einecs['1']."' WHERE cas = '$cas'");
		}
		$fema = explode('FEMA ',$d);
		if($fema['1']){
			mysqli_query($conn, "UPDATE ingredients SET FEMA = '".preg_replace("/[^0-9]/", "", $fema['1'])."' WHERE cas = '$cas'");
		}
		if(!mysqli_num_rows(mysqli_query($conn, "SELECT synonym FROM synonyms WHERE synonym = '$d' AND ing = '$ing'"))){
			$r = mysqli_query($conn, "INSERT INTO synonyms (ing,cid,synonym,source) VALUES ('$ing','$cid','$d','$source')");		
		 	$i++;
		}
	}
	if($r){
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>'.$i.' </strong>synonym(s) imported!</div>';
	}else{
		echo '<div class="alert alert-info alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Data already in sync!</div>';
	}
	
	return;
}

//ADD SYNONYM
if($_GET['synonym'] == 'add'){
	$synonym = mysqli_real_escape_string($conn, $_GET['sName']);
	$source = mysqli_real_escape_string($conn, $_GET['source']);
	
	$ing = base64_decode($_GET['ing']);

	if(empty($synonym)){
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Error:</strong> Synonym is required!</div>';
		return;
	}
	
	if(mysqli_num_rows(mysqli_query($conn, "SELECT synonym FROM synonyms WHERE synonym = '$synonym' AND ing = '$ing'"))){
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Error: </strong>'.$synonym.' already exists!</div>';
		return;
	}
	
	if(mysqli_query($conn, "INSERT INTO synonyms (synonym,source,ing) VALUES ('$synonym','$source','$ing')")){
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>'.$synonym.'</strong> added to the list!</div>';
	}else{
		echo mysqli_error($conn);
	}
	
	return;
}


//UPDATE SYNONYM
if($_GET['synonym'] == 'update'){
	$value = trim(mysqli_real_escape_string($conn, $_POST['value']));
	$id = mysqli_real_escape_string($conn, $_POST['pk']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$ing = base64_decode($_GET['ing']);

	mysqli_query($conn, "UPDATE synonyms SET $name = '$value' WHERE id = '$id' AND ing='$ing'");
	return;
}


//DELETE ING SYNONYM	
if($_GET['synonym'] == 'delete'){
	$id = mysqli_real_escape_string($conn, $_GET['id']);
	mysqli_query($conn, "DELETE FROM synonyms WHERE id = '$id'");
	return;
}

//ADD REPLACEMENT
if($_POST['replacement'] == 'add'){
	
	$ing_name = base64_decode($_POST['ing_name']);
	$ing_cas = base64_decode($_POST['ing_cas']);

	if(empty($_POST['rName'])){
		$response["error"] = 'Name is required';
		echo json_encode($response);
		return;
	}
	
	if(empty($_POST['rCAS'])){
		$response["error"] = 'CAS is required';
		echo json_encode($response);
		return;
	}

	if(mysqli_num_rows(mysqli_query($conn, "SELECT ing_rep_name FROM ingReplacements WHERE ing_name = '$ing_name' AND ing_rep_name = '".$_POST['rName']."'"))){
		$response["error"] = $_POST['rName'].' already exists!';
		echo json_encode($response);
		return;
	}
	
	if(mysqli_query($conn, "INSERT INTO ingReplacements (ing_name,ing_cas,ing_rep_name,ing_rep_cas,notes) VALUES ('$ing_name','$ing_cas','".$_POST['rName']."','".$_POST['rCAS']."','".$_POST['rNotes']."')")){
		$response["success"] = $_POST['rName'].' added to the list!';
	}else{
		$response["error"] = 'Error: '.mysqli_error($conn);
	}
	echo json_encode($response);
	return;
}

//UPDATE ING REPLACEMENT
if($_GET['replacement'] == 'update'){
	$value = trim(mysqli_real_escape_string($conn, $_POST['value']));
	$id = mysqli_real_escape_string($conn, $_POST['pk']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$ing = base64_decode($_GET['ing']);

	if(mysqli_query($conn, "UPDATE ingReplacements SET $name = '$value' WHERE id = '$id' AND ing_name='$ing'")){
		$response["success"] = $ing.' replacement updated';
	}else{
		$response["error"] = 'Error: '.mysqli_error($conn);
	}
	
	echo json_encode($response);
	return;
}


//DELETE ING REPLACEMENT	
if($_POST['replacement'] == 'delete'){
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	if(mysqli_query($conn, "DELETE FROM ingReplacements WHERE id = '$id'")){
		$response["success"] = $_POST['name'].' replacement removed';
	}else{
		$response["error"] = 'Error: '.mysqli_error($conn);
	}
	echo json_encode($response);
	return;
}


//UPDATE ING DOCUMENT
if($_GET['ingDoc'] == 'update'){
	$value = mysqli_real_escape_string($conn, $_POST['value']);
	$id = mysqli_real_escape_string($conn, $_POST['pk']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$ownerID = mysqli_real_escape_string($conn, $_GET['ingID']);

	mysqli_query($conn, "UPDATE documents SET $name = '$value' WHERE ownerID = '$ownerID' AND id='$id'");
	return;
}


//DELETE ING DOCUMENT	
if($_GET['doc'] == 'delete'){

	$id = mysqli_real_escape_string($conn, $_GET['id']);
	$ownerID = mysqli_real_escape_string($conn, $_GET['ingID']);
							
	mysqli_query($conn, "DELETE FROM documents WHERE id = '$id' AND ownerID='$ownerID'");
	return;
}

//GET SUPPLIER PRICE
if($_POST['ingSupplier'] == 'getPrice'){
	$ingID = mysqli_real_escape_string($conn, $_POST['ingID']);
	$ingSupplierID = mysqli_real_escape_string($conn, $_POST['ingSupplierID']);
	$size = mysqli_real_escape_string($conn, $_POST['size']);
	$supplier_link = urldecode($_POST['sLink']);
	
	$supp_data = mysqli_fetch_array(mysqli_query($conn, "SELECT price_tag_start,price_tag_end,add_costs,price_per_size FROM ingSuppliers WHERE id = '$ingSupplierID'"));
	
	if($newPrice = priceScrape($supplier_link,$size,$supp_data['price_tag_start'],$supp_data['price_tag_end'],$supp_data['add_costs'],$supp_data['price_per_size'])){
		if(mysqli_query($conn, "UPDATE suppliers SET price = '$newPrice' WHERE ingSupplierID = '$ingSupplierID' AND ingID='$ingID'")){
			echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Price updated</strong></div>';
		}
	}else{
	 		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Error getting the price from the supplier</strong></div>';
	}
	return;
}
//ADD ING SUPPLIER
if($_POST['ingSupplier'] == 'add'){
	if(empty($_POST['supplier_id']) || empty($_POST['supplier_link']) || empty($_POST['supplier_size'])){
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Error:</strong> Missing fields!</div>';
		return;
	}
	if(!is_numeric($_POST['supplier_size'])){
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Only numeric values allowed in size and price fields!</div>';
		return;
	}
	$ingID = mysqli_real_escape_string($conn, $_POST['ingID']);
	$supplier_id = mysqli_real_escape_string($conn, $_POST['supplier_id']);
	$supplier_link = mysqli_real_escape_string($conn, $_POST['supplier_link']);	
	$supplier_size = mysqli_real_escape_string($conn, $_POST['supplier_size']);
	$supplier_price = mysqli_real_escape_string($conn, $_POST['supplier_price']);
	$supplier_manufacturer = mysqli_real_escape_string($conn, $_POST['supplier_manufacturer']);
	$supplier_name = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM ingSuppliers WHERE id = '$supplier_id'"));
	$supplier_batch = mysqli_real_escape_string($conn, $_POST['supplier_batch']);
	$purchased = mysqli_real_escape_string($conn, $_POST['purchased'] ?: date('Y-m-d'));
	$stock = mysqli_real_escape_string($conn, $_POST['stock'] ?: 0);

	if(mysqli_num_rows(mysqli_query($conn, "SELECT ingSupplierID FROM suppliers WHERE ingSupplierID = '$supplier_id' AND ingID = '$ingID'"))){
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Error: </strong>'.$supplier_name['name'].' already exists!</div>';
	}else{
		
		if(!mysqli_num_rows(mysqli_query($conn, "SELECT ingSupplierID FROM suppliers WHERE ingID = '$ingID'"))){
		   $preferred = '1';
		}else{
			$preferred = '0';
		}
		
		if(mysqli_query($conn, "INSERT INTO suppliers (ingSupplierID,ingID,supplierLink,price,size,manufacturer,preferred,batch,purchased,stock) VALUES ('$supplier_id','$ingID','$supplier_link','$supplier_price','$supplier_size','$supplier_manufacturer','$preferred','$supplier_batch','$purchased','$stock')")){
			echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>'.$supplier_name['name'].'</strong> added to the list!</div>';
		}else{
			echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Error:</strong> '.mysqli_error($conn).'</div>';
		}
	}
	return;
}

//UPDATE ING SUPPLIER
if($_GET['ingSupplier'] == 'update'){
	$value = mysqli_real_escape_string($conn, $_POST['value']);
	$id = mysqli_real_escape_string($conn, $_POST['pk']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$ingID = mysqli_real_escape_string($conn, $_GET['ingID']);

	mysqli_query($conn, "UPDATE suppliers SET $name = '$value' WHERE id = '$id' AND ingID='$ingID'");
	return;
}

//UPDATE PREFERRED SUPPLIER
if($_GET['ingSupplier'] == 'preferred'){
	$sID = mysqli_real_escape_string($conn, $_GET['sID']);
	$ingID = mysqli_real_escape_string($conn, $_GET['ingID']);
	$status = mysqli_real_escape_string($conn, $_GET['status']);
	
	mysqli_query($conn, "UPDATE suppliers SET preferred = '0' WHERE ingID='$ingID'");
	mysqli_query($conn, "UPDATE suppliers SET preferred = '$status' WHERE ingSupplierID = '$sID' AND ingID='$ingID'");
	return;
}

//DELETE ING SUPPLIER	
if($_GET['ingSupplier'] == 'delete'){

	$sID = mysqli_real_escape_string($conn, $_GET['sID']);
	$ingID = mysqli_real_escape_string($conn, $_GET['ingID']);
	/*
	if(mysqli_num_rows(mysqli_query($conn, "SELECT id FROM suppliers WHERE id = '$sID' AND ingID = '$ingID' AND preferred = '1'"))){
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Preferred supplier cannot be removed. Set as preferred another one first!</div>';
		return;
	}
	*/							
	mysqli_query($conn, "DELETE FROM suppliers WHERE id = '$sID' AND ingID='$ingID'");
	return;
}



if($_POST['value'] && $_GET['formula'] && $_POST['pk']){
	$value = mysqli_real_escape_string($conn, $_POST['value']);
	$formula = mysqli_real_escape_string($conn, $_GET['formula']);
	$ingredient = mysqli_real_escape_string($conn, $_POST['pk']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	
	$ing_name =  mysqli_fetch_array(mysqli_query($conn, "SELECT ingredient FROM formulas WHERE id = '$ingredient' AND fid = '".$_GET['formula']."'"));
	
	$meta = mysqli_fetch_array(mysqli_query($conn, "SELECT id,isProtected FROM formulasMetaData WHERE fid = '".$_GET['formula']."'"));
	if($meta['isProtected'] == FALSE){
					
		mysqli_query($conn, "UPDATE formulas SET $name = '$value' WHERE fid = '$formula' AND id = '$ingredient'");
		$lg = "CHANGE: ".$ing_name['ingredient']." Set $name to $value";
		mysqli_query($conn, "INSERT INTO formula_history (fid,change_made,user) VALUES ('".$meta['id']."','$lg','".$user['fullName']."')");
echo mysqli_error($conn);
	}
	return;
}

if($_GET['formulaMeta']){
	$value = mysqli_real_escape_string($conn, $_POST['value']);
	$formula = mysqli_real_escape_string($conn, base64_decode($_GET['formulaMeta']));
	$id = mysqli_real_escape_string($conn, $_POST['pk']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	
	mysqli_query($conn, "UPDATE formulasMetaData SET $name = '$value' WHERE id = '$id'");
	return;
}

if($_GET['protect']){
	require_once(__ROOT__.'/func/createFormulaRevision.php');
	$fid = mysqli_real_escape_string($conn, $_GET['protect']);
	
	if($_GET['isProtected'] == 'true'){
		$isProtected = '1';
		$l = 'locked';
		createFormulaRevision($fid,$conn);
	}else{
		$isProtected = '0';
		$l = 'unlocked';
	}
	if(mysqli_query($conn, "UPDATE formulasMetaData SET isProtected = '$isProtected' WHERE fid = '$fid'")){
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Formula '.$l.'!</div>';
	}else{
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Something went wrong.</div>';
	}
	return;
}

if($_GET['formula'] &&  $_GET['defView']){
	$fid = mysqli_real_escape_string($conn, $_GET['formula']);
	$defView = mysqli_real_escape_string($conn, $_GET['defView']);
	
	if(mysqli_query($conn, "UPDATE formulasMetaData SET defView = '$defView' WHERE fid = '$fid'")){
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Default formula view changed!</div>';
	}else{
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Something went wrong.</div>';
	}
	return;
}

if($_GET['formula'] &&  $_GET['catClass']){
	$fid = mysqli_real_escape_string($conn, $_GET['formula']);
	$catClass = mysqli_real_escape_string($conn, $_GET['catClass']);
	
	if(mysqli_query($conn, "UPDATE formulasMetaData SET catClass = '$catClass' WHERE fid = '$fid'")){
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Purpose changed!</div>';
	}else{
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Something went wrong.</div>';
	}
	return;
}

if($_GET['formula'] &&  $_GET['finalType']){
	$fid = mysqli_real_escape_string($conn, $_GET['formula']);
	$finalType = mysqli_real_escape_string($conn, $_GET['finalType']);
	
	if(mysqli_query($conn, "UPDATE formulasMetaData SET finalType = '$finalType' WHERE id = '$fid'")){
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Finished product type changed!</div>';
	}else{
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Something went wrong.</div>';
	}
	return;
}

if($_GET['formula'] &&  $_GET['updateStatus']){
	$fid = mysqli_real_escape_string($conn, $_GET['formula']);
	$formulaStatus = mysqli_real_escape_string($conn, $_GET['formulaStatus']);
	
	if(mysqli_query($conn, "UPDATE formulasMetaData SET status = '$formulaStatus' WHERE id = '$fid'")){
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Status updated!</div>';
	}else{
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Something went wrong.</div>';
	}
	return;
}

if($_GET['formula'] &&  $_GET['customer_id']){
	$fid = mysqli_real_escape_string($conn, $_GET['formula']);
	$customer_id = mysqli_real_escape_string($conn, $_GET['customer_id']);
	
	if(mysqli_query($conn, "UPDATE formulasMetaData SET customer_id = '$customer_id' WHERE fid = '$fid'")){
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Customer updated!</div>';
	}else{
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Something went wrong.</div>';
	}
	return;
}

if($_GET['action'] == 'rename' && $_GET['fid']){
	$value = mysqli_real_escape_string($conn, $_POST['value']);
	$fid = mysqli_real_escape_string($conn, $_GET['fid']);
	$id = $_POST['pk'];
	
	if(mysqli_num_rows(mysqli_query($conn, "SELECT name FROM formulasMetaData WHERE name = '$value'"))){
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Name already exists</a>';
	}else{
		mysqli_query($conn, "UPDATE formulasMetaData SET name = '$value' WHERE id = '$id'");
		if(mysqli_query($conn, "UPDATE formulas SET name = '$value' WHERE fid = '$fid'")){
			echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Formula renamed.</a>';
		}
	
	}
	return;	
}

if($_GET['settings'] == 'cat'){
	$value = mysqli_real_escape_string($conn, $_POST['value']);
	$cat_id = mysqli_real_escape_string($conn, $_POST['pk']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);

	mysqli_query($conn, "UPDATE ingCategory SET $name = '$value' WHERE id = '$cat_id'");
	return;
}

if($_GET['settings'] == 'fcat'){
	$value = mysqli_real_escape_string($conn, $_POST['value']);
	$cat_id = mysqli_real_escape_string($conn, $_POST['pk']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);

	mysqli_query($conn, "UPDATE formulaCategories SET $name = '$value' WHERE id = '$cat_id'");
	return;
}

if($_GET['settings'] == 'sup'){
	$value = htmlentities($_POST['value']);
	$sup_id = mysqli_real_escape_string($conn, $_POST['pk']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);

	mysqli_query($conn, "UPDATE ingSuppliers SET $name = '$value' WHERE id = '$sup_id'");
	return;	
}

if($_POST['supp'] == 'add'){
	$description = mysqli_real_escape_string($conn, $_POST['description']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$platform = mysqli_real_escape_string($conn, $_POST['platform']);
	$price_tag_start = htmlentities($_POST['price_tag_start']);
	$price_tag_end = htmlentities($_POST['price_tag_end']);
	$add_costs = is_numeric($_POST['add_costs']);
	$min_ml = mysqli_real_escape_string($conn, $_POST['min_ml']);
	$min_gr = mysqli_real_escape_string($conn, $_POST['min_gr']);

	if(empty($min_ml)){
		$min_ml = 0;
	}
	if(empty($min_gr)){
		$min_gr = 0;
	}		 
	
	if(empty($name)){
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Error: </strong> Supplier name required</div>';
		return;
	}
	if(mysqli_num_rows(mysqli_query($conn, "SELECT name FROM ingSuppliers WHERE name = '$name'"))){
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>'.$name.'</strong> Supplier already exists!</div>';
		return;
	}

	if(mysqli_query($conn, "INSERT INTO ingSuppliers (name,platform,price_tag_start,price_tag_end,add_costs,notes,min_ml,min_gr) VALUES ('$name','$platform','$price_tag_start','$price_tag_end','$add_costs','$description','$min_ml','$min_gr')")){
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Supplier '.$name.' added!</div>';
	}else{
		echo mysqli_error($conn);
	}
	return;
}

if($_GET['supp'] == 'delete' && $_GET['ID']){
	$ID = mysqli_real_escape_string($conn, $_GET['ID']);
	$supplier = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM ingSuppliers WHERE id = '$ID'"));

	if(mysqli_query($conn, "DELETE FROM ingSuppliers WHERE id = '$ID'")){
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Supplier <strong>'.$supplier['name'].'</strong> removed!</div>';
	}
	return;
}


//ADD composition
if($_GET['composition'] == 'add'){
	$allgName = mysqli_real_escape_string($conn, $_GET['allgName']);
	$allgCAS = mysqli_real_escape_string($conn, $_GET['allgCAS']);
	$allgEC = mysqli_real_escape_string($conn, $_GET['allgEC']);	
	$allgPerc = rtrim(mysqli_real_escape_string($conn, $_GET['allgPerc']),'%');
	$ing = base64_decode($_GET['ing']);

	if(empty($allgName)){
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Error:</strong> Name is required!</div>';
		return;
	}
	if(empty($allgCAS)){
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Error:</strong> CAS number is required!</div>';
		return;
	}
	if(empty($allgPerc)){
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Error:</strong> Percentage is required!</div>';
		return;
	}
	if(mysqli_num_rows(mysqli_query($conn, "SELECT name FROM allergens WHERE name = '$allgName' AND ing = '$ing'"))){
		echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Error: </strong>'.$allgName.' already exists!</div>';
	}else{
		mysqli_query($conn, "INSERT INTO allergens (name,cas,ec,percentage,ing) VALUES ('$allgName','$allgCAS','$allgEC','$allgPerc','$ing')");
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>'.$allgName.'</strong> added to the list!</div>';
	}
	
	if($_GET['addToIng'] == 'true'){
		if(empty(mysqli_num_rows(mysqli_query($conn, "SELECT id FROM ingredients WHERE name = '$allgName'")))){
			mysqli_query($conn, "INSERT INTO ingredients (name,cas) VALUES ('$allgName','$allgCAS')");
		}
	}

	return;
}

//UPDATE composition
if($_GET['composition'] == 'update'){
	$value = rtrim(mysqli_real_escape_string($conn, $_POST['value']),'%');
	$id = mysqli_real_escape_string($conn, $_POST['pk']);
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$ing = base64_decode($_GET['ing']);

	mysqli_query($conn, "UPDATE allergens SET $name = '$value' WHERE id = '$id' AND ing='$ing'");
	return;
}

//DELETE composition	
if($_GET['composition'] == 'delete'){

	$id = mysqli_real_escape_string($conn, $_GET['allgID']);
	$ing = base64_decode($_GET['ing']);

	$delQ = mysqli_query($conn, "DELETE FROM allergens WHERE id = '$id' AND ing='$ing'");	
	if($delQ){
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>'.$ing.'</strong> removed!</div>';
	}
	return;
}

//DELETE INGREDIENT	
if($_POST['ingredient'] == 'delete' && $_POST['ing_id']){

	$id = mysqli_real_escape_string($conn, $_POST['ing_id']);
	$ing = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM ingredients WHERE id = '$id'"));
	
	if(mysqli_num_rows(mysqli_query($conn, "SELECT ingredient FROM formulas WHERE ingredient = '".$ing['name']."'"))){
		$response["error"] = '<strong>'.$ing['name'].'</strong> is in use by at least one formula and cannot be removed!</div>';
	}elseif(mysqli_query($conn, "DELETE FROM ingredients WHERE id = '$id'")){
		mysqli_query($conn,"DELETE FROM allergens WHERE ing = '".$ing['name']."'");
		$response["success"] = 'Ingredient <strong>'.$ing['name'].'</strong> removed from the database!';
	}
	
	echo json_encode($response);
	return;

}

//CUSTOMERS - ADD
if($_POST['customer'] == 'add'){
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	if(empty($name)){
		$response["error"] = 'Customer name is required.';
		echo json_encode($response);
		return;
	}
	$address = mysqli_real_escape_string($conn, $_POST['address']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$web = mysqli_real_escape_string($conn, $_POST['web']);
	if(mysqli_num_rows(mysqli_query($conn, "SELECT name FROM customers WHERE name = '$name'"))){
		$response["error"] = 'Error: '.$name.' already exists!';
	}elseif(mysqli_query($conn, "INSERT INTO customers (name,address,email,web) VALUES ('$name', '$address', '$email', '$web')")){
		$response["success"] = 'Customer '.$name.' added!';
	}else{
		$response["error"] = 'Error adding customer.';
	}
	echo json_encode($response);
	return;
}

//CUSTOMERS - DELETE
if($_POST['action'] == 'delete' && $_POST['type'] == 'customer' && $_POST['customer_id']){
	$customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
	if(mysqli_query($conn, "DELETE FROM customers WHERE id = '$customer_id'")){
		$response["success"] = 'Customer deleted!';
	}else{
		$response["error"] = 'Error deleting customer '.mysqli_error($conn);
	}
	
	echo json_encode($response);
	return;
}
	
//CUSTOMERS - UPDATE
if($_POST['update_customer_data'] && $_POST['customer_id']){
	$id = $_POST['customer_id'];
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	if(empty($name)){
		$response["error"] = 'Name cannot be empty ';
		echo json_encode($response);
		return;
	}
	$address = mysqli_real_escape_string($conn, $_POST['address'])?:'N/A';
	$email = mysqli_real_escape_string($conn, $_POST['email'])?:'N/A';
	$web = mysqli_real_escape_string($conn, $_POST['web'])?:'N/A';
	$phone = mysqli_real_escape_string($conn, $_POST['phone'])?:'N/A';

	if(mysqli_query($conn, "UPDATE customers SET name = '$name', address = '$address', email = '$email', web = '$web', phone = '$phone' WHERE id = '$id'")){
		$response["success"] = 'Customer details updated!';
	}else{
		$response["error"] = 'Error updating customer '.mysqli_error($conn);
	}
	echo json_encode($response);
	return;	
}

//MGM INGREDIENT
if($_POST['manage'] == 'ingredient' && $_POST['tab'] == 'general'){
	$ing = mysqli_real_escape_string($conn, $_POST['ing']);

	$INCI = trim(mysqli_real_escape_string($conn, $_POST["INCI"]));
	$cas = preg_replace('/\s+/', '', trim(mysqli_real_escape_string($conn, $_POST["cas"])));
	$einecs = preg_replace('/\s+/', '', trim(mysqli_real_escape_string($conn, $_POST["einecs"])));
	$reach = preg_replace('/\s+/', '', trim(mysqli_real_escape_string($conn, $_POST["reach"])));
	$fema = preg_replace('/\s+/', '', trim(mysqli_real_escape_string($conn, $_POST["fema"])));
	if($_POST["isAllergen"] == 'true') { $allergen = '1'; }else{ $allergen = '0'; }
	$purity = validateInput($_POST["purity"]);
	$profile = mysqli_real_escape_string($conn, $_POST["profile"]);
	$type = mysqli_real_escape_string($conn, $_POST["type"]);	
	$strength = mysqli_real_escape_string($conn, $_POST["strength"]);
	$category = mysqli_real_escape_string($conn, $_POST["category"] ? $_POST['category']: '1');
	$physical_state = mysqli_real_escape_string($conn, $_POST["physical_state"]);
	$odor = ucfirst(trim(mysqli_real_escape_string($conn, $_POST["odor"])));
	$notes = ucfirst(trim(mysqli_real_escape_string($conn, $_POST["notes"])));
	
//	if(mysqli_num_rows(mysqli_query($conn, "SELECT id FROM ingredients WHERE name = '".$_POST['name']."'"))){
		if(empty($_POST['name'])){
	
		$query = "UPDATE ingredients SET INCI = '$INCI',cas = '$cas', einecs = '$einecs', reach = '$reach',FEMA = '$fema',allergen='$allergen',purity='$purity',profile='$profile',type = '$type',strength = '$strength', category='$category',physical_state = '$physical_state',odor = '$odor',notes = '$notes' WHERE name='$ing'";
		
		if(mysqli_query($conn, $query)){
			echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>General details has been updated!</div>';
		}else{
			echo '<div class="alert alert-danger alert-dismissible"><strong>Error:</strong> '.mysqli_error($conn).'</div>';
		}
	}else{
		$name = sanChar(mysqli_real_escape_string($conn, $_POST["name"]));

		$query = "INSERT INTO ingredients (name, INCI, cas, reach, FEMA, type, strength, category, profile, notes, odor, purity, solvent, allergen, physical_state) VALUES ('$name', '$INCI', '$cas', '$reach', '$fema', '$type', '$strength', '$category', '$profile',  '$notes', '$odor', '$purity', '$solvent', '$allergen', '1')";
		
		if(mysqli_num_rows(mysqli_query($conn, "SELECT name FROM ingredients WHERE name = '$name'"))){
			echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Error: </strong>'.$name.' already exists!</div>';
		}else{
			if(mysqli_query($conn, $query)){
				echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Ingredient <strong>'.$name.'</strong> added!</div>';
			}else{
				echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Error:</strong> Failed to add!</div>';
			}
		}
	}

	return;	
}


if($_POST['manage'] == 'ingredient' && $_POST['tab'] == 'usage_limits'){
	$ingID = (int)$_POST['ingID'];
	if($_POST['flavor_use'] == 'true') { $flavor_use = '1'; }else{ $flavor_use = '0'; }
	if($_POST['noUsageLimit'] == 'true'){ $noUsageLimit = '1'; }else{ $noUsageLimit = '0'; }
	if($_POST['byPassIFRA'] == 'true'){ $byPassIFRA = '1'; }else{ $byPassIFRA = '0'; }
	$usage_type = mysqli_real_escape_string($conn, $_POST['usage_type']);
	$cat1 = validateInput($_POST['cat1'] ?: '100');
	$cat2 = validateInput($_POST['cat2'] ?: '100');
	$cat3 = validateInput($_POST['cat3'] ?: '100');
	$cat4 = validateInput($_POST['cat4'] ?: '100');
	$cat5A = validateInput($_POST['cat5A'] ?: '100');
	$cat5B = validateInput($_POST['cat5B'] ?: '100');
	$cat5C = validateInput($_POST['cat5C'] ?: '100');
	$cat5D = validateInput($_POST['cat5D'] ?: '100');
	$cat6 = validateInput($_POST['cat6'] ?: '100');
	$cat7A = validateInput($_POST['cat7A'] ?: '100');
	$cat7B = validateInput($_POST['cat7B'] ?: '100');
	$cat8 = validateInput($_POST['cat8'] ?: '100');
	$cat9 = validateInput($_POST['cat9'] ?: '100');
	$cat10A = validateInput($_POST['cat10A'] ?: '100');
	$cat10B = validateInput($_POST['cat10B'] ?: '100');
	$cat11A = validateInput($_POST['cat11A'] ?: '100');
	$cat11B = validateInput($_POST['cat11B'] ?: '100');
	$cat12 = validateInput($_POST['cat12'] ?: '100');
	
	$query = "UPDATE ingredients SET byPassIFRA = '$byPassIFRA', noUsageLimit = '$noUsageLimit',flavor_use='$flavor_use',usage_type = '$usage_type', cat1 = '$cat1', cat2 = '$cat2', cat3 = '$cat3', cat4 = '$cat4', cat5A = '$cat5A', cat5B = '$cat5B', cat5C = '$cat5C', cat5D = '$cat5D', cat6 = '$cat6', cat7A = '$cat7A', cat7B = '$cat7B', cat8 = '$cat8', cat9 = '$cat9', cat10A = '$cat10A', cat10B = '$cat10B', cat11A = '$cat11A', cat11B = '$cat11B', cat12 = '$cat12' WHERE id='$ingID'";
	if(mysqli_query($conn, $query)){
		$response["success"] = 'Usage limits has been updated!';
	}else{
			
		$response["error"] = 'Something went wrong '.mysqli_error($conn);
	}	
	echo json_encode($response);
	return;
}

if($_POST['manage'] == 'ingredient' && $_POST['tab'] == 'tech_data'){
	$ingID = (int)$_POST['ingID'];
	$tenacity = mysqli_real_escape_string($conn, $_POST["tenacity"]);
	$flash_point = mysqli_real_escape_string($conn, $_POST["flash_point"]);
	$chemical_name = mysqli_real_escape_string($conn, $_POST["chemical_name"]);
	$formula = mysqli_real_escape_string($conn, $_POST["formula"]);
	$logp = mysqli_real_escape_string($conn, $_POST["logp"]);
	$soluble = mysqli_real_escape_string($conn, $_POST["soluble"]);
	$molecularWeight = mysqli_real_escape_string($conn, $_POST["molecularWeight"]);
	$appearance = mysqli_real_escape_string($conn, $_POST["appearance"]);
	$rdi = (int)$_POST["rdi"]?:0;

	
	$query = "UPDATE ingredients SET tenacity='$tenacity',flash_point='$flash_point',chemical_name='$chemical_name',formula='$formula',logp = '$logp',soluble = '$soluble',molecularWeight = '$molecularWeight',appearance='$appearance',rdi='$rdi' WHERE id='$ingID'";
	if(mysqli_query($conn, $query)){
		$response["success"] = 'Technical data has been updated!';
	}else{
		$response["error"] = 'Something went wrong '.mysqli_error($conn);
	}	
	echo json_encode($response);
	return;
}

if($_POST['manage'] == 'ingredient' && $_POST['tab'] == 'note_impact'){
	$ingID = (int)$_POST['ingID'];
	$impact_top = mysqli_real_escape_string($conn, $_POST["impact_top"]);
	$impact_base = mysqli_real_escape_string($conn, $_POST["impact_base"]);
	$impact_heart = mysqli_real_escape_string($conn, $_POST["impact_heart"]);

	$query = "UPDATE ingredients SET impact_top = '$impact_top',impact_heart = '$impact_heart',impact_base = '$impact_base' WHERE id='$ingID'";
	if(mysqli_query($conn, $query)){
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Note impact has been updated!</div>';
	}else{
		echo '<div class="alert alert-danger alert-dismissible"><strong>Error:</strong> '.mysqli_error($conn).'</div>';
	}
	return;
}

if($_POST['manage'] == 'ingredient' && $_POST['tab'] == 'privacy'){
	$ingID = (int)$_POST['ingID'];
	if($_POST['isPrivate'] == 'true'){ $isPrivate = '1'; }else{ $isPrivate = '0'; }
	
	$query = "UPDATE ingredients SET isPrivate = '$isPrivate' WHERE id='$ingID'";
	if(mysqli_query($conn, $query)){
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Privacy has been updated!</div>';
	}else{
		echo '<div class="alert alert-danger alert-dismissible"><strong>Error:</strong> '.mysqli_error($conn).'</div>';
	}
	return;
}

if($_POST['manage'] == 'ingredient' && $_POST['tab'] == 'safety_info'){
	$ingID = (int)$_POST['ingID'];
	require_once(__ROOT__.'/func/updateGHS.php');
	if(updateGHS($ingID,$_POST['pictogram'],$conn)){
		echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Safety data has been updated!</div>';
	}else{
		echo '<div class="alert alert-danger alert-dismissible"><strong>Error:</strong> '.mysqli_error($conn).'</div>';
	}
	return;
}

if($_GET['import'] == 'ingredient'){
		$name = sanChar(mysqli_real_escape_string($conn, base64_decode($_GET["name"])));
		$query = "INSERT INTO ingredients (name, INCI, cas, notes, odor) VALUES ('$name', '$INCI', '$cas', 'Auto Imported', '$odor')";
		
		if(mysqli_num_rows(mysqli_query($conn, "SELECT name FROM ingredients WHERE name = '$name'"))){
			echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Error: </strong>'.$name.' already exists!</div>';
		}else{
			if(mysqli_query($conn, $query)){
				echo '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>Ingredient <strong>'.$name.'</strong> added!</div>';
			}else{
				echo '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">x</a><strong>Error:</strong> Failed to add '.mysqli_error($conn).'</div>';
			}
		}	
	return;
}

//CLONE INGREDIENT
if($_POST['action'] == 'clone' && $_POST['old_ing_name'] && $_POST['ing_id']){
	$ing_id = mysqli_real_escape_string($conn, $_POST['ing_id']);

	$old_ing_name = mysqli_real_escape_string($conn, $_POST['old_ing_name']);
	$new_ing_name = mysqli_real_escape_string($conn, $_POST['new_ing_name']);
	if(empty($new_ing_name)){
		$response['error'] = '<strong>Error: </strong>Please enter a name!';
		echo json_encode($response);
		return;
	}
	if(mysqli_num_rows(mysqli_query($conn, "SELECT name FROM ingredients WHERE name = '$new_ing_name'"))){
		$response['error'] = '<strong>Error: </strong>'.$new_ing_name.' already exists!';
		echo json_encode($response);
		return;
	}
	
	$sql.=mysqli_query($conn, "INSERT INTO allergens (ing,name,cas,percentage) SELECT '$new_ing_name',name,cas,percentage FROM allergens WHERE ing = '$old_ing_name'");

	$sql.=mysqli_query($conn, "INSERT INTO ingredients (name,INCI,type,strength,category,purity,cas,FEMA,reach,tenacity,chemical_name,formula,flash_point,appearance,notes,profile,solvent,odor,allergen,flavor_use,soluble,logp,cat1,cat2,cat3,cat4,cat5A,cat5B,cat5C,cat5D,cat6,cat7A,cat7B,cat8,cat9,cat10A,cat10B,cat11A,cat11B,cat12,impact_top,impact_heart,impact_base,created,usage_type,noUsageLimit,isPrivate,molecularWeight,physical_state) SELECT '$new_ing_name',INCI,type,strength,category,purity,cas,FEMA,reach,tenacity,chemical_name,formula,flash_point,appearance,notes,profile,solvent,odor,allergen,flavor_use,soluble,logp,cat1,cat2,cat3,cat4,cat5A,cat5B,cat5C,cat5D,cat6,cat7A,cat7B,cat8,cat9,cat10A,cat10B,cat11A,cat11B,cat12,impact_top,impact_heart,impact_base,created,usage_type,noUsageLimit,isPrivate,molecularWeight,physical_state FROM ingredients WHERE id = '$ing_id'");

	if($nID = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM ingredients WHERE name = '$new_ing_name'"))){
		
		$response['success'] = $old_ing_name.' cloned as <a href="/pages/mgmIngredient.php?id='.base64_encode($nID['name']).'" >'.$new_ing_name.'</a>!';
		echo json_encode($response);
		return;
	}
	
	return;
}



//RENAME INGREDIENT
if($_POST['action'] == 'rename' && $_POST['old_ing_name'] && $_POST['ing_id']){
	$ing_id = mysqli_real_escape_string($conn, $_POST['ing_id']);

	$old_ing_name = mysqli_real_escape_string($conn, $_POST['old_ing_name']);
	$new_ing_name = mysqli_real_escape_string($conn, $_POST['new_ing_name']);
	if(empty($new_ing_name)){
		$response['error'] = '<strong>Error: </strong>Please enter a name!';
		echo json_encode($response);
		return;
	}
	if(mysqli_num_rows(mysqli_query($conn, "SELECT name FROM ingredients WHERE name = '$new_ing_name'"))){
		$response['error'] = '<strong>Error: </strong>'.$new_ing_name.' already exists!';
		echo json_encode($response);
		return;
	}
	
	$sql.=mysqli_query($conn, "UPDATE allergens SET ing = '$new_ing_name' WHERE ing = '$old_ing_name'");

	$sql.=mysqli_query($conn, "UPDATE ingredients SET name = '$new_ing_name' WHERE name = '$old_ing_name' AND id = '$ing_id'");
	$sql.=mysqli_query($conn, "UPDATE formulas SET ingredient = '$new_ing_name' WHERE ingredient = '$old_ing_name' AND ingredient_id = '$ing_id'");

	if($nID = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM ingredients WHERE name = '$new_ing_name'"))){
		
		$response['success'] = $old_ing_name.' renamed to <a href="/pages/mgmIngredient.php?id='.base64_encode($nID['name']).'" >'.$new_ing_name.'</a>!';
		echo json_encode($response);
		return;
	}
	
	return;
}



header('Location: /');
exit;

?>
