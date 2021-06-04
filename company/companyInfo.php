<!DOCTYPE html>
<html>
<head>
	<title>[제니북스] "좋은 책 고르는 방법"</title>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/incLib/lib.php"); ?>
    
    <style type="text/css">
        .sub_txt {
            font-size: 2rem;
            color: #333;
            line-height: 1.875em;
            margin-bottom: 30px;
        }
        .sub_txt .first_word {
            float: left;
            padding: 15px 10px 0 0;
            font-size: 2.26em;
            color: #111;
            font-weight: normal;
        }
        .sub_strapline {
            display: block;
            position: relative;
            margin-bottom: 3%;
            padding-bottom: 1%;
            font-size: 1.875em;
            color: #111;
            text-align: center;
            letter-spacing: -0.03em;            
            font-weight: normal;
        }
        .sub_strapline:after {
            display: block;
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 30px;
            height: 1px;
            margin-left: -15px;
            background: #111;
            content: '';
        }
    </style>
</head>
<body>	
    <div id="wrap" class="container">
		<?php require_once($_SERVER['DOCUMENT_ROOT']."/header.php"); ?>
		
        <!-- 컨테이너 영역 -->
		<div class="container" style="position: relative;">
            <section class="col-md-1"></section>
			
			<article class="col-md-10">
                <div class="row"><span style="float: right;"><a href="/main.php">Home</a> &gt; <a href="#">제니북스</a> &gt; <a href="/company/companyInfo.php">회사소개</a></span></div>
                <h2>회사 소개</h2>
                <div class="row col-md-12"><br></div>
                <div class="col-md-12" style="margin-bottom: 50px;"><img src="/resources/images/seoul_free.png"></div>
                <div class="col-md-12">
                    <h4 class="sub_strapline">회사개요</h4>
                    <p class="sub_txt">
                        <strong class="first_word">제니북스는</strong>
                         93만권 이상의 전자책 보유, 250만명의 회원 전자책 누적 다운로드 2억 1천만권 돌파 1등 전자책 서점, 제니북스는 변화를 넘어 삶의 혁신을 만듭니다. 제니북스는 MUST-USE 전자책을 만듭니다. “Redefining Books”
                    </p>
                    
                    <div class="row col-md-12"><!-- 지하철 정보 -->
                        <table class="table table-bordered">
                            <caption style="color: black;"><strong>제니북스 주소, 대표전화 정보</strong></caption>
                            <colgroup>
                                <col style="width:30%">
                                <col style="width:70%">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th class="info" scope="col">주소</th>
                                    <td scope="col">경기도 의정부시 신곡동</td>
                                </tr>                            
                                <tr>
                                    <th class="info">대표전화</th>
                                    <td>010-9015-7662</td>
                                </tr>
                            </tbody>
                        </table>
                        <a class="btn btn-primary" href="/company/companyLocation.php" style="float:right;">사업장안내</a>
                    </div>                    
                </div>
            </article>
            
            <section class="col-md-1"></section>
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