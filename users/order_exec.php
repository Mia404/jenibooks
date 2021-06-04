<?php
    # 장바구니 리스트 전체 주문 처리
    session_start(); // 세션 처리 시작
    require_once($_SERVER['DOCUMENT_ROOT']."/incLib/lib.php");
    
    // 트랜잭션 처리를 위해 오토커밋 해제
    $conn->autocommit(false);
    
    # 1) order 테이블에 추가하기 : 주문번호 만들기
    $order_no = date("Y").date("m").date("d")."-%"; # ex) 20210527-001

    # 조건에 like를 사용해 오늘 날짜에서 MAX 값에 해당하는 주문번호가 있는지 확인
    $sql = "select max(ORDER_NO) as MAX_NO from jeni_order_tb where ORDER_NO LIKE '$order_no'";
    $result = $conn->query($sql);
    if(isset($result) && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        $max_no = $row['MAX_NO']; // 오늘날짜에 등록된 MAX값에 해당하는 주문번호
        
        // NULL인 경우 그날의 첫번째 주문
        if(is_null($max_no)){
            $order_no = date("Y").date("m").date("d")."-001";
        }else{
            $no = substr($max_no, 9, 3); // ex) 20210527-001라면 001 항목을 가져옴
            $no++;
            $order_no = substr($order_no, 0, 9).sprintf("%03d", $no); // 숫자를 문자로 변환. 포맷을 지정
        }
    }else{
        $conn->error;
        $conn->rollback(); // 트랜잭션 실행을 취소 : nothing
        exit();
    }

    // 주문 테이블에 등록될 값
    $user_id = $_SESSION['USER_ID']; // 사용자 ID
    $order_amount = 0;  // 주문 합계 
    $orderState = 0;    // 주문 상태 0접수 중, 1배송 중, 2배송 완료
    
    // 사용자 테이블에 업데이트될 포인트 값
    $user_point = 0;  // 사용자 포인트
    
    // 주문 테이블 등록
    $sql = "insert into jeni_order_tb(ORDER_NO, USER_ID, BUY_DATE, ORDER_AMOUNT, ORDER_STATE) values('$order_no', '$user_id', NOW(), $order_amount, $orderState)";
    if($conn->query($sql)){
        
        // 사용자 장바구니 내역 조회
        $sql = "select a.CART_NO, a.USER_ID, a.BOOK_NO, a.QTY, a.PRICE, b.BOOK_POINT
                  from jeni_cart_tb a, jeni_books_tb b 
                 where a.USER_ID = '$user_id'
                   and a.book_no = b.book_no";
        $result = $conn->query($sql);
        if(isset($result) && $result->num_rows > 0){
            $order_detail_no = 1;   // 주문상세테이블 : 주문상세번호 ex) 1번 주문의 1, 2, 3, ... 2번 주문의 1, 2, 3, ... 
            
            // 조회된 장바구니 목록 반복 처리 
            while($row = $result->fetch_assoc()){
                
                // 주문 상세 테이블에 등록될 값
                $book_no = $row['BOOK_NO'];       // 책 번호
                $book_price = $row['PRICE'];      // 가격
                $book_point = $row['BOOK_POINT']; // 포인트 (구매 당시 책 포인트)
                $qty = $row['QTY'];               // 수량
                
                // 주문 테이블 : 주문 총 금액 계산 (아래 update문에서 사용하여 처리)
                $order_amount += $book_price;      
                
                // 사용자 테이블 : 사용자에게 추가될 포인트 계산
                $user_point += $book_point;
                
                // 주문 상세 테이블 등록
                $sql = "insert into jeni_order_detail_tb values('$order_no', $order_detail_no, $book_no, $book_price, $book_point, $qty)";
                if($conn->query($sql)){
                    $order_detail_no++; // 다음 아이템 번호
                }else{
                    echo $conn->error;
                    $conn->rollback(); // 트랜잭션 실행을 취소 : nothing
                    exit();
                }
            }
            
            # 3) cart 테이블 데이터 삭제하기(장바구니 내역 삭제)
            $sql = "delete from jeni_cart_tb 
                     where USER_ID = '$user_id'";
            if(!($conn->query($sql))){
                $conn->rollback(); // 트랜잭션 실행을 취소 : nothing
                exit($conn->error);
            }
            
            # 4) order 테이블의 amount 수정하기 (주문 총 금액)
            $sql = "update jeni_order_tb 
                       set ORDER_AMOUNT = $order_amount 
                     where ORDER_NO = '$order_no'";
            if(!($conn->query($sql))){
                $conn->rollback(); // 트랜잭션 실행을 취소 : nothing
                exit($conn->error);
            }
            
            # 5) 사용자 테이블의 포인트 수정하기 (사용자 포인트)
            $sql = "update jeni_users_tb
                       set USER_POINT = USER_POINT + $user_point
                     where USER_ID = '$user_id'";
            if(!($conn->query($sql))){
                $conn->rollback(); // 트랜잭션 실행을 취소 : nothing
                exit($conn->error);
            }
        }
    }else{
        echo $conn->error;
        $conn->rollback(); // 트랜잭션 실행을 취소 : nothing
        exit();
    }
    
    // 커밋이 제대로 안됐다면
    if(!$conn->commit()){
        $conn->rollback(); // 트랜잭션 실행을 취소 : nothing
        exit($conn->error);
    }
    $conn->autocommit(true);
    echo "<script>alert('주문하였습니다.');location.href='/users/orderList.php';</script>";
?>