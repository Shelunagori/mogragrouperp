<style>
@media print{
.maindiv{
width:100% !important;
}	
	
}
</style>
<a class="btn  blue hidden-print margin-bottom-5 pull-right" onclick="javascript:window.print();">Print <i class="fa fa-print"></i></a>
<div class="portlet light bordered">
	
		<div class="row">
			<div class="col-md-12">
				<div class="caption">
				<h4 class="caption-subject font-blue-steel uppercase" >EMPLOYEE PERSONAL INFORMATION</h4>
				</div>
			</div>
			
		</div>
			<div class="row">
				<div class="col-md-12">
					<form method="GET" >
						
					<table>
						<thead>
							<tr border="2px">
								<h4 class="table table-bordered table-striped table-hover"><b>1.EMPLOYEE PERSONAL INFORMATION</b></h4>
							</tr>
							<tr>
								<th width="20%">Employee Name:</th>
								<th width="30%" style="text-align:center"><?php echo $employee->name?></th>
							</tr>
							<tr>
								<th>Date Of Birth:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th>Father/Mother/Husband Name:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th>Gender:</th>
								<th style="text-align:center"></th>
								<th>Marital Status:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th>Identity Mark:</th>
								<th style="text-align:center"></th>
								<th>Height (in cms):</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th>Caste:</th>
								<th style="text-align:center"></th>
								<th>Category:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th>Religion:</th>
								<th style="text-align:center"></th>
								<th>Blood Group:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th>Home State:</th>
								<th style="text-align:center"></th>
								<th>Home District:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th>Adhar Card No.:</th>
								<th style="text-align:center"></th>
								<th>Driving Licence No.:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th>Passport No.:</th>
								<th style="text-align:center"></th>
								<th>Pan Card No.:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th>Current/Saving Account No.:</th>
								<th style="text-align:center"></th>
								<th>Bank & Branch:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th>IFSC Code Of Branch:</th>
								<th style="text-align:center"></th>
								
							</tr>
						</thead>
					</table>
					<br>
					<table>
						<thead>
							<tr >
								<h4 class="table table-bordered table-striped table-hover"><b>Present Address details </b></h4>
							</tr>
							<tr>
								<th width="20%">Present Address:</th>
								<th style="text-align:center"></th>
								
							</tr>
							<tr>
								<th style="width:20%">State:</th>
								<th width="30%" style="text-align:center"></th>
								<th style="width:24%%">District:</th>
								<th width="20%" style="text-align:center"></th>
								<th style="width:10%">Pincode:</th>
								<th width="10%" style="text-align:center"></th>
							</tr>
							<tr>
								<th width="20%">Mobile No.:</th>
								<th width="30%" style="text-align:center"></th>
								<th width="10%">Phone No.:</th>
								<th width="20%" style="text-align:center"></th>
								<th width="10%">Email:</th>
								<th width="10%" style="text-align:center"></th>
							</tr>
						</thead>
					</table>
					<br>
					<table>
						<thead>
							<tr>
								<h4 class="table table-bordered table-striped table-hover"><b>Permanent Address details </b></h4>
							</tr>	
							<tr>
								<th>Permanent Address:</th>
								<th style="text-align:center"></th>
								
							</tr>
							<tr>
								<th width="10%">State:</th>
								<th width="30%" style="text-align:center"></th>
								<th width="10%">District:</th>
								<th width="20%" style="text-align:center"></th>
								<th width="10%">Pin Code:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th width="20%">Mobile No.:</th>
								<th width="30%" style="text-align:center"></th>
								<th width="20%">Phone No.:</th>
								<th width="10%" style="text-align:center"></th>
								<th width="10%">Email:</th>
								<th width="30%" style="text-align:center"></th>
							</tr>
						</tr>
						</thead>
					</table><br>
					<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th colspan="5"><b>2. EMPLOYEE FAMILY INFORMATION</b></th> 
							</tr>
							<tr>
								<th width="20%" style="text-align:center"><b>Family Member Name</th>
								<th width="10%" style="text-align:center"><b>Relation</th>
								<th width="10%" style="text-align:center"><b>Date Of Birth</th>
								<th width="20%" style="text-align:center"><b>Dependent</th>
								<th width="30%" style="text-align:center"><b>Whether Employed (State/Centre/unemployed Private</th>
								
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</thead>
					</table>
					<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th colspan="6"><b>3. Employee Emergency Details</b></th> 
							</tr>
							<tr>
								<th width="10%" style="text-align:center"><b>S.No</th>
								<th width="20%" style="text-align:center"><b>Name</th>
								<th width="30%" style="text-align:center"><b>Address</th>
								<th width="10%" style="text-align:center"><b>Relationship</th>
								<th width="10%" style="text-align:center"><b>Mobile No.</th>
								<th width="10%" style="text-align:center"><b>Telephone No.</th>
								
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</thead>
					</table>
					<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th colspan="5"><b>4.Employee Reference Details</b></th> 
							</tr>
							<tr>
								<th width="10%" style="text-align:center"><b>S.No</th>
								<th width="20%" style="text-align:center"><b>Name</th>
								<th width="30%" style="text-align:center"><b>Address</th>
								<th width="10%" style="text-align:center"><b>Mobile No.</th>
								<th width="10%" style="text-align:center"><b>Telephone No.</th>
								
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</thead>
					</table>
					<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th colspan="5"><b>5.	Employee Work Experience</b></th> 
							</tr>
							<tr>
								<th width="10%" style="text-align:center"><b>S.No</th>
								<th width="20%" style="text-align:center"><b>Period</th>
								<th width="30%" style="text-align:center"><b>Name Of Company</th>
								<th width="20%" style="text-align:center"><b>Designation</th>
								<th width="20%" style="text-align:center"><b>Nature Of The Duties</th>
								
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</thead>
					</table>
					<table >
						<thead>
							<tr >
								<h4 class="table table-bordered table-striped table-hover"><b>6.	Employee Nomination Information</b></h4> 
							</tr>
							<tr >
								<h4><b>Nomination Details</b></h4>
							</tr>
							<tr>
								<th width="20%">Name Of The Nominee:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th width="20%">Relation With The Employee:</th>
								<th width="40%" style="text-align:center"></th>
								<th>Type Of Nomination:</th>
								<th style="text-align:center"></th>
							</tr>
							
							<tr>
								<th>Present Address:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th>State:</th>
								<th style="text-align:center"></th>
								<th>District:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th>Pincode:</th>
								<th style="text-align:center"></th>
								<th>Mobile No:</th>
								<th style="text-align:center"></th>
							</tr>
							
						</thead>
					</table>
					<table >
						<thead>
							<tr >
								<h4 class="table table-bordered table-striped table-hover"><b>6.	Employee Professional Information</b></h4> 
							</tr>
							<tr >
								<h4><b>Joining Details</b></h4>
							</tr>
							<tr>
								<th width="20%">Date Of Appointment:</th>
								<th width="30%" style="text-align:center"></th>
								<th>Employee ID:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th width="20%">Date Of Joining In Deptt.:</th>
								<th width="30%" style="text-align:center"></th>
								<th>Initial Designation:</th>
								<th style="text-align:center"></th>
							</tr>
							
							<tr>
								<th>Office Name At The Time Of Initial Joining In Deptt:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th>Mode Of Requirement:</th>
								<th style="text-align:center"></th>
								<th>Reporting To:</th>
								<th style="text-align:center"></th>
							</tr>
						</thead>
					</table>
					<table >
						<thead>
							<tr >
								<h4 class="table table-bordered table-striped table-hover"><b>Salary Details -(At The Time of Initial Joining) </b></h4> 
							</tr>
							<tr>
								<th width="20%">Basic Pay: Rs</th>
								<th width="60%" style="text-align:center"></th>
								<th>Date Of Retirement:</th>
								<th style="text-align:center"></th>
							</tr>
							<tr>
								<th>Deduction Type (SD):</th>
								<th style="text-align:center"></th>
								<th>GPF Number:</th>
								<th style="text-align:center"></th>
							</tr>
						</thead>
					</table>
					<table >
						<thead>
							<tr height="60px">
								<h4 class="table table-bordered table-striped table-hover"><b>Remarks:</b></h4> 
							</tr>
						</thead>
					</table>
					</form>
				</div>
			</div>
	
</div>

