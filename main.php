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
                            <img src="/resources/images/intro-bg.jpg" alt="리뷰 게시판" style="width:100%; height: 350px;">
                            <div class="carousel-caption">
                                <h3>책에 대한 리뷰를 작성해보세요!</h3>
                                <p>여러 사람들과 책에 대한 다양한 정보를 공유하세요!</p>
                                <p><a class="btn btn-lg btn-primary" href="/review.php" role="button">리뷰 게시판 이동</a></p>
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
                
                <!-- 베스트 셀러 영역-->
                <div class="row col-md-5" >
                    <div class="row"><label class="main-books-label">베스트 셀러</label></div>
                    <div class="main-thumbnail">
                        <a href="/bookDetail.php">
                            <img src="http://image.kyobobook.co.kr/images/cardnews/9788935213207_1.jpg" class="main-thumbnail-img">
                        </a>
                        <div class="main-thumbnail-caption">
                            <div class="wine-comemnt">
                                <a href="/bookDetail.php">
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
                
                <!-- 공지사항 -->
                <div class="row col-md-6">
                    <div class="row"><label class="main-books-label">공지사항</label></div>
                    <table class="table table-striped table-bordered table-hover" style="height: 285px; width: 100%;">
                        <tr>
                            <th class="col-md-6">제목</th>
                            <th class="col-md-2" style="text-align: center;">날짜</th>
                        </tr>
                        <tr>
                            <td><a href="#"> [제니북스] 모든 상품이 무료 배송!</a></td>                            
                            <td align="center">2020-06-03</td>
                        </tr>		
                        <tr>
                            <td><a href="#">[공지] 일부 도서 구매 및 다운로드 제한</a></td>                            
                            <td align="center">2020-06-03</td>
                        </tr>		
                        <tr>
                            <td><a href="#">[발표] 제 1회 북스토어 로맨스 소설 공모전</a></td>                            
                            <td align="center">2020-06-03</td>
                        </tr>		
                        <tr>
                            <td><a href="#">[안내] 컬쳐랜드 문화상품권 결제 제한</a></td>                            
                            <td align="center">2020-06-03</td>
                        </tr>		
                        <tr>
                            <td><a href="#">[제니북스] 6/4 배송 휴무 안내</a></td>                            
                            <td align="center">2020-06-03</td>
                        </tr>		
                    </table>
                </div>      
                
                <!-- 윗 라인 아래 라인 구분 -->
                <div class="row col-md-12"><br></div>
                   
                <!-- 오늘의 책 영역-->
                <div class="row col-md-5" >
                    <div class="row"><label class="main-books-label">오늘의 책</label></div>
                    <div class="main-thumbnail">
                        <a href="/bookDetail.php">
                            <img src="http://image.kyobobook.co.kr/images/cardnews/4808960542587_1.jpg" class="main-thumbnail-img">
                        </a>
                        <div class="main-thumbnail-caption">
                            <div class="wine-comemnt">
                                <a href="/bookDetail.php">
                                    <label class="scrapIcon">보러가기  <img src="/resources/images/scrap.png" width="40px"height="30px"></label>
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
                
                <!-- 이벤트 -->
                <div class="row col-md-6">
                    <div class="row"><label class="main-books-label">이벤트</label></div>
                    <table class="table table-striped table-bordered table-hover" style="height: 285px; width: 100%;">
                        <tr>
                            <th class="col-md-6">제목</th>
                            <th class="col-md-2" style="text-align: center;">날짜</th>
                        </tr>
                        <tr>
                            <td><a href="#">[OPEN] 시간 순삭, 꿀잼 보장! 밤도둑 대여점</a></td>                            
                            <td align="center">2020-06-03</td>
                        </tr>		
                        <tr>
                            <td><a href="#">[EVENT] 히가시노 게이고 "교통경찰의 밤" 출간!</a></td>                            
                            <td align="center">2020-06-03</td>
                        </tr>		
                        <tr>
                            <td><a href="#">[제니ONLY] "만년 꼴찌를 1% 명문대생으로 만든 기적의 독서법" 출간!</a></td>                            
                            <td align="center">2020-06-03</td>
                        </tr>		
                        <tr>
                            <td><a href="#">[37%▼] 와카타케 나나미 "하자키 시리즈" 특가 세트 기간 한정 판매!</a></td>                            
                            <td align="center">2020-06-03</td>
                        </tr>		
                        <tr>
                            <td><a href="#">[포인트백] 토마 피케티 "자본과 이데올로기" 출간!</a></td>                            
                            <td align="center">2020-06-03</td>
                        </tr>		
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