<?php
    # 로그인처리
    session_start(); // 세션 처리 시작
    
    # DB 연결하기
    require_once($_SERVER['DOCUMENT_ROOT']."/incLib/dbconn.php");
    
    # 전달받은 데이터 가져오기
    $user_id = $_POST['email'];
    $user_password = $_POST['pwd'];
    
    # 회원 정보 조회 쿼리
    $sql = "select USER_ID, ADDRESS, PHONE, USER_POINT, USER_STATE, REG_DATE
              from jeni_users_tb 
             where user_id = '$user_id' 
               and user_password = '$user_password'";
    
    # SQL 실행
    $result = $conn->query($sql); // 검색된 레코드들의 배열 생성되어 리턴. cursor 포인터가 현재 레코드를 가리킴.
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        
        // 세션에 사용자 정보 저장
        $_SESSION['USER_ID'] = $row['USER_ID'];	      // 사용자 ID
        $_SESSION['USER_STATE'] = $row['USER_STATE']; // 사용자 상태 (0회원, 1탈퇴회원, 2관리자)  
        $_SESSION['USER_ACCOUNT'] = substr($_SESSION['USER_ID'], 0, (strpos($_SESSION['USER_ID'], "@"))); // 사용자 계정명
        
        // 로그인 체크박스가 체크되어있다면, 쿠키에 사용자 ID 저장
        if(isset($_POST['loginChkBox'])){
            // 한달 뒤에 만료될 쿠키값 설정하기, 하루 86400 * 30(한달 30일 기준)
            setcookie("JENI_USER_ID", $user_id, (time() + (86400 * 30)), "/");
        }else{
            setcookie("JENI_USER_ID", "", (time() + (86400 * 30)), "/");
        }
        
		echo "<script>alert('{$user_id}님 환영합니다.');location.href = '/main.php';</script>";
    }else{
        // 비밀번호가 틀릴 경우 alert 후 이동
        echo "<script>alert('이메일 또는 패스워드를 확인해주세요.');location.href='/login/login.php';</script>";       
    }
?>