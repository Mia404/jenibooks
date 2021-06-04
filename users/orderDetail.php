<!DOCTYPE html>
<html>
<head>
	<title>[제니북스] "좋은 책 고르는 방법"</title>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/incLib/lib.php"); ?>
</head>
<body>	
    <div id="wrap" class="container">
    	<?php require_once($_SERVER['DOCUMENT_ROOT']."/header.php"); ?>
		
        <!-- 컨테이너 영역 -->
		<div class="container" style="position: relative;">
			<?php require_once($_SERVER['DOCUMENT_ROOT']."/aside.php"); ?>
            
            <?php 
                # 주문 상세 페이지
                
                # 로그인 세션정보 확인
                if(!isset($_SESSION['USER_ID'])){
                    echo "<script>alert('로그인이 필요합니다.');location.href='/login/login.php';</script>";
                }
                
                # 전달 파라미터 받기
                $email  = $_GET['email'];
                $order_no = $_GET['orderno'];
                
                $totPrice = 0; // 금액합계
                
                # 로그인한 사용자의 정보와 맞지 않는 경우
                if($email != $_SESSION['USER_ID'])
                    echo "<script>alert('사용자 정보가 틀립니다.\n메인 페이지로 이동합니다.');location.href='/main.php';</script>";
                
                # 주문 상세 정보 조회
                $sql = "SELECT a.ORDER_NO, a.ORDER_DETAIL_NO, a.BOOK_PRICE, a.BOOK_POINT, a.QTY,
                               b.BOOK_NO, b.BOOK_NAME, b.BOOK_AUTHOR, b.BOOK_PUBLISHER, b.BOOK_IMAGE, b.BOOK_CATEGORY
					      FROM jeni_order_detail_tb a, jeni_books_tb b
				 	     WHERE ORDER_NO = '$order_no'
                           AND a.BOOK_NO = b.BOOK_NO";
                
                $result = $conn->query($sql);
                
                # SQL에 문제가 발생한 경우
                if(!isset($result)) die("주문내역 검색 오류 : ".$conn->error);
            ?>
            <article class="col-md-10">
                <div class="row"><span style="float: right;"><a href="/main.php">Home</a> &gt; <a href="/users/userInfo.php">회원정보</a> &gt; <a href="/users/orderList.php">주문 내역</a> &gt; <a href="/users/orderDetail.php?email=<?= $email ?>&orderno=<?= $order_no ?>">주문 상세 내역</a></span></div>
                <h2 align="center">주문 상세 내역</h2><br><br><br>
                <table class="table">
                    <thead>
                        <tr>
                            <td><!-- 책이미지 --></td>
                            <td align="center"><strong>주문번호</strong></td>
                            <td align="center"><strong>책이름</strong></td>
                            <td align="center"><strong>출판사</strong></td>
                            <td align="center"><strong>주문가격</strong></td>
                            <td align="center"><strong>주문수량</strong></td>
                        </tr>
                    </thead>
				<?php   while($row = $result->fetch_assoc()){
        				    $title = (strlen($row["BOOK_NAME"]) > 10) ? str_replace($row["BOOK_NAME"], mb_substr($row["BOOK_NAME"], 0, 10,"utf-8")."...", $row["BOOK_NAME"]) : $row['BOOK_NAME'];
        				    $publisher = (strlen($row["BOOK_PUBLISHER"]) > 10) ? str_replace($row["BOOK_PUBLISHER"], mb_substr($row["BOOK_PUBLISHER"], 0, 10,"utf-8")."...", $row["BOOK_PUBLISHER"]) : $row['BOOK_PUBLISHER'];
				?>
                    <tr>
                        <td><img src="<?= $row['BOOK_IMAGE'] ?>" width="90px" height="90px" onerror="javascript:this.src='/resources/images/book_image_not_found.png'" title="<?= $row['BOOK_NAME'] ?>"></td>
                        <td align="center"><?= $row['ORDER_NO'] ?></td>
                        <td align="center"><a href="/category/bookDetail.php?bookNum=<?= $row['BOOK_NO'] ?>&category=<?= $row['BOOK_CATEGORY'] ?>" title="<?= $row['BOOK_NAME'] ?>"><?= $title ?></a></td>
                        <td align="center" title="<?= $row['BOOK_PUBLISHER'] ?>"><?= $publisher ?></td>
                        <td align="center"><?= $row['BOOK_PRICE'] ?>원</td>
                        <td align="center"><?= $row['QTY'] ?>개</td>
                    </tr>
				<?php   
				            $totPrice += $row['BOOK_PRICE']; // 주문 금액 합계
				        } 
                ?>
                </table>
                <p align="right">
                    <input type="button" class="btn btn-primary" value="주문 내역으로 돌아가기" onclick="location.href='/users/orderList.php';">
                </p>
                <h2 align="right">주문 금액 합계: <?= $totPrice ?>원</h2>
			</article>
        </div>
		
		<hr>
        <?php require_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
	</div>
</body>
</html>