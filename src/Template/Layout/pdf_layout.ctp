<!DOCTYPE html>
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?= $this->fetch('title') ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<?php echo $this->Html->script('/assets/global/plugins/pace/pace.min.js'); ?>
<?php echo $this->Html->css('/assets/global/plugins/pace/themes/pace-theme-flash.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/font-awesome/css/font-awesome.min.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/simple-line-icons/simple-line-icons.min.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap/css/bootstrap.min.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/uniform/css/uniform.default.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>

<?php echo $this->Html->css('/assets/global/plugins/bootstrap-toastr/toastr.min.css'); ?>

<?php echo $this->Html->css('/assets/global/plugins/select2/select2.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-select/bootstrap-select.min.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/jquery-multi-select/css/multi-select.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/icheck/skins/all.css'); ?>

<!-- END GLOBAL MANDATORY STYLES -->
<?php echo $this->Html->css('/assets/global/plugins/clockface/css/clockface.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css'); ?>
<!-- BEGIN THEME STYLES -->
<?php echo $this->Html->css('/assets/global/css/components.css'); ?>
<?php echo $this->Html->css('/assets/global/css/plugins.css'); ?>
<?php echo $this->Html->css('/assets/admin/layout/css/layout.css'); ?>
<?php echo $this->Html->css('/assets/admin/layout/css/themes/default.css'); ?>
<?php echo $this->Html->css('/assets/admin/layout/css/custom.css'); ?>
<?php echo $this->Html->css('/assets/global/plugins/jquery-notific8/jquery.notific8.min.css'); ?>

<style media="print">
	.hide_at_print {
		display:none !important;
	}
</style>
<style>
	.error-message {
		color: red;
		font-style: inherit;
	}
</style>


<style>
.self-table > tbody > tr > td, .self-table > tr > td
{
	border-top:none !important;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
 
    vertical-align:middle !important;
}
option 
{
    border-top:1px solid #CACACA;
    padding:4px;
	cursor:pointer;
}
select 
{
	cursor:pointer;
}
.myshortlogo
{
	font: 15px "Open Sans",sans-serif;
	text-transform: uppercase !important;
	box-sizing:border-box;
}
.toast_success_notify{
	margin: 0px 0px 6px;
	border-radius: 3px;
	background-position: 15px center;
	background-repeat: no-repeat;
	box-shadow: 0px 0px 12px ;
	color: #FFF;
	opacity: 0.8;
	background-color: #42893D;
}
.tost_edit_notify{
	margin: 0px 0px 6px;
	border-radius: 3px;
	background-position: 15px center;
	background-repeat: no-repeat;
	box-shadow: 0px 0px 12px #999;
	color: #FFF;
	opacity: 0.8;
	background-color: #B0B343;	
}
.tost_delete_notify{
	margin: 0px 0px 6px;
	border-radius: 3px;
	background-position: 15px center;
	background-repeat: no-repeat;
	box-shadow: 0px 0px 12px #999;
	color: #FFF;
	opacity: 0.8;
	background-color: #D75C48;
}
</style>
<!-- END THEME STYLES -->
<!-- <link rel="shortcut icon" href="favicon.ico"/> -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-header-fixed page-quick-sidebar-open ">
	<?php echo $this->fetch('content'); ?>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-migrate.min.js'); ?>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<?php echo $this->Html->script('/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap/js/bootstrap.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.blockui.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.cokie.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/uniform/jquery.uniform.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/icheck/icheck.min.js'); ?>
<!-- END CORE PLUGINS -->
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/clockface/js/clockface.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-daterangepicker/moment.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-notific8/jquery.notific8.min.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/ui-notific8.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-toastr/toastr.min.js'); ?>

<?php echo $this->Html->script('/assets/global/plugins/select2/select2.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-select/bootstrap-select.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js'); ?>

<?php echo $this->Html->script('/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js'); ?>


<?php echo $this->Html->script('/assets/global/scripts/metronic.js'); ?>
<?php echo $this->Html->script('/assets/admin/layout/scripts/layout.js'); ?>
<?php echo $this->Html->script('/assets/admin/layout/scripts/quick-sidebar.js'); ?>
<?php echo $this->Html->script('/assets/admin/layout/scripts/demo.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/form-icheck.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.pulsate.min.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/table-managed.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/components-pickers.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery-validation/js/jquery.validate.min.js'); ?>

<?php echo $this->Html->script('/assets/global/plugins/jquery-validation/js/additional-methods.min.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/form-validation.js'); ?>
<?php echo $this->Html->script('/assets/admin/pages/scripts/ui-general.js'); ?>


<script>
jQuery(document).ready(function() {    
	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	QuickSidebar.init(); // init quick sidebar
	Demo.init(); // init demo features
	UINotific8.init();
	FormValidation.init();
	TableManaged.init();
	ComponentsPickers.init();
	UIGeneral.init();
	FormiCheck.init(); // init page demo
	ComponentsDropdowns.init();
});
</script>
 
<script>
$("a[role='button']").live('click',function(e){
		e.preventDefault();
	});

$('a[role="button"]').live('click',function(e){
	e.preventDefault();
});

$('.firstupercase').die().live('blur',function(e){
	var str=$(this).val();
	var str2=touppercase(str);
	$(this).val(str2);
});

function touppercase(str){
	str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
		return letter.toUpperCase();
	});
	return str;
}
</script>         

 
</div>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>