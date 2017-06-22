<?php

require_once(ROOT . DS  .'vendor' . DS  . 'dompdf' . DS . 'autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'Lato-Hairline');
$dompdf = new Dompdf($options);

$dompdf = new Dompdf();




$html = '
<html>
<head>
  <style>
    @page { margin: 150px 15px 200px 30px; }
    #header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;}
    #footer { position: fixed; left: 0px; bottom: -200px; right: 0px; height: 200px;}
    #footer .page:after { content: content: counter(page); }
	
	
	@font-face {
		font-family: Lato;
		src: url("https://fonts.googleapis.com/css?family=Lato");
	}
	p{
		margin:0;font-family: Lato;font-weight: 100;line-height: 1;
	}
	table td{
		margin:0;font-family: Lato;font-weight: 100;padding:0;line-height: 1;
	}
	table.table_rows tr.odd{
		page-break-inside: avoid;
	}
	.table_rows, .table_rows th, .table_rows td {
	   border: 1px solid  #000;border-collapse: collapse;padding:2px; 
	}
	.table2 td{
		border: 0px solid  #000;font-size: 14px;padding:0px; 
	}
	.inner-table td{
		border: 0px solid  #000;padding:0px; 
	}
	.table_rows th{
		font-size:14px;
	}
	.avoid_break{
		page-break-inside: avoid;
	}
	</style>
<body>
  <div id="header" ><br/>	
		<table width="100%">
			<tr>
				<td width="50%">
				<img src='.ROOT . DS  . 'webroot' . DS  .'logos/'.$challan->company->logo.' height="80px" style="height:80px;"/>
				</td>
				<td align="right" width="50%" style="font-size: 12px;">
				<span style="font-size: 16px;">'. h($challan->company->name) .'</span><br/>
				<span>'. $this->Text->autoParagraph(h($challan->company->address)) .'</span>
				<span><img src='.ROOT . DS  . 'webroot' . DS  .'img/telephone.gif height="11px" style="height:11px;margin-top:5px;"/> '. h($challan->company->mobile_no).'</span> | 
				<span><img src='.ROOT . DS  . 'webroot' . DS  .'img/email.png height="15px" style="height:15px;margin-top:4px;"/> '. h($challan->company->email).'</span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<div align="center" style="font-size: 16px;font-weight: bold;color: #0685a8;">'. h(strtoupper($challan->challan_type)) .' CHALLAN</div>
					<div style="border:solid 2px #0685a8;margin-bottom:35px;margin-top: 5px;"></div>
				</td>
			</tr>
		</table>
  </div>
 

  <div id="content"> ';
  
$html.='
	<table width="100%" style="margin-top: 0px;">
	
		<tr>
		
			<td width="50%">Challan No :  '. h(($challan->ch1." /  CH-".str_pad($challan->ch2, 3, "0", STR_PAD_LEFT)." / ".$challan->ch3." / ".$challan->ch4)) .'<br/>';
				if($challan->customer_id){
				$html.='<span>'. h($challan->customer->customer_name) .'</span><br/>
				'. $this->Text->autoParagraph(h($challan->customer_address)) .'</span>';
				
				}else {
				$html.='<span>'. h($challan->vendor->company_name) .'</span><br/>
				'. $this->Text->autoParagraph(h($challan->vendor_address)) .'</span>';
				}
				
			$html.='</td>
			<td width="" valign="top" align="right">
				<table>
					<tr>
						<td>Invoice No.</td>
						<td width="20" align="center">:</td>';
						if($challan->invoice_id){
						$html.='<td>'. h(($challan->invoice->in1."/IN-".str_pad($challan->invoice->in2, 3, "0", STR_PAD_LEFT)."/".$challan->invoice->in3."/".$challan->invoice->in4)) .'</td>';
						}else {
						$html.='<td>'. h(($challan->invoice_booking->ib1."/IB-".str_pad($challan->invoice_booking->ib2, 3, "0", STR_PAD_LEFT)."/".$challan->invoice_booking->ib3."/".$challan->invoice_booking->ib4)).'</td>';
						}
						
					$html.='</tr>
					<tr>
						<td>Date</td>
						<td width="20" align="center">:</td>
						<td>'. h(date("d-m-Y",strtotime($challan->created_on))) .'</td>
					</tr>
					<tr>
						<td>LR No.</td>
						<td width="20" align="center">:</td>
						<td>'. h($challan->lr_no) .'</td>
					</tr>
					<tr>
						<td>Carrier</td>
						<td width="20" align="center">:</td>
						<td>'. h($challan->transporter->transporter_name) .'</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
';
  
   

$html.='
<table width="100%" class="table_rows">
		<tr>
			<th width="30">S No</th>
			<th>Item Description</th>
			
			<th width="10">Quantity</th>
			<th width="10">Rate</th>
			<th width="10">Amount</th>
		</tr>
';

$sr=0; foreach ($challan->challan_rows as $challanRows): $sr++; 
$html.='
	<tr>
		<td valign="top" align="center">'. h($sr) .'</td>
		<td>'. $this->Text->autoParagraph(h($challanRows->description)) .'</td>
	
		<td align="center" valign="top">'. h($challanRows->quantity) .'</td>
		<td align="right" style="width: 10;" valign="top">'. $this->Number->format($challanRows->rate,[ 'places' => 2]).'</td>
		<td align="right" style="width: 10;" valign="top">'. $this->Number->format($challanRows->amount,[ 'places' => 2]) .'</td>
	</tr>';
endforeach;

 
$total=explode('.',$challan->total);
$rupees=$total[0];
if(sizeof($total)==2){
	$paisa=(int)$total[1];
}else{ $paisa=""; }


$html.='
	<tbody>
			<tr>
				<td colspan="4" style="text-align:right;border-top: none !important;">Total</td>
				<td style="text-align:right;border-top: none !important;" width="10">'. $this->Number->format($challan->total,[ 'places' => 2]) .'</td>
			</tr>
			
		
		<tr>
				<td colspan="5"><table  width="100%" class="inner-table" ><tr><td valign="top" width="18%"> <b><div style="margin-top:5px;">Amount in words: </div></b></td><td  valign="top">'. h(ucwords($this->NumberWords->convert_number_to_words($rupees))) .'  Rupees and '. h(ucwords($this->NumberWords->convert_number_to_words($paisa))) .' Paisa</td></tr></table></td>
			</tr>
		<tr>
				<td colspan="5"><table  width="100%" class="inner-table" ><tr><td valign="top" width="18%"> <b><div style="margin-top:5px;">Documents: </div></b></td><td  valign="top">'. h($challan->documents) .' </td></tr></table></td>
			</tr>
		</tbody>
	</table>'; 
		
  		
$html .= '<div id="footer">
   <table width="100%" class="divFooter">
			<tr>
				<td >
					<table>
						<tr>
							<td >Invoice is Subject to Udaipur jurisdiction</td>
						</tr>
					</table>
					<table>
						<tr>
							<td>TIN</td>
							<td>: '. h($challan->company->tin_no) .'</td>
						</tr>
						<tr width="30">
							<td>PAN</td>
							<td>: '. h($challan->company->pan_no) .'</td>
						</tr>
						<tr>
							<td>CIN</td>
							<td>: '. h($challan->company->cin_no) .'</td>
						</tr>
					</table>
				</td>
				<td align="right" >
					<div align="center">
						<span>For <b>'. h($challan->company->name) .'</b></span><br/>
						<img src='.ROOT . DS  . 'webroot' . DS  .'signatures/'.$challan->creator->signature.' height="50px" style="height:50px;"/>
						<br/>
						<span><b>Authorised Signatory</b></span><br/>
						<span>'. h($challan->creator->name) .'</span><br/>
						
					</div>
				</td>
			</tr>
		</table>
  </div>';
  
  
  
  

 $html .= '</div>
</body>
</html>';

//echo $html; exit; 


$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($name,array('Attachment'=>0));
exit(0);
?>
