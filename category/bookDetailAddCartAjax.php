<?php
    // header("Content-Type: application/json");
    
    # 도서상세 페이지에서 장바구니 담기 버튼 눌렀을 때 처리
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT']."/incLib/dbconn.php");

    $isErr = 1; // 에러가 있으면 1, 에러 없으면 0
    $msg = "";  // 메시지
    // echo "alert(".isset($_SESSION['USER_ID']).")";
    # 로그인 여부 확인   
    if(isset($_SESSION['USER_ID'])){
        $user_id = $_SESSION['USER_ID']; // 사용자 ID (이메일)
        $book_no = $_GET['bookNo'];      // 도서 번호
        $qty     = 1;                    // 수량 1개로 고정 (장바구니에서 수량 변경)
        $price   = $_GET['bookPrice'];   // 가격
        
        $sql = "insert into jeni_cart_tb(USER_ID, BOOK_NO, QTY, PRICE) values('$user_id', $book_no, 1, $price)";
        // 장바구니에 성공적으로 담았을 경우
        if($conn->query($sql)){
            $isErr = 0;
            
            // SQL 처리 에러가 났을 경우
        }else{
            $isErr = 1;
            $msg = "장바구니 담기에 실패했습니다.".$conn->error;
        }
    # 로그인하지 않은 경우
    }else{
        $isErr = 1;
        $msg = "로그인을 한 다음 도서를 장바구니에 담을 수 있습니다.";
    }
    
    // json 객체 전달
    $json = json_encode(array('isErr'=>$isErr, 'msg'=>$msg));
    echo($json);
?>