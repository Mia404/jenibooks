<?php
    # 장바구니 내역 삭제
    session_start(); // 세션 처리 시작
    require_once($_SERVER['DOCUMENT_ROOT']."/incLib/dbconn.php");
    
    # 로그인 세션 확인
    if(!isset($_SESSION['USER_ID'])){
        echo "<script>alert('로그인이 필요합니다.');location.href='/login/login.php';</script>";
    }
    
    # 전달 파라미터 받기
    $chk = $_GET['chk'];  // 체크된 항목들이 배열형태로 넘어옴.
    
    # 배열 원소 개수 만큼 반복
    for($i = 0; $i<count($chk); $i++){
        $cart_no = $chk[$i];
        
        # 삭제처리
        $sql = "delete from jeni_cart_tb where CART_NO = $cart_no";
        if(!($conn->query($sql))){
            echo "장바구니 물품 삭제 오류가 발생하였습니다.";
            echo $conn->error;
            break;
        }
    }
    
    echo "<script>alert('장바구니 물품을 삭제하였습니다.');location.href='/users/cart.php';</script>";
?>