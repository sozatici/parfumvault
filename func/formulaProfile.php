<?php
function formulaProfile($dbhost,$dbuser,$dbpass,$dbname,$profile = null){
	echo '<table width="100%" border="0" cellspacing="0" id="tdData" class="table table-striped table-bordered table-sm">
                  <thead>
                    <tr>
                      <th width="14%">Name</th>
                      <th width="20%">Notes</th>
                      <th width="23%">Created</th>
                      <th width="21%">Actions</th>
                    </tr>
                  </thead>
                  <tbody>';
	$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to database');
	if(empty($profile)){
		$formulas_n = mysqli_query($conn, "SELECT * FROM formulasMetaData ORDER by name DESC");
	}else{
		$formulas_n = mysqli_query($conn, "SELECT * FROM formulasMetaData WHERE profile = '$profile' ORDER by name DESC");
	}
	while ($formula = mysqli_fetch_array($formulas_n)) {
		echo'<tr><td align="center"><a href="?do=Formula&name='.$formula['name'].'">'.$formula['name'].'</a></td>';
		$meta = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM formulasMetaData WHERE name = '".$formula['name']."'"));
		echo '<td align="center"><a href="pages/getFormMeta.php?id='.$meta['id'].'" class="fas fa-comment-dots popup-link"></a></td>';
		echo '<td align="center">'.$meta['created'].'</td>';
		echo '<td align="center"><a> <a href="?do=dashboard&action=delete&name='.$formula['name'].'" onclick="return confirm(\'Delete '.$formula['name'].' Formula?\');" class="fas fa-trash" rel="tipsy" title="Delete '.$formula['name'].'"></a></td></tr>';
	}
	echo '</tbody></table>';
}
?>