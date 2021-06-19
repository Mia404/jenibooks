<?php
    # 회원 정보 수정 처리

    # DB 연결
    require_once($_SERVER['DOCUMENT_ROOT']."/incLib/dbconn.php");
    
    # 회원정보수정 페이지 데이터 가져오기
    $user_id = $_POST['email'];     // 아이디(이메일)
    $pwd = $_POST['pwd'];          // 비밀번호
    $pwdConfirm = $_POST['pwdConfirm'];   // 비밀번호 확인
    $post1 = $_POST['post1'];       // 우편번호 
    $post2 = $_POST['post2'];       // 주소
    
    $phone1 = $_POST['phone1']; // 핸드폰 앞자리
    $phone2 = $_POST['phone2']; // 핸드폰 중간자리
    $phone3 = $_POST['phone3']; // 핸드폰 뒷자리
    
    # DB INSERT PARAM SETTING
    $user_password = $pwd;
    $address = $post1."!@".$post2;
    $phone = $phone1."-".$phone2."-".$phone3;
    $userPoint  = 0; // 회원 포인트
    $userSatate = 0; // 0회원, 1탈퇴회원
    
    # SQL 작성 (현재 로그인된 사용자의 회원정보 수정)
    $sql = "update jeni_users_tb 
               set USER_PASSWORD = '$user_password',
                   ADDRESS = '$address',
                   PHONE = '$phone'
             where USER_ID = '$user_id'";
    
    # SQL 실행
    if($conn->query($sql)){
        echo "<script>alert('{$user_id}님의 회원정보가 변경되었습니다.');location.href='/main.php';</script>";
    }else{
        echo "회원정보변경 중에 오류가 발생하였습니다.".$conn->error;
    }
?>