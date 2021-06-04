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
                <div class="row"><span style="float: right;"><a href="/main.php">Home</a> &gt; <a href="#">고객센터</a> &gt; <a href="#">자주묻는 질문</a></span></div>
                <h2>자주묻는 질문</h2>
                <div class="row col-md-12"><br></div>
                <div id="faq_div" class="row col-md-12">
                    <ul id="faq_list">				
                        <li>
                            <h4><a href="#a1"><img src="/resources/images/icon_faq_q.png"> 회원가입은 어디서 하나요?</a></h4>
                            <p>
                                <img src="/resources/images/icon_faq_a.png"> 회원가입에 들어가세요<br>
                                <span style="text-align: right;display: block;"></span>
                            </p>
                        </li>	
                        <li>
                            <h4><a href="#a1"><img src="/resources/images/icon_faq_q.png"> 탈퇴 어떻게 하나요?</a></h4>
                            <p>
                                <img src="/resources/images/icon_faq_a.png"> 회원정보 > 정보수정 > 탈퇴 버튼을 클릭하시면 됩니다.<br>
                                <span style="text-align: right;display: block;"></span>
                            </p>
                        </li>
                        <li>
                            <h4><a href="#a1"><img src="/resources/images/icon_faq_q.png"> 회원가입을 꼭 해야하나요?</a></h4>
                            <p>
                                <img src="/resources/images/icon_faq_a.png"> 비회원은 게시글 작성, 도서구매 서비스를 이용할 수 없습니다. 회원가입하여 다양한 서비스를 이용하세요.
                                <br>
                                <span style="text-align: right;display: block;"></span>
                            </p>
                        </li>
                        <li>
                            <h4><a href="#a1"><img src="/resources/images/icon_faq_q.png"> 배송 소요일이 궁금합니다.</a></h4>
                            <p>
                                <img src="/resources/images/icon_faq_a.png"> 평균 1~3일 정도 소요됩니다.<br>
                                <span style="text-align: right;display: block;"></span>
                            </p>
                        </li>
                        <li>
                            <h4><a href="#a1"><img src="/resources/images/icon_faq_q.png"> 원하는 책이 없습니다.</a></h4>
                            <p>
                                <img src="/resources/images/icon_faq_a.png"> 고객센터 > 책 찾아주세요 | 원하시는 책을 작성해주세요. 빠른 시일에 입고하겠습니다.<br>
                                <span style="text-align: right;display: block;">
                                </span>
                            </p>
                        </li>
                        <li>
                            <h4><a href="#a1"><img src="/resources/images/icon_faq_q.png"> 비밀 게시판은 익명인가요?</a></h4>
                            <p>
                                <img src="/resources/images/icon_faq_a.png"> 익명으로 정보가 수집되며 게시글을 작성한 회원님의 정보를 누구도 알 수 없습니다.<br>
                                <span style="text-align: right;display: block;"></span>
                            </p>
                        </li>
                        <li>
                            <h4><a href="#a1"><img src="/resources/images/icon_faq_q.png"> 리뷰 게시판과 구매후기 게시판 차이점</a></h4>
                            <p>
                                <img src="/resources/images/icon_faq_a.png"> 리뷰는 책에 대한 리뷰를 작성, 구매후기는 상품평을 해주시면 됩니다.<br>
                                <span style="text-align: right;display: block;"></span>
                            </p>
                        </li>
                    </ul>
                </div>
                
                <div class="row col-md-12"><br></div>
                
                <div align="center" class="row col-md-12">
                    <ul class="pagination">                        
                        <li class="disabled">
                            <a href="#">Prev</a>
                        </li>                        
                        <li class="active">
                            <a href="#">1</a>
                        </li>
                        <li>
                            <a href="#">2</a>
                        </li>                        
                        <li class="disabled">
                            <a href="#">Next</a>
                        </li>                        
                    </ul>
                </div>
            </article>
        </div>
		
		<hr>
        <?php require_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
	</div>
    <script type="text/javascript">
        $(document).ready(function(){
            var faqList = $("#faq_list>li"); 
            faqList.attr("class", "fold"); 
            function unfoldFaq() {
                if ($(this).parent().parent("li").hasClass("unfold")) { //열려있으면
                    $(this).parent().parent("li").removeClass("unfold").addClass("fold"); //닫아주고
                } else { //닫혀있으면
                    faqList.attr("class", "fold"); //다른 리스트는 닫아주고
                    $(this).parent().parent("li").removeClass("fold").addClass("unfold"); //클릭한 리스트는 열어준다
                }
            }
            faqList.find(">h4>a").click(unfoldFaq);
        });
    </script>
</body>
</html>