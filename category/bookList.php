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
			
			<?php require_once($_SERVER['DOCUMENT_ROOT']."/category/bookListPaging.php"); ?>
						
			<article class="col-md-10">
                <div class="row"><span style="float: right;"><a href="/main.php">Home</a> &gt; <a href="/category/bookList.php?category=전체보기">도서 카테고리</a> &gt; <a href="/category/bookList.php?category=<?= $category ?>"><?= $category ?></a></span></div>
				<h2 align="center"><?= $category ?></h2>
                
               	<!-- ===================================================================== -->
                <!-- 한 페이지에 보일 도서 리스트 시작 -->
                <table class="table-striped table-bordered table-hover" style="table-layout: fixed">
                <?php 
                    echo "<tr>";
                    $idx = 1; // 1라인에 4개씩 보이도록하기 위해  인덱스 확인 변수
                    if($pagingResult->num_rows > 0){
                        while($row = $pagingResult->fetch_array()){
                            $title = (strlen($row["BOOK_NAME"]) > 15) ? str_replace($row["BOOK_NAME"], mb_substr($row["BOOK_NAME"], 0, 15,"utf-8")."...", $row["BOOK_NAME"]) : $row['BOOK_NAME'];
                    ?>
                            <td style="width: 250px;">
                            	<p align="center">
                            		<a href="/category/bookDetail.php?bookNum=<?= $row['BOOK_NO'] ?>&category=<?= $category ?>" title="<?= $row['BOOK_NAME']; ?>">
                            			<img width="140px" height="185px" alt="<?= $row['BOOK_NAME']; ?>" src="<?= $row['BOOK_IMAGE']; ?>" onerror="javascript:this.src='/resources/images/book_image_not_found.png'" ondragstart="return false">
                            		</a>
                            	</p>
                            	<p align="center" ><a href="/category/bookDetail.php?bookNum=<?= $row['BOOK_NO'] ?>&category=<?= $category ?>" title="<?= $row['BOOK_NAME']; ?>"><strong style="white-space:nowrap;"><?= $title ?></strong></a></p>
                            	<p align="center">가격 : <?= $row['BOOK_PRICE']; ?>원</p>
                            </td>
                            
    				<?php 
    				        // 4개씩 나눠떨어지면 <tr> 닫고 새로 연다.
                            if(($idx % 4) == 0){
                                echo "</tr><tr>";
                            }
                            $idx++;
                        }
                    }else{
                        $msg = "<strong>조회된 데이터가 없습니다.</strong>";
                        if(isset($_GET['bookKeyword'])){
                            $msg = "<strong>'{$_GET['bookKeyword']}'</strong>에 대한 검색결과가 없습니다.";
                        }
                        echo "<td style='width:100%;' align='center'><br><br><h4>{$msg}</h4><br><br><br><td>";
                    }
                	echo "</tr>";
                ?>
                </table>
                <!-- 도서 리스트 끝 -->
                <!-- ===================================================================== -->                
                <br>
                <br>
                
                <!-- ===================================================================== -->
                <!-- pagination 처리 시작 -->
                <div align="center">
                    <ul class="pagination">                        
						<?php
    						// "처음" 페이지 이동 버튼 처리 
                            if ($pageNum > 1){
                                echo "<li><a href='/category/bookList.php?category={$category}&pageNum=1&bookCondition={$condition}&bookKeyword={$keyword}'>처음</a></li>";
    						}
    						
                            // "이전" 페이지 버튼 처리
                            if($startPageNum > $blockCnt){ // (페이지블록 시작 번호 > 블록당 페이지 개수), ex) 시작번호가 6일 경우 5(블록당 페이지 개수)보다 크므로 이전 페이지 활성화
                                $prevPageNum = $startPageNum - 1;
                                echo "<li><a href='/category/bookList.php?category={$category}&pageNum={$prevPageNum}&bookCondition={$condition}&bookKeyword={$keyword}'>이전</a></li>";
                            }else{
                                echo "<li class='disabled'><a href='#'>이전</a></li>";
                            }
                            
                            // 페이지 번호 표시, 반복처리 
                            for($i=$startPageNum; $i<$endPageNum+1; $i++){
                                // 현재 페이지의 경우 색 다르게 표시                                
                                if($i == $pageNum){
                                    echo "<li class='active'><a href='/category/bookList.php?category={$category}&pageNum={$i}&bookCondition={$condition}&bookKeyword={$keyword}'>{$i}</a></li>";
                                // 현재 페이지가 아닌 경우
                                }else{
                                    echo "<li><a href='/category/bookList.php?category={$category}&pageNum={$i}&bookCondition={$condition}&bookKeyword={$keyword}'>{$i}</a></li>";
                           		}
                            } // for문 종료
                            
                            // "다음" 페이지 버튼 처리
                            if($endPageNum < $totPageCount){
                                $nextPageNum = $endPageNum + 1;
                                echo "<li><a href='/category/bookList.php?category={$category}&pageNum={$nextPageNum}&bookCondition={$condition}&bookKeyword={$keyword}'>다음</a></li>";
                            }else{
                                echo "<li class='disabled'><a href='#'>다음</a></li>";
                            }
                            
                            // "마지막" 페이지 버튼 처리
                            if($pageNum < $totPageCount){
                                echo "<li><a href='/category/bookList.php?category={$category}&pageNum=$totPageCount&bookCondition={$condition}&bookKeyword={$keyword}'>마지막</a></li>";
                            }
                        ?>
                    </ul>
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