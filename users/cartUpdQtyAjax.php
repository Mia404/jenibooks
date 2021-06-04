<?php
    # 장바구니 페이지 수량 증감 처리 
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT']."/incLib/dbconn.php");
    
    $isErr = 1; // 에러가 있으면 1, 에러 없으면 0
    $msg = "";  // 메시지
    
    # 로그인 여부 확인
    if(isset($_SESSION['USER_ID'])){
        # 전달된 파라미터 가져오기
        $user_id = $_SESSION['USER_ID']; // 사용자 ID (이메일)
        $book_price = $_GET['bkprice'];  // 책 가격(한 권)
        $sel = $_GET['sel'];             // 수량 증감 버튼 ('up' or 'down')
        
        # update 파라미터 
        $upd_price;                      // 수정할 장바구니 가격
        $cart_no = $_GET['cart_no'];     // 장바구니 번호
        $qty = $_GET['currQty'];         // 현재 수량

        // 수량 처리
        if($sel == "up") $qty++;
        else if($sel == "down") $qty--;
        // 가격처리
        $upd_price = $qty * $book_price; // 가격 = 수량 * 책 한권 값
            
        # SQL 실행
        $sql = "update jeni_cart_tb set QTY = $qty, PRICE = $upd_price where CART_NO = $cart_no AND USER_ID = '$user_id'";
        // 업데이트가 성공적으로 됐을 경우
        if($conn->query($sql)){
            $isErr = 0;
            
        // SQL 처리 에러가 났을 경우
        }else{
            $isErr = 1;
            $msg = "수량 변경에 실패했습니다.".$conn->error;
        }
        # 로그인하지 않은 경우
    }else{
        $isErr = 1;
        $msg = "로그인을 하신 다음 이용하실 수 있습니다.";
    }
    
    // json 객체 전달
    $json = json_encode(array('isErr'=>$isErr, 'msg'=>$msg));
    echo($json);
?>