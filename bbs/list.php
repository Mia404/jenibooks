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
                # 공통 게시판 목록 조회 화면
			
                $bbs_type = $_GET['bbsType'];
                
                # 게시판 종류 조회
                $sql = "select BBS_TYPE, BBS_NAME_KR FROM JENI_BBS_LIST_TB WHERE BBS_TYPE = '$bbs_type'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                
                $bbs_name = $row['BBS_NAME_KR'];
                
                require_once($_SERVER['DOCUMENT_ROOT']."/bbs/bbsListPaging.php"); 
            ?>	
            <article class="col-md-10">
                <div class="row"><span style="float: right;"><a href="/main.php">Home</a> &gt; <a href="/bbs/list.php?bbsType=<?= $bbs_type ?>"><?= $bbs_name ?></a> &gt; <a href="#">글 목록</a></span></div>
                <h2 style="float: left;"><?= $bbs_name ?></h2>
                <br>
                
                <?php 
                    # 글 작성 버튼 출력 여부, 사용자 상태값이 존재하는 경우
                    if(isset($_SESSION['USER_STATE'])){
                        # 사용자 권한이 관리자이고, 게시판 종류가 이벤트일 경우
                        if($_SESSION['USER_STATE'] == 2 && $row['BBS_TYPE'] == 'EVENT') echo "<div style='float: right;'><a class='btn btn-primary' href='/bbs/write.php?bbsType=<?= $bbs_type ?>' style='float: right;'>글 작성하기</a></div>";
                        # 사용자 권한이 관리자이고, 게시판 종류가 공지사항일 경우
                        if($_SESSION['USER_STATE'] == 2 && $row['BBS_TYPE'] == 'NOTICE') echo "<div style='float: right;'><a class='btn btn-primary' href='/bbs/write.php?bbsType=<?= $bbs_type ?>' style='float: right;'>글 작성하기</a></div>";
                        # 사용자 권한이 관리자 또는 회원이고, 게시판 종류가 자유게시판일 경우
                        if(($_SESSION['USER_STATE'] == 2 || $_SESSION['USER_STATE'] == 0) && $row['BBS_TYPE'] == 'FREE') echo "<div style='float: right;'><a class='btn btn-primary' href='/bbs/write.php?bbsType=<?= $bbs_type ?>' style='float: right;'>글 작성하기</a></div>";
                    }
                ?>
                <div align="center">
                    <table class="table col-md-10 table-striped table-hover" id="table">
                        <tr align="center">
                            <td class="menu" align="center"><strong>글 번호</strong></td>
                            <td class="menu" align="left"><strong>제목</strong></td>
                            <td class="menu"><strong>이름</strong></td>
                            <td class="menu"><strong>날짜</strong></td>
                            <td class="menu"><strong>조회 수</strong></td>
                        </tr>
				<?php 
				    if($pagingResult->num_rows > 0){
                        while($row = $pagingResult->fetch_array()){
                ?>                            
                        <tr align="center" class="list">
                            <td align="center" style="width: 10%"><?= $row['BBS_NO'] ?></td>
                            <td align="left" style="width: 50%"><a href="/bbs/view.php?bbsNo=<?= $row['BBS_NO'] ?>&bbsType=<?= $bbs_type ?>"><?= $row['BBS_TITLE'] ?></a></td>
                            <td style="width: 20%"><?= $row['USER_ID'] ?></td>
                            <td style="width: 10%"><?= $row['BBS_DATE'] ?></td>
                            <td style="width: 10%"><?= $row['BBS_SEE_CNT'] ?></td>
                        </tr>
				<?php 
                        }
				    }else{
				        $msg = "<strong>조회된 데이터가 없습니다.</strong>";
				        if(isset($_GET['keyword'])){
				            $msg = "<strong>'{$_GET['keyword']}'</strong>에 대한 검색결과가 없습니다.";
				        }
				        echo "<tr><td colspan='5' align='center'><h4>{$msg}</h4></td></tr>";
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
                                    echo "<li><a href='/bbs/list.php?bbsType={$bbs_type}&pageNum=1&condition={$condition}&keyword={$keyword}'>처음</a></li>";
        						}
        						
                                // "이전" 페이지 버튼 처리
                                if($startPageNum > $blockCnt){ // (페이지블록 시작 번호 > 블록당 페이지 개수), ex) 시작번호가 6일 경우 5(블록당 페이지 개수)보다 크므로 이전 페이지 활성화
                                    $prevPageNum = $startPageNum - 1;
                                    echo "<li><a href='/bbs/list.php?bbsType={$bbs_type}&pageNum={$prevPageNum}&condition={$condition}&keyword={$keyword}'>이전</a></li>";
                                }else{
                                    echo "<li class='disabled'><a href='#'>이전</a></li>";
                                }
                                
                                // 페이지 번호 표시, 반복처리 
                                for($i=$startPageNum; $i<$endPageNum+1; $i++){
                                    // 현재 페이지의 경우 색 다르게 표시                                
                                    if($i == $pageNum){
                                        echo "<li class='active'><a href='/bbs/list.php?bbsType={$bbs_type}&pageNum={$i}&condition={$condition}&keyword={$keyword}'>{$i}</a></li>";
                                    // 현재 페이지가 아닌 경우
                                    }else{
                                        echo "<li><a href='/bbs/list.php?bbsType={$bbs_type}&pageNum={$i}&condition={$condition}&keyword={$keyword}'>{$i}</a></li>";
                               		}
                                } // for문 종료
                                
                                // "다음" 페이지 버튼 처리
                                if($endPageNum < $totPageCount){
                                    $nextPageNum = $endPageNum + 1;
                                    echo "<li><a href='/bbs/list.php?bbsType={$bbs_type}&pageNum={$nextPageNum}&condition={$condition}&keyword={$keyword}'>다음</a></li>";
                                }else{
                                    echo "<li class='disabled'><a href='#'>다음</a></li>";
                                }
                                
                                // "마지막" 페이지 버튼 처리
                                if($pageNum < $totPageCount){
                                    echo "<li><a href='/bbs/list.php?bbsType={$bbs_type}&pageNum={$totPageCount}&condition={$condition}&keyword={$keyword}'>마지막</a></li>";
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <!-- pagination 처리 끝 -->
                <!-- ===================================================================== -->
                
                <!-- ===================================================================== -->
                <!-- 검색기능 시작 -->
                <hr>
                <form action="/bbs/list.php" method="get">
                    <div align="center">
                        <div align="center">
                            <div class="col-md-2">
                                <select name="condition" class="form-control">
                                    <option value="title" <?php if("title" == $condition) echo "selected='selected'";?>>제목</option>
                                    <option value="content" <?php if("content" == $condition) echo "selected='selected'";?>>내용</option>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <input class="form-control" type="text" name="keyword" id="keyword" value="<?= $keyword ?>" maxlength="30">
                            </div>
                            <div class="col-md-3">
                                <input class="btn btn-primary btn-block" type="submit" value="검색">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="<?= $bbs_type ?>" name="bbsType">
                </form>
                <!-- 검색기능 끝 -->
                <!-- ===================================================================== -->
            </article>            
		</div>
        <hr>
		<?php require_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
	</div>
</body>
</html>