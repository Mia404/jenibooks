<?php
    # 아이디 중복 검사
    require_once($_SERVER['DOCUMENT_ROOT']."/incLib/lib.php");    
    
    # 전달 파라미터 받기
    $user_id = $_GET["email"];
    
    # 아이디 조회
    $sql = "select * from jeni_users_tb where USER_ID = '$user_id'";
    $data = mysqli_query($conn, $sql);
    $member = $data->fetch_array();
    
    $chkId = false; // 중복여부
    # 신규 아이디
    if($member == 0){
        echo "<div><strong>{$user_id}</strong>는 사용 가능한 아이디입니다.</div>";
        $chkId = true;
    # 중복 아이디
	}else{
	   echo "<div><strong>{$user_id}</strong>는 이미 존재하는 아이디입니다.<br>다른 아이디로 만들어 중복여부를 확인해주세요.<div>";
	   $chkId = false;
	}
?>
<button class="btn" value="확인" onclick="setReadonly(<?= $chkId ?>);" >확인</button>
<script>
    function setReadonly(bChk){
    	var bChkId = bChk;
    	/* 신규 아이디이면 */
    	if(bChkId){
    		/* 부모창 엘리먼트 제어 */
        	opener.document.getElementById('email1').readOnly = bChkId;
        	opener.document.getElementById('email2').readOnly = bChkId;
        	opener.document.getElementById('domainAddr').disabled = bChkId;
        	opener.document.getElementById('mycheck').style.display = 'none';
    	}
		// 창 종료
    	window.close();
    }
</script>