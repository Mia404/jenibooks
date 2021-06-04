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
                # 장바구니 목록 페이지
                
                # 로그인이 안된 경우   
                if(!isset($_SESSION['USER_ID'])){
                    echo "<script>alert('로그인이 필요합니다.');location.href = '/login/login.php';</script>";
                }
                
                $totPrice = 0; // 금액합계
            
                # 현재 사용자 장바구니 내역 조회
                $user_id = $_SESSION['USER_ID'];
                
                // -- SUM(a.PRICE) OVER() as TOT_PRICE,
                $sql = "SELECT a.CART_NO, a.USER_ID, a.BOOK_NO, a.QTY, a.PRICE,  
                               b.BOOK_NAME, b.BOOK_IMAGE, b.BOOK_CATEGORY, b.BOOK_AUTHOR, b.BOOK_PUBLISHER, b.BOOK_CATEGORY, b.BOOK_PRICE
                          FROM JENI_CART_TB a, JENI_BOOKS_TB b 
                         WHERE a.USER_ID = '$user_id'
                           AND a.BOOK_NO = b.BOOK_NO 
                         ORDER BY CART_NO";
                
                $result = $conn->query($sql);
                
                # SQL에 문제가 발생한 경우
                if(!isset($result)){
                    die("장바구니 검색 오류 : ".$conn->error);
                }
            ?>
            <article class="col-md-10">
                <div class="row"><span style="float: right;"><a href="/main.php">Home</a> &gt; <a href="/users/userInfo.php">회원정보</a> &gt; <a href="/users/cart.php">장바구니</a></span></div>
                <h2 align="center">장바구니</h2><br><br><br>
                <form action="/users/cartDelete.php" method="get" id="cartForm">
                    <table class="table">
                        <thead>
                            <tr>
                            	<td align="center"><input type="checkbox" id="chkAll"/></td>	
                                <td align="center"><strong>책 이미지</strong></td>
                                <td align="center"><strong>책번호</strong></td>
                                <td align="center"><strong>책이름</strong></td>
                                <td align="center"><strong>작가</strong></td>
                                <td align="center"><strong>출판사</strong></td>
                                <td align="center"><strong>가격</strong></td>
                                <td align="center"><strong>수량</strong></td>
                            </tr>
                        </thead>
			<?php if($result->num_rows > 0){
			         while($row = $result->fetch_assoc()){
			             $title = (strlen($row["BOOK_NAME"]) > 10) ? str_replace($row["BOOK_NAME"], mb_substr($row["BOOK_NAME"], 0, 10,"utf-8")."...", $row["BOOK_NAME"]) : $row['BOOK_NAME'];
			             $author = (strlen($row["BOOK_AUTHOR"]) > 10) ? str_replace($row["BOOK_AUTHOR"], mb_substr($row["BOOK_AUTHOR"], 0, 10,"utf-8")."...", $row["BOOK_AUTHOR"]) : $row['BOOK_AUTHOR'];
			             $publisher = (strlen($row["BOOK_PUBLISHER"]) > 10) ? str_replace($row["BOOK_PUBLISHER"], mb_substr($row["BOOK_PUBLISHER"], 0, 10,"utf-8")."...", $row["BOOK_PUBLISHER"]) : $row['BOOK_PUBLISHER'];
			             $totPrice += $row['PRICE']; // 각 장바구니에 담긴 금액의 총합을 계산
            ?>
                        <tr>
                        	<td align="center"><input type="checkbox" name="chk[]" value="<?= $row['CART_NO'] ?>"></td>
                            <td><a href="/category/bookDetail.php?bookNum=<?= $row['BOOK_NO'] ?>&category=<?= $row['BOOK_CATEGORY'] ?>" title="<?= $row['BOOK_NAME']; ?>"><img src="<?= $row['BOOK_IMAGE'] ?>" width="90px" height="90px" onerror="javascript:this.src='/resources/images/book_image_not_found.png'" title="<?= $row['BOOK_NAME']; ?>"></a></td>
                            <td align="center"><?= $row['BOOK_NO'] ?></td>
                            <td align="center"><a href="/category/bookDetail.php?bookNum=<?= $row['BOOK_NO'] ?>&category=<?= $row['BOOK_CATEGORY'] ?>" title="<?= $row['BOOK_NAME']; ?>"><?= $title ?></a></td>
                            <td align="center" title="<?= $row['BOOK_AUTHOR']; ?>"><?= $author ?></td>
                            <td align="center" title="<?= $row['BOOK_PUBLISHER']; ?>"><?= $publisher ?></td>
                            <td align="center"><?= $row['PRICE'] ?>원</td>
                            <td align="center">&nbsp;&nbsp;                            
                                <input type="button" value="▲" onclick="editQty('up', <?= $row['CART_NO'] ?>, <?= $row['QTY'] ?>, <?= $row['BOOK_PRICE'] ?>, <?= $totPrice ?>);">
                                <?= $row['QTY'] ?>
                                <input type="button" value="▼" onclick="editQty('down', <?= $row['CART_NO'] ?>, <?= $row['QTY'] ?>, <?= $row['BOOK_PRICE'] ?>, <?= $totPrice ?>);">
                            </td>
                        </tr>
			<?php    
			         }  
                }else{
                    echo "<tr><td colspan='8' align='center'><strong>장바구니가 비었습니다.</strong></td></tr>";
                }
			?>
                    </table>
                    <p align="right">
                    	<input type="button" class="btn btn-danger" value="삭제"  id="delBtn">
                        <input type="button" class="btn btn-info" value="주문하기" id="orderBtn">
                    </p>
                </form>
                <h2 align="right">금액 합계: <?= $totPrice ?>원</h2>
                <input type="hidden" id="totPrice" value=<?= $totPrice ?>>
			</article>
        </div>
		
		<hr>
        <?php require_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
	</div>
    <script type="text/javascript">
    	/* 수량변경 버튼 클릭 시  */
        function editQty(sel, cart_no, currQty, bkprice, totprice){
        	if(sel == "down"){
            	if(currQty <= 1){
                	alert("수량은 1 이하로 내릴 수 없습니다.");
                	return;
            	}
        	}

        	// AJAX를 사용하여 데이터 처리
    		$.ajax({
                url: "/users/cartUpdQtyAjax.php",
                type: "get",
                data: {
                	cart_no : cart_no,   // 카트번호
                	currQty : currQty,	 // 현재 수량
                	sel : sel,			 // up or down (수량증감선택)
                	bkprice : bkprice	 // 책 가격
				}        			
            }).done(function(data) {
	            // 응답결과 받아오기 (JSON객체 받아오기)
	            var result = JSON.parse(data);
	            
	            // 에러가 발생한 경우	
	            if(result.isErr){
	            	alert(result.msg);
				// 변경된 경우
	            }else{
					location.href = '/users/cart.php';		            
	            }
            });
    	};
    	
    	$(document).ready(function(){
    		/* 삭제버튼 클릭 시  */
        	$("#delBtn").on("click", function(){
            	// 하나도 체크가 안된 상태이면
        		if($("input[name='chk[]']").is(":checked") == false){
        		    alert("삭제할 항목을 선택해 주세요.");
        		}else{
        			var isCon = confirm("삭제하시겠습니까?");
		            if(isCon == true){
            			$("#cartForm").submit();
		            }
        		}
        	});
        	
        	/* 전체선택 체크박스 클릭 시  */
        	$("#chkAll").on("click", function(){
    			// 체크된 경우
    			if($("#chkAll").prop("checked")) {
    				$("input[name='chk[]']").prop("checked",true);
    			// 체크 해제된 경우
    			} else {
    				$("input[name='chk[]']").prop("checked",false);
    			}
        	});
        		
        	/* 주문하기 버튼 클릭 시 */ 
    		$("#orderBtn").on("click", function(){
        		// 장바구니 목록이 있는지 확인
    			if($("#totPrice").val() == 0){
        			alert("장바구니에 담긴 도서가 없습니다.");
        			return;
    			}
        		
    			var isCon = confirm("주문 하시겠습니까?");
                if(isCon == true){
                    document.location.href = "/users/order_exec.php";
                }
			});
		});
			
    </script>
</body>
</html>