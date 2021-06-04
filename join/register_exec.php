<?php
    # @@ 회원가입 데이터 유효성 검증, 뒤로가기 막기 처리 필요    
    
    # register_exec.php (회원가입 처리)

    # DB 연결하기
    require_once($_SERVER['DOCUMENT_ROOT']."/incLib/dbconn.php");
    
    # 전달받은 데이터 가져오기    
    $email1 = $_POST['email1'];         // 이메일 계정
    $email2 = $_POST['email2'];         // 이메일 주소
    
    $pwd = $_POST['pwd'];                // 비밀번호
    $pwdConfirm = $_POST['pwdConfirm'];  // 비밀번호 확인
   
    $post1 = $_POST['post1'];   // 우편번호
    $post2 = $_POST['post2'];   // 주소
    
    $phone1 = $_POST['phone1']; // 핸드폰 앞자리
    $phone2 = $_POST['phone2']; // 핸드폰 중간자리
    $phone3 = $_POST['phone3']; // 핸드폰 뒷자리
        
    # DB INSERT PARAM SETTING
    $user_id = $email1."@".$email2;
    $user_password = $pwd;
    $address = $post1."!@".$post2;
    $phone = $phone1."-".$phone2."-".$phone3;
    $userPoint  = 0; // 회원 포인트
    $userSatate = 0; // 0회원, 1탈퇴회원
    
    # 회원등록 쿼리
    $sql = "insert into jeni_users_tb values('$user_id', '$user_password', '$address', '$phone', $userPoint, $userSatate, NOW())";
    
    # SQL 실행
    if($conn->query($sql)){        
		echo "<script>alert('회원 등록되었습니다.');location.href='/main.php';</script>";
    }else{
        echo "회원가입 중에 오류가 발생하였습니다.".$conn->error;
    }
?>