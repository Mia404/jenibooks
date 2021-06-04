<?php	
	# 로그아웃 처리
	session_start();
	session_destroy();
	
	echo "<script>alert('로그아웃 했습니다.');location.href = '/main.php';</script>";
?>