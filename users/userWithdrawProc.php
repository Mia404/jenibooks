<?php
    # 회원 탈퇴 처리
    
    # DB 연결
    require_once($_SERVER['DOCUMENT_ROOT']."/incLib/dbconn.php");
    
    # 회원정보수정 페이지 데이터 가져오기
    $user_id = $_POST['email'];     // 아이디(이메일)
    
    # SQL 작성 (탈퇴 처리)
    $sql = "UPDATE jeni_users_tb 
               SET USER_STATE = 1
             WHERE USER_ID = '$user_id'";
    
    # SQL 실행
    if($conn->query($sql)){        
        // 로그아웃 처리
        session_start();
        session_destroy();        
        echo "<script>alert('탈퇴 처리되었습니다.');location.href='/main.php';</script>";
    }else{
        echo "회원탈퇴 중에 오류가 발생하였습니다.".$conn->error;
    }
?>