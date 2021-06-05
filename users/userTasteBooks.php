<!DOCTYPE html>
<html>
<head>
	<title>[제니북스] "좋은 책 고르는 방법"</title>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/incLib/lib.php"); ?>
</head>
<body>	
    <div id="wrap" class="container">
    	<?php require_once($_SERVER['DOCUMENT_ROOT']."/header.php"); ?>
		
		<?php
            # 추천 도서 페이지
            
    		# 로그인 세션정보 확인
    		if(!isset($_SESSION['USER_ID'])){
    		    echo "<script>alert('로그인이 필요합니다.');location.href='/login/login.php';</script>";
    		}
    		
    		
    		# 사용자가 주문한 데이터가 없을 경우
    		# 사용자들이 가장 많이 주문한 도서 정보 데이터를 가져온다.
    		
    		# 사용자 주문 데이터가 존재할 경우
    		# 가장 많이 주문한 카테고리에 한하여 관련 카테고리 내에 랜덤한 도서 정보 데이터를 가져온다.
    		
    		# 그 뒤 자바스크립트(springy)에서 사용되는 형식에 맞게 php 문자열을 만들어서, 아래 자바스크립트 노드 생성부에 적절하게 만들어 넣어준다.   
		?>
        <!-- 컨테이너 영역 -->
		<div class="container" style="position: relative;">
            <?php require_once($_SERVER['DOCUMENT_ROOT']."/aside.php"); ?>
            
            <article class="col-md-10">
                <div class="row"><span style="float: right;"><a href="/main.php">Home</a> &gt; <a href="/users/userInfo.php">회원정보</a> &gt; <a href="/users/userTasteBooks.php">추천도서</a></span></div>
                <h2 style="float: left;">김학성 회원님에게 권하는 도서 정보입니다.</h2>
                <br>
                <canvas id="springyCanvas" width="950" height="600" />
            </article>
		</div>
		
        <hr>
		<?php require_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?> 
	</div>    
    
    <script src="/resources/js/springy/springy.js"></script>
	<script src="/resources/js/springy/springyui.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var graph = new Springy.Graph();
                graph.addNodes('과학/공학', '공학', '김대식의 인간 vs 기계 ', '3일만에 읽는 로봇', '로봇 다빈치, 꿈을 설계하다');
            
            graph.addEdges([ '과학/공학', '공학', {
                               color : '#00A0B0',
                               label : '장르'                               
                           }], 
                           [ '공학', '과학/공학', {
                               color : '#6A4A3C',
                               label : '도서 카테고리'
                           }], 
                           [ '공학', '김대식의 인간 vs 기계 ', {
                               color : '#CC333F'
                           }], [ '공학', '로봇 다빈치, 꿈을 설계하다', {
                               color : '#EB6841'
                           }], [ '공학', '3일만에 읽는 로봇', {
                               color : '#EDC951'
                           }], ['로봇 다빈치, 꿈을 설계하다', '3일만에 읽는 로봇', {color : '#6A4A3C'} ]);

            var springy = jQuery('#springyCanvas').springy({
                graph : graph
            });
	
            
            jQuery('#springyCanvas').springy({ graph: graph, nodeSelected: function(node) {
                if(node.data.label == "공학" || node.data.label == "과학/공학"){
                    document.location.href="bookList.php";
                }else{
                    document.location.href="bookDetail.php";
                }                
            }});
        });
    </script>
</body>
</html>