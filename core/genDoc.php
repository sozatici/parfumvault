<?php
define('__ROOT__', dirname(dirname(__FILE__))); 
define('FPDF_FONTPATH',__ROOT__.'/fonts');

require_once(__ROOT__.'/inc/sec.php');
require_once(__ROOT__.'/inc/opendb.php');
require_once(__ROOT__.'/inc/settings.php');
require_once(__ROOT__.'/inc/product.php');

require_once(__ROOT__.'/libs/fpdf.php');

$imageData = base64_decode(explode(',', $settings['brandLogo'])[1]);
$tempImagePath = $tmp_path.'/temp_logo.png';
file_put_contents($tempImagePath, $imageData);

define('__PVLOGO__', $tempImagePath ?:  __ROOT__.'/img/logo.png');


if ($_REQUEST['action'] == 'generateSDS' && $_REQUEST['kind'] == 'ingredient'){
	
	$ingName = mysqli_real_escape_string($conn, $_REQUEST['name']);
	$ingID = $_REQUEST['id'];
	define('__INGNAME__',$ingName);

	$supplierID = $_REQUEST['ingSupplier'];
	
	
	$ingData = mysqli_fetch_array(mysqli_query($conn,"SELECT cas,INCI,reach,einecs,chemical_name,formula,flash_point,appearance FROM ingredients WHERE id = '$ingID'"));
	$supplier = mysqli_fetch_array(mysqli_query($conn,"SELECT name,address,po,country,telephone,url,email FROM ingSuppliers WHERE id = '$supplierID'"));


	$ingredient_compounds_count = 0;
	
	$q = mysqli_query($conn, "SELECT * FROM ingredients WHERE id='$ingID'");
	$res = mysqli_fetch_assoc($q);
	
	$g['name'] = (string)$res['name'];
	$g['INCI'] = (string)$res['INCI'] ?: 'N/A';
	define('__INGCAS__', $res['cas'] ?: 'N/A');
	$g['FEMA'] = (string)$res['FEMA']?: 'N/A';
	$g['einecs'] = (string)$res['einecs']?: 'N/A';
	$g['reach'] = (string)$res['reach']?: 'N/A';
	$g['notes'] = (string)$res['notes']?: 'N/A';
	$g['odor'] = (string)$res['odor'];
	$g['physical_state'] = (int)$res['physical_state'];
	$g['physical_state'] = $g['physical_state'] === 1 ? 'Liquid' : ($g['physical_state'] === 2 ? 'Solid' : 'Unknown');

	$t['tenacity'] = (string)$res['tenacity']?: 'N/A';
	$t['chemical_name'] = (string)$res['chemical_name']?: 'N/A';
	$t['formula'] = (string)$res['formula']?: 'N/A';
	$t['flash_point'] = (string)$res['flash_point']?: 'N/A';
	$t['flavor_use'] = (int)$res['flavor_use'];
	$t['soluble'] = (string)$res['soluble']?: 'N/A';
	$t['logp'] = (string)$res['logp']?: 'N/A';
	$t['appearance'] = (string)$res['appearance']?: 'N/A';
	$t['molecularWeight'] = (string)$res['molecularWeight']?: 'N/A';

	
	$i['cat1'] = (double)$res['cat1'];
	$i['cat2'] = (double)$res['cat2'];
	$i['cat3'] = (double)$res['cat3'];
	$i['cat4'] = (double)$res['cat4'];
	$i['cat5A'] = (double)$res['cat5A'];
	$i['cat5B'] = (double)$res['cat5B'];
	$i['cat5C'] = (double)$res['cat5C'];
	$i['cat6'] = (double)$res['cat6'];
	$i['cat7A'] = (double)$res['cat7A'];
	$i['cat7B'] = (double)$res['cat7B'];
	$i['cat8'] = (double)$res['cat8'];
	$i['cat9'] = (double)$res['cat9'];
	$i['cat10A'] = (double)$res['cat10A'];
	$i['cat10B'] = (double)$res['cat10B'];
	$i['cat11A'] = (double)$res['cat11A'];
	$i['cat11B'] = (double)$res['cat11B'];
	$i['cat12'] = (double)$res['cat12'];
	
	

	
	$ing[] = $g;
	$ifra[] = $i;
	$tech[] = $t;

	
	
	$q = mysqli_query($conn, "SELECT * FROM ingredient_compounds WHERE ing ='".$ing['0']['name']."'");
	while($res = mysqli_fetch_assoc($q)){

		$c['ing'] = (string)$res['ing'];
		$c['name'] = (string)$res['name'];
		$c['CAS'] = (string)$res['cas'] ?: 'N/A';
		$c['EINECS'] = (string)$res['ec'] ?: 'N/A';
		$c['Concentration'] = (double)$res['percentage'];
		$c['GHS'] = (string)$res['GHS'] ?: 'N/A';

		$cmp[] = $c;
		$ingredient_compounds_count++;
	}
	
	
	
	
	$vd['product'] = $product;
	$vd['version'] = $ver;
	$vd['ingredients'] = $ingredient;
	$vd['timestamp'] = date('d/m/Y H:i:s');
	
	$result['General'] = $ing;
	$result['IFRA'] = $ifra;
	$result['Technical Data'] = $tech;	
	$result['compositions'] = $cmp;	

	$json_data = json_encode($result);
	$data = json_decode($json_data, true);

	class PDF extends FPDF {
		private $logoPath;
	
		function __construct($logoPath) {
			parent::__construct();
			$this->logoPath = $logoPath;
		}

		function Header() {
			$this->Image($this->logoPath, 10, 6, 30);			
			$this->Ln(20);

			$this->SetFont('Arial', 'B', 14);
			$this->Cell(0, 8, __INGNAME__, 0, 1, 'C');
			$this->SetFont('Arial', 'B', 8);
			$this->Cell(0, 5, "CAS: ".__INGCAS__, 0, 1, 'C');

			$this->Ln(5);

		}
	
		function Footer() {
			$this->SetY(-20);
			$this->Cell(0, 10, 'Page ' . $this->PageNo() . ' of {nb}', 0, 1, 'C');
	
			$footerText = 'This document is generated by calculation based on the ingredients present in the formula. The information contained herein is, to the best of our knowledge, true and accurate at the date of issue. It is provided to the customer for information and internal use only. It is not a confirmation of compliance and it is customer responsibility to perform his own evaluation on the product, including with respect to end-use application.';
			$this->SetFont('Arial', '', 5);
			$this->MultiCell(0, 3, $footerText, 0, 'C');
		}
	}
	
	$pdf = new PDF(__PVLOGO__);
	//$pdf = new PDF($tempImagePath);

	$pdf->AliasNbPages(); // Set total number of pages
	$pdf->AddPage();
	
	function addSection($pdf, $title, $content) {
		$pdf->SetFont('Arial', 'B', 12);
	
		$pdf->SetFillColor(3, 189, 123);
		$pdf->SetTextColor(255, 255, 255);
	
		$pdf->Cell(0, 10, $title, 0, 1, 'L', true);
		$pdf->SetTextColor(0, 0, 0);
	
		$pdf->SetFont('Arial', '', 8);
	
		if ($title == 'Compositions' && is_array($content) && !empty($content)) {
			$pdf->SetFillColor(211, 211, 211); // Light gray
			$headers = array_keys($content[0]);
			$headers = array_diff($headers, ['ing']);
			
			foreach ($headers as $header) {
          		$pdf->Cell(38, 8, ucfirst($header), 1, 0, 'C', true);
			}
			$pdf->Ln();

			// Add table data
			$pdf->SetFont('Arial', '', 8);
			foreach ($content as $row) {
            	foreach ($headers as $header) {
					$cellText = $header == 'Concentration' ? $row[$header] . '%' : $row[$header];
				//	if ($header == 'GHS') {
						//$pdf->MultiCell(38, 5, $cellText, 1);
				//	} else {
						$pdf->Cell(38, 10, $cellText, 1);
               //}
            	}
            $pdf->Ln();
        }
			
		} else if ($title == 'General' && is_array($content) && !empty($content)) {
			foreach ($content as $ingredient) {
				foreach ($ingredient as $key => $value) {
					// Skip specific fields
					if (!in_array($key, ['name'] )) {
						$pdf->Cell(0, 10, ucfirst($key) . ': ' . $value, 0, 1);
					}
				}
				$pdf->Ln();
			}
			
		} else if ($title == 'Technical Data' && is_array($content) && !empty($content)) {
			foreach ($content as $ingredient) {
				foreach ($ingredient as $key => $value) {
					// Skip specific fields
					if (!in_array($key, ['name'] )) {
						$pdf->Cell(0, 10, ucfirst($key) . ': ' . $value, 0, 1);
					}
				}
				$pdf->Ln();
			}
			
		} else if ($title == 'IFRA' && is_array($content) && !empty($content)) {
			$pdf->SetFillColor(211, 211, 211); // Light gray
			$pdf->Cell(95, 10, 'Category', 1, 0, 'C', true);
			$pdf->Cell(95, 10, 'Percentage', 1, 1, 'C', true);
			
			foreach ($content[0] as $key => $value) {
				$pdf->Cell(95, 10, ucfirst($key), 1, 0, 'C');
				$pdf->Cell(95, 10, $value, 1, 1, 'C');
			}
		} else {
			foreach ($content as $key => $value) {
				if (is_array($value)) {
					$pdf->Cell(0, 10, "$key:", 0, 1);
					foreach ($value as $subKey => $subValue) {
						if (!in_array($subKey, ['id', 'ing'])) {
							$pdf->Cell(0, 10, "    $subKey: $subValue", 0, 1);
						}
					}
				} else {
					if (!in_array($key, ['id', 'ing'])) {
						$pdf->Cell(0, 10, "$key: $value", 0, 1);
					}
				}
			}
		}
		$pdf->Ln(10);
	}

	foreach ($data as $section => $content) {
		addSection($pdf, ucfirst($section), $content);
	}


	
	$content = mysqli_real_escape_string($conn,$pdf->Output("S"));
	//DIRTY WAY TO CLEANUP //TODO
	mysqli_query($conn, "DELETE FROM documents WHERE ownerID = '$ingID' AND type = '0' AND notes = 'PV Generated'");
	
	if(mysqli_query($conn, "INSERT INTO documents(ownerID,type,name,docData,notes) values('$ingID','0','$ingName','$content','PV Generated')")){
		$response["success"] = '<a href="/pages/viewDoc.php?id='.mysqli_insert_id($conn).'&type=internal" target="_blank">Download file</a>';
	}else{
		$response["error"] = "Unable to generate PDF";
	}


	echo json_encode($response);
	return;	
}

?>