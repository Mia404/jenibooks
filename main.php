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
			
			<article class="col-md-10">
                <!-- 캐러셀 영역 -->
                <div id="myCarousel" class="carousel slide" data-ride="carousel">                    
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>
                    
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="/resources/images/banner-bg.jpg" alt="책 둘러보기" style="width:100%; height: 350px;">
                            <div class="carousel-caption">
                                <h3>다양한 도서 정보를 확인하고 구매하세요!</h3>
                                <p>책을 구매할 시 책에 대한 포인트가 지급됩니다!</p>
                                <p><a class="btn btn-lg btn-primary" href="/category/bookList.php?category=전체보기" role="button">책 둘러보기</a></p>
                            </div>                        
                        </div>
                        
                        <div class="item">
                            <img src="/resources/images/intro-bg.jpg" alt="이벤트 게시판" style="width:100%; height: 350px;">
                            <div class="carousel-caption">
                                <h3>지금 당장 이벤트를 확인하세요!</h3>
                                <p>추첨을 통해 상품을 드립니다!</p>
                                <p><a class="btn btn-lg btn-primary" href="/bbs/list.php?bbsType=EVENT" role="button">이벤트 게시판 이동</a></p>
                            </div>
                        </div>
                        
                        <div class="item">
                            <img src="/resources/images/book.jpg" alt="카페" style="width:100%; height: 350px;">
                            <div class="carousel-caption">
                                <h3>궁금한 점을 물어보세요.</h3>
                                <p>성실하게 답변해드리겠습니다!</p>
                                <p><a class="btn btn-lg btn-primary" href="/center.php" role="button">고객 센터 이동</a></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" role="button"data-slide="prev"> 
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> 
                        <span class="sr-only">Previous</span>
                    </a> 

                    <a class="right carousel-control" href="#myCarousel" role="button"data-slide="next"> 
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> 
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                
                <!-- 윗 라인 아래 라인 구분 -->
                <div class="row col-md-12"><br></div>                                
                
				<?php 
                    # 베스트 셀러
                    # 가장 많이 팔린 책 중에서 랜덤으로 DB jobScheduler를 통해 가져오는 처리가 추후에는 필요함.
                    # 현재는 직접 값을 HTML 엘리먼트에 설정함.
                ?>  
                <!-- 베스트 셀러 영역-->
                <div class="row col-md-5" >
                    <div class="row"><label class="main-books-label">베스트 셀러</label></div>
                    <div class="main-thumbnail">
                        <a href="/category/bookDetail.php?bookNum=726&category=경제/경영">
                            <img src="http://image.kyobobook.co.kr/images/cardnews/9788935213207_1.jpg" class="main-thumbnail-img">
                        </a>
                        <div class="main-thumbnail-caption">
                            <div class="wine-comemnt">
                                <a href="/category/bookDetail.php?bookNum=726&category=경제/경영">
                                    <label class="scrapIcon">보러가기  <img src="/resources/images/scrap.png" width="40px"height="30px"></label>
                                </a>
                            </div>
                        </div>			
                        <label class="icon" style="float: center"> 
                            <!--<img src="/resources/images/icon_time.JPG">-->잡스의 기준
                        </label>
                        <br>
                        비밀 규약에서 벗어나 최초로 밝히는 애플의 아이디어 창조론
                    </div>                    
                </div>
                
                <div class="row col-md-1"></div>
                
                <?php 
                    # 공지사항 조회 상위 5개
                    $sql = "SELECT a.BBS_NO, a.BBS_TYPE, a.USER_ID, a.BBS_TITLE, a.BBS_DATE, b.BBS_NAME_KR 
                              FROM jeni_bbs_tb a, jeni_bbs_list_tb b
                             WHERE A.BBS_TYPE = B.BBS_TYPE AND a.BBS_TYPE = 'NOTICE' order by BBS_NO desc LIMIT 5";
                    $result = $conn->query($sql);
                ?>
                <!-- 공지사항 -->
                <div class="row col-md-6">
                    <div class="row"><label class="main-books-label">공지사항</label></div>
                    <table class="table table-striped table-bordered table-hover" style="height: 285px; width: 100%;">
                        <tr height="10%;">
                            <th class="col-md-6">제목</th>
                            <th class="col-md-2" style="text-align: center;">날짜</th>
                        </tr>
                        <?php
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                echo "<tr><td><a href='/bbs/view.php?bbsNo={$row['BBS_NO']}&bbsType={$row['BBS_TYPE']}'>{$row['BBS_TITLE']}</a></td><td align='center'>{$row['BBS_DATE']}</td></tr>";
                            }
                        }else{
                            echo "<tr><td colspan='2' align='center'>조회된 데이터가 없습니다.</td></tr>";
                        }
                        ?>
                    </table>
                </div>      
                
                <!-- 윗 라인 아래 라인 구분 -->
                <div class="row col-md-12"><br></div>
                
                <?php 
                    # 오늘의 책
                    # 임의의 책 또는 가장 많이 팔린 책중에서 랜덤으로 DB jobScheduler를 통해 가져오는 처리가 추후에는 필요함.
                    # 현재는 직접 값을 HTML 엘리먼트에 설정함.
                ?>  
                <!-- 오늘의 책 영역-->
                <div class="row col-md-5" >
                    <div class="row"><label class="main-books-label">오늘의 책</label></div>
                    <div class="main-thumbnail">
                        <a href="/category/bookDetail.php?bookNum=727&category=자기계발">
                            <img src="http://image.kyobobook.co.kr/images/cardnews/4808960542587_1.jpg" class="main-thumbnail-img">
                        </a>
                        <div class="main-thumbnail-caption">
                            <div class="wine-comemnt">
                                <a href="/category/bookDetail.php?bookNum=727&category=자기계발">
                                    <label class="scrapIcon">보러가기  <img src="/resources/images/scrap.png" width="40px"height="30px" ></label>
                                </a>
                            </div>
                        </div>			
                        <label class="icon" style="float: center"> 
                            <!--<img src="/resources/images/icon_time.JPG">-->442시간 법칙
                        </label>
                        <br>
                        일론 머스크와 빌 게이츠에게 배우는 시간의 힘
                    </div>                    
                </div>
                
                <div class="row col-md-1"></div>
                
                <?php 
                    # 이벤트 조회 상위 5개
                    $sql = "SELECT a.BBS_NO, a.BBS_TYPE, a.USER_ID, a.BBS_TITLE, a.BBS_DATE, b.BBS_NAME_KR
                              FROM jeni_bbs_tb a, jeni_bbs_list_tb b
                             WHERE A.BBS_TYPE = B.BBS_TYPE AND a.BBS_TYPE = 'EVENT' order by BBS_NO desc LIMIT 5";
                    $result = $conn->query($sql);
                ?>
                <!-- 이벤트 -->
                <div class="row col-md-6">
                    <div class="row"><label class="main-books-label">이벤트</label></div>
                    <table class="table table-striped table-bordered table-hover" style="height: 285px; width: 100%;">
                        <tr height="10%;">
                            <th class="col-md-6">제목</th>
                            <th class="col-md-2" style="text-align: center;">날짜</th>
                        </tr>
                        <?php
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                echo "<tr><td><a href='/bbs/view.php?bbsNo={$row['BBS_NO']}&bbsType={$row['BBS_TYPE']}'>{$row['BBS_TITLE']}</a></td><td align='center'>{$row['BBS_DATE']}</td></tr>";
                            }
                        }else{
                            echo "<tr><td colspan='2' align='center'>조회된 데이터가 없습니다.</td></tr>";
                        }
                        ?>                        
                    </table>
                </div>                
			</article>
		</div>
		
		<hr>
        
		<?php require_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
	</div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.main-thumbnail').hover(                
                function(){
                    $(this).find('.main-thumbnail-caption').slideDown(250);
                },
                function(){
                    $(this).find('.main-thumbnail-caption').slideUp(250);
                }
            );	
        });
    </script>
</body>
</html>