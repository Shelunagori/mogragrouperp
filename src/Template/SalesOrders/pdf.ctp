
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
    @page { margin: 130px 15px 20px 30px; }
    #header { position: fixed; left: 0px; top: -130px; right: 0px; height: 130px;}
    #footer { position: fixed; left: 0px; bottom: -20px; right: 0px; height: 20px;text-align:center;}
    #footer .page:after { content: content: counter(page); }
	#footer { display:none; }
	
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
	
	.table_rows th{
		font-size:14px;
	}
	
	.table2 td{
		border: 0px solid  #000;font-size: 13px;padding:0px; 
	}
	.avoid_break{
		page-break-inside: avoid;
	}
	</style>
<body>
  <div id="header">
		<table width="100%">
			<tr>
				<td width="35%" rowspan="2">
				<img src='.ROOT . DS  . 'webroot' . DS  .'logos/'.$salesOrder->company->logo.' height="80px" style="height:80px;"/>
				</td>
				<td colspan="2" align="right">
				<+>'. h($salesOrder->company->name) .'</span>
				</td>
			</tr>
			<tr>
				<td width="30%" valign="bottom">
				<div align="center" style="font-size: 28px;font-weight: bold;color: #0685a8;">SALES ORDER</div>
				</td>
				<td align="right" width="35%" style="font-size: 12px;">
				<span>'. $this->Text->autoParagraph(h($salesOrder->company->address)) .'</span>
				<span><img src='.ROOT . DS  . 'webroot' . DS  .'img/telephone.gif height="11px" style="height:11px;margin-top:5px;"/> '. h($salesOrder->company->mobile_no).'</span> | 
				<span><img src='.ROOT . DS  . 'webroot' . DS  .'img/email.png height="15px" style="height:15px;margin-top:4px;"/> '. h($salesOrder->company->email).'</span>
				</td>
			</tr>
			<tr>
				<td colspan="3" >
					<div style="border:solid 2px #0685a8;margin-top: 5px; margin-top:15px;"></div>
				</td>
			</tr>
		</table>
  </div>
  <div id="footer">
    <p class="page">Page : </p>
  </div>

  <div id="content"> ';
  
$html.='
	<table width="100%">
		<tr>
			<td width="53%">
				<span>'. h(($salesOrder->customer->customer_name)) .'</span><br/>
				'. $this->Text->autoParagraph(h($salesOrder->customer_address)) .'<br/>
				<span>Customer P.O. No. '. h($salesOrder->customer_po_no).' dated '. h(date("d-m-Y",strtotime($salesOrder->po_date))).'</span><br/><br/>
			</td>
			<td width="47%" valign="top" align="right">
				<table>
					<tr>
						<td style="width:110px;" >Sales Order No</td>
						<td style="width:5px;">:</td>
						<td>'. h(($salesOrder->so1."/SO-".str_pad($salesOrder->so2, 3, "0", STR_PAD_LEFT)."/".$salesOrder->so3."/".$salesOrder->so4)) .'</td>
					</tr>
					<tr>
						<td>Date</td>
						<td width="2" align="center">:</td>
						<td>'. h(date("d-m-Y",strtotime($salesOrder->created_on))) .'</td>
					</tr>
					
				</table>
			</td>
		</tr>
	</table>';
 
$html.='<br/>
<table width="100%" class="table_rows">
		<tr>
			<th style="white-space: nowrap;">S No</th>
			<th>Item</th>
			<th>Unit</th>
			<th>Quantity</th>
			<th>Rate</th>
			<th>Amount</th>
			<th style="white-space: nowrap;">Excise Duty</th>
			<th style="white-space: nowrap;">Sale Tax(%)</th>
		</tr>
';

$sr=0; foreach ($salesOrder->sales_order_rows as $salesOrderRows): $sr++; 
$html.='
	<tr class="odd">
		<td valign="top" align="center" style="padding-top:10px;">'. h($sr) .'</td>
		<td style="padding-top:10px;" width="100%">';
		
		if(!empty($salesOrderRows->description)){
			$html.= h($salesOrderRows->item->name);
		}else{
			$html.= h($salesOrderRows->item->name).'<div style="height:'.$salesOrderRows->height.'"></div> ';
		}
		
		
		$html.='</td>
		<td align="right" valign="top"  style="padding-top:10px;">'. h($salesOrderRows->item->unit->name) .'</td>
		<td valign="top" align="center" style="padding-top:10px;">'. h($salesOrderRows->quantity) .'</td>
		<td align="right" valign="top" style="padding-top:10px;">'. $this->Number->format($salesOrderRows->rate,[ 'places' => 2]) .'</td>
		<td align="right" valign="top"  style="padding-top:10px;">'. $this->Number->format($salesOrderRows->amount,[ 'places' => 2]) .'</td>
		<td align="center" valign="top" style="padding-top:10px;">'. h($salesOrderRows->excise_duty) .'</td>
		<td align="center" valign="top" style="padding-top:10px;">'. $this->Number->format($salesOrderRows->sale_tax->tax_figure,[ 'places' => 2]) .'</td>
	</tr>';
	if(!empty($salesOrderRows->description)){
		$html.='
		<tr class="even">
			<td></td>
			<td colspan="7" style="text-align: justify;"><b> </b>'.$salesOrderRows->description.'<div style="height:'.$salesOrderRows->height.'"></div></td>
		</tr>';
	}
endforeach;

