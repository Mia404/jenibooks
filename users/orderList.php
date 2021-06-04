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
			
			<?php require_once($_SERVER['DOCUMENT_ROOT']."/users/orderListPaging.php"); ?>
            <article class="col-md-10">
                <div class="row"><span style="float: right;"><a href="/main.php">Home</a> &gt; <a href="/users/userInfo.php">회원정보</a> &gt; <a href="/users/orderList.php">주문 내역</a></span></div>
                <h1 align="center">주문 내역</h1>
                <div class="row">
                    <table class="table">
                        <tr>
                            <td align="center"><h4><strong>주문번호</strong></h4></td>
                            <td align="center"><h4><strong>주문금액</strong></h4></td>
                            <td align="center"><h4><strong>배송상태</strong></h4></td>
                            <td align="center"><h4><strong>주문날짜</strong></h4></td>
                        </tr>
				<?php 
                    while($row = $pagingResult->fetch_array()){
                        $state_text  = "배송준비중"; // 배송 상태 문구
                        $state_color = "#008000"; // 배송 상태 색상  
                        if($row['ORDER_STATE'] == 0){ $state_color = "#008000"; $state_text  = "배송준비중";}
                        if($row['ORDER_STATE'] == 1){ $state_color = "#4B0082"; $state_text  = "배송중";}    
                        if($row['ORDER_STATE'] == 2){ $state_color = "#000080"; $state_text  = "배송완료";}
                        if($row['ORDER_STATE'] == 3){ $state_color = "red";     $state_text  = "반품";}   
                ?>
                        <tr>
                            <td align="center"><a href="/users/orderDetail.php?email=<?= $row['USER_ID'] ?>&orderno=<?= $row['ORDER_NO'] ?>"><?= $row['ORDER_NO'] ?></a></td>
                            <td align="center"><?= $row['ORDER_AMOUNT'] ?>원</td>
                            <td align="center" style="color: <?= $state_color?>"><strong><?= $state_text ?></strong></td>
                            <td align="center" style="color: #330066"><?= $row['BUY_DATE'] ?></td>
                        </tr>
				<?php 
                	}
                ?>                        
                    </table>
                </div>
                
                <!-- ===================================================================== -->
                <!-- pagination 처리 시작 -->
                <div class="row">
                    <div align="center">
                        <ul class="pagination">                        
    						<?php
        						// "처음" 페이지 이동 버튼 처리 
                                if ($pageNum > 1){
                                    echo "<li><a href='/users/orderList.php?&pageNum=1'>처음</a></li>";
        						}
        						
                                // "이전" 페이지 버튼 처리
                                if($startPageNum > $blockCnt){ // (페이지블록 시작 번호 > 블록당 페이지 개수), ex) 시작번호가 6일 경우 5(블록당 페이지 개수)보다 크므로 이전 페이지 활성화
                                    $prevPageNum = $startPageNum - 1;
                                    echo "<li><a href='/users/orderList.php?&pageNum={$prevPageNum}'>이전</a></li>";
                                }else{
                                    echo "<li class='disabled'><a href='#'>이전</a></li>";
                                }
                                
                                // 페이지 번호 표시, 반복처리 
                                for($i=$startPageNum; $i<$endPageNum+1; $i++){
                                    // 현재 페이지의 경우 색 다르게 표시                                
                                    if($i == $pageNum){
                                        echo "<li class='active'><a href='/users/orderList.php?pageNum={$i}'>{$i}</a></li>";
                                    // 현재 페이지가 아닌 경우
                                    }else{
                                        echo "<li><a href='/users/orderList.php?pageNum={$i}'>{$i}</a></li>";
                               		}
                                } // for문 종료
                                
                                // "다음" 페이지 버튼 처리
                                if($endPageNum < $totPageCount){
                                    $nextPageNum = $endPageNum + 1;
                                    echo "<li><a href='/users/orderList.php?pageNum={$nextPageNum}'>다음</a></li>";
                                }else{
                                    echo "<li class='disabled'><a href='#'>다음</a></li>";
                                }
                                
                                // "마지막" 페이지 버튼 처리
                                if($pageNum < $totPageCount){
                                    echo "<li><a href='/users/orderList.php?pageNum=$totPageCount'>마지막</a></li>";
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <!-- pagination 처리 끝 -->
                <!-- ===================================================================== -->
            </article>
        </div>
		
		<hr>
        <?php require_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
	</div>
</body>
</html>