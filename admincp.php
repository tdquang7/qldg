<html>
<head>
	<title>Admin control panel</title>
</head>

<body>
	<div id="control panel">
		<a href="admincp/action=majorman">Quản lí các ngành học </a> <br/>
		<a href="admincp/action=userman">Quản lí người dùng</a> <br/>		
		<a href="admincp/action=import">Import danh sách sinh viên</a> <br/>
		<a href="admincp/action=statistics">Thống kê</a> <br/>
	</div>
	<div id="MainContent">
	<?php
		$choice = "statistics";
		if (isset($_REQUEST["action"]))
		{
			$choice = $_REQUEST["action"];
		}		
		include_once($choice . ".php");
	?>
	</div>
</body>
</html>