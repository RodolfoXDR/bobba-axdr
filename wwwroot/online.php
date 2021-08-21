<?php 
	require '../KERNEL-XDRCMS/Init.php';
?>
<html>
<head>
<title><span class="reload_users"></span> Onlines</title>
</head>
<body>
<span class="reload_users"></span> Onlines

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
function getUsers() {
	$.get(<?php echo Site::GetOnlineCount(); ?>, function(data) {
		$('.reload_users').html(data); 
	});
	
	setTimeout(getUsers, 100000000); 
}

$(document).ready(function(){getUsers();});
</script>  

</body>
</html>