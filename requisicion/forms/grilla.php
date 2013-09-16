<?php
$count = 100;
$clumn = 100;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Logs del Sistenas</title>
<link rel="stylesheet" type="text/css" media="screen" href="../css/jquery-ui-1.8.12.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../css/ui.jqgrid.css" />
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
}
</style>
</head>
<body>
  <input id="item" type="hidden" value="<?php echo $_GET['item']; ?>" />
  <input id="ext"  type="hidden" value="<?php echo $_GET['ext']; ?>" />
  <input id="nom"  type="hidden" value="<?php echo $_GET['nom']; ?>" />
<div align="center" id="tablaest">
<table align="center" id="crud">
</table>
<div id="pcrud"></div><br />
</div>
<script src="../scripts/library/jquery-1.5.2.min.js" type="text/javascript"></script>
<script src="../scripts/library/grid.locale-sp.js" type="text/javascript"></script>
<script src="../scripts/library/jquery.jqGrid.src2.js" type="text/javascript"></script>
<script src="../scripts/library/grid.addons.js" type="text/javascript"></script>
<script src="../scripts/library/jquery.searchFilter.js" type="text/javascript"></script>
<script src="../scripts/js/tools.crud.js" type="text/javascript"></script>
<script  type="text/javascript">
jQuery(document).ready(function(){
	table_jqgrid(document.getElementById("item").value,document.getElementById("ext").value,document.getElementById("nom").value);
});
</script
></body>
</html>