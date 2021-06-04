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
                // 전달 파라미터 받기
                $book_no = $_GET['bookNum'];    // 도서번호
                $category = $_GET['category'];  // 카테고리
                
                // 도서 정보 조회
                $sql = "select BOOK_NO, BOOK_NAME, BOOK_AUTHOR, BOOK_PUBLISHER, BOOK_PRICE, BOOK_POINT,
                               BOOK_CATEGORY, BOOK_IMAGE, BOOK_DATE, BOOK_INTRODUCTION, BOOK_AUTHORINTRO
                          from jeni_books_tb
                         where BOOK_NO = $book_no";
                
                // 쿼리 실행
                $result = $conn->query($sql);
                if(!isset($result)) die("도서정보 조회 오류 : ".$conn->error);
                $row = $result->fetch_assoc();
			?>			
			<article class="col-md-10">
                <div class="row"><span style="float: right;"><a href="/main.php">Home</a> &gt; <a href="/category/bookList.php?category=전체보기">도서 카테고리</a> &gt; <a href="/category/bookList.php?category=<?= $category ?>"><?= $category ?></a></span></div>
                <div id="bookInfo" class="row">
                    <div class="row" style="position: relative;">
                        <div class="col-sm-2" align="center">
                            <img class="img-responsive" width="140px" height="185px" alt="<?= $row['BOOK_NAME'] ?>" src="<?= $row['BOOK_IMAGE'] ?>" onerror="javascript:this.src='/resources/images/book_image_not_found.png'">
                        </div>
                        
                        <div class="col-sm-6">
                            <p><strong>도서명:  <?= $row['BOOK_NAME'] ?></strong></p>
                            <p><strong>판매가:  <?= $row['BOOK_PRICE'] ?>원</strong>&nbsp;&nbsp;</p>
                            <p><strong>출간일:  <?= $row['BOOK_DATE'] ?></strong></p>
                            <p><strong>저자:   <?= $row['BOOK_AUTHOR'] ?></strong></p>
                            <p><strong>출판사:  <?= $row['BOOK_PUBLISHER'] ?></strong></p>
                            <p><strong>적립 포인트:  <?= $row['BOOK_POINT'] ?> P</strong></p>
                        </div>
                        <p align="right" style="  position: absolute; bottom: 0px; right: 15px;"><input type="button" class="btn btn-info" value="장바구니담기" id="addCartbtn"></p>
                    </div>
                    
                    <br>
                    
                    <div class="">
                        <h2>책 소개 :</h2>
                        <div class="jumbotron" >
                            <p class="lead"><?= $row['BOOK_INTRODUCTION'] ?></p>
                        </div>
                    </div>
                    
                    <br>
                    
                    <div class="">
                        <h2>저자 소개 :</h2>
                        <div class="jumbotron">
                            <p class="lead"><?= $row['BOOK_AUTHORINTRO'] ?></p>
                        </div>
                    </div>
                </div>
                
                <div align="right"></div>
                
                <br>
                
                <input type="hidden" name="bkNo" id="bkNo" value="<?= $row['BOOK_NO'] ?>">
                <input type="hidden" name="bkPrice" id="bkPrice" value="<?= $row['BOOK_PRICE'] ?>">
            </article>
        </div>
		
		<hr>
		<?php require_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
	</div>
    <script type="text/javascript">
        $(document).ready(function(){
            /* 장바구니 버튼 클릭 시 */
        	$("#addCartbtn").on("click", function(){
            	// AJAX를 사용하여 데이터 처리
        		$.ajax({
	                url: "/category/bookDetailAddCartAjax.php",
	                type: "get",
	                // data: $("#formId").serialize()
	                // datatype: "json" // 서버에서 반환되는 데이터 형식
	                data: {
	                	bookNo    : $("#bkNo").val(),
	                	bookPrice : $("#bkPrice").val()
					}        			
	            }).done(function(data) {
		            // 응답결과 받아오기 (JSON객체 받아오기)
		            var result = JSON.parse(data);
		            
		            // 에러가 발생한 경우	
		            if(result.isErr){
		            	alert(result.msg);
		            	
			         // 장바구니에 성공적으로 담았을 경우 
		            }else{
		            	var isCon = confirm("장바구니에 담았습니다.\n장바구니 페이지로 이동하시겠습니까?");
			            if(isCon == true){
			                document.location.href = "/users/cart.php";
			            }    
		            }
	            });
			});
        });
        
        var order = function(){
            var isCon = confirm("주문 했습니다.\n주문내역 페이지로 이동하시겠습니까?");
            if(isCon == true){
                document.location.href = "/users/orderList.php";
            }
        }
    </script>
</body>
</html>