if($salesOrder->discount_type=='1'){ $discount_text='Discount @ '.$salesOrder->discount_per.'%'; }else{ $discount_text='Discount'; }
if($salesOrder->pnf_type=='1'){ $pnf_text='P&F @ '.$salesOrder->pnf_per.'%'; }else{ $pnf_text='P&F'; }
$html.='</table>';		
$html.='
<table width="100%" class="table_rows">
	<tbody>';
		if(!empty($salesOrder->discount)){
		$html.='<tr>
					<td style="text-align:right;">'.$discount_text.'</td>
					<td style="text-align:right;" width="104">'. $this->Number->format($salesOrder->discount,[ 'places' => 2]).'</td>
				</tr>';
		}
		if(!empty($salesOrder->exceise_duty)){
		$html.='<tr>
					<td style="text-align:right;">'. $this->Text->autoParagraph(h($salesOrder->ed_description)) .'</td>
					<td style="text-align:right;" width="104">'. $this->Number->format($salesOrder->exceise_duty,[ 'places' => 2]).'</td>
				</tr>';
		}
	
		$html.='<tr>
				<td style="text-align:right;">Total</td>
				<td style="text-align:right;" width="104">'. $this->Number->format($salesOrder->total,[ 'places' => 2]).'</td>
			</tr>';
		if(!empty($salesOrder->pnf)){
		$html.='<tr>
					<td style="text-align:right;">'. $pnf_text .'</td>
					<td style="text-align:right;" width="104">'. $this->Number->format($salesOrder->pnf,[ 'places' => 2]).'</td>
				</tr>';
		}
		if(!empty($salesOrder->pnf)){
		$html.='<tr>
					<td style="text-align:right;">Total after P&F</td>
					<td style="text-align:right;" width="104">'. $this->Number->format($salesOrder->total_after_pnf,[ 'places' => 2]).'</td>
				</tr>';
		}
			
			
		$html.='</tbody>
	</table>'; 
	
$html.='
	<table width="100%">
		<tr>
			<td width="60%" valign="top">
				<table>
					<tr>
						<td valign="top">Transporter</td>
						<td>:</td>
						<td width="40%"> '. h($salesOrder->carrier->transporter_name) .'</td>
					</tr>
					<tr>
						<td valign="top">Carrier</td>
						<td>:</td>
						<td> '. h($salesOrder->courier->transporter_name) .'</td>
					</tr>
					<tr>
						<td valign="top">Delivery Description</td>
						<td>:</td>
						<td> '. h($salesOrder->delivery_description).'</td>
					</tr>
					<tr>
						<td valign="top" width="35%">Additional Note</td>
						<td width="5%">:</td>
						<td width="50%"> '. h($salesOrder->additional_note).'</td>
					</tr>
				</table>
			</td>
			<td valign="top">
				<table>
					<tr>
						<td valign="top">Form-49 Required</td>
						<td>:</td>
						<td>'. h($salesOrder->form49).'</td>
					</tr>
					<tr>
						<td valign="top">Expected Delivery Date</td>
						<td>:</td>
						<td> '. h(date("d-m-Y",strtotime($salesOrder->expected_delivery_date))).'</td>
						
					</tr>
					<tr>
						<td valign="top">Road Permit Required</td>
						<td>:</td>
						<td> '. h($salesOrder->road_permit_required).'</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br/>
	<b>Dispatch Details</b>
	<table width="100%" >
		<tr>
			<td valign="top">Name</td>
			<td valign="top"> : <td>
			<td valign="top">'. h($salesOrder->dispatch_name).'</td>
			<td width="10%"></td>
			<td valign="top">Mobile</td>
			<td valign="top"> : <td>
			<td valign="top">'. h($salesOrder->dispatch_mobile).'</td>
		</tr>
		<tr>
			<td valign="top">Address</td>
			<td valign="top"> : <td>
			<td valign="top" width="60%" >'. h($salesOrder->dispatch_address).'</td>
			<td></td>
			<td valign="top">Email</td>
			<td valign="top"> : <td>
			<td valign="top">'. h($salesOrder->dispatch_email).'</td>
		</tr>
	</table>
';

$html.='<table width="100%">
		<tr><td width="40%" align="right"></td><td width="30%" align="right">';
		
if(!empty($salesOrder->edited_by)){
$html.='<div align="center">
		<img src='.ROOT . DS  . 'webroot' . DS  .'signatures/'.$salesOrder->editor->signature.' height="50px" style="height:50px;"/>
		<br/>
		<span><b>Edited by</b></span><br/>
		<span>'. h($salesOrder->editor->name) .'</span><br/>
		
		On '. h(date("d-m-Y",strtotime($salesOrder->edited_on))).','. h(date("h:i:s A",strtotime($salesOrder->edited_on_time))).'<br/>
		</div>';
}
			
$html.='</td>
<td align="right">
			<div align="center">
			<img src='.ROOT . DS  . 'webroot' . DS  .'signatures/'.$salesOrder->creator->signature.' height="50px" style="height:50px;"/>
			<br/>
			<span><b>Created by</b></span><br/>
			
			<span>'. h($salesOrder->creator->name).' </span><br/>
			On '. h(date("d-m-Y",strtotime($salesOrder->created_on))).','. h(date("h:i:s A",strtotime($salesOrder->created_on_time))).'<br/>
			</div>
		</td>';
			
			
$html.='</tr>
	</table>';

$html .= '</div>
</body>
</html>';
  
//echo $html; exit;
 
$name='Sales_Order-'.h(($salesOrder->so1.'_'.str_pad($salesOrder->so2, 3, '0', STR_PAD_LEFT).'_'.$salesOrder->so3.'_'.$salesOrder->so4));
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($name,array('Attachment'=>0));
exit(0);
?>
