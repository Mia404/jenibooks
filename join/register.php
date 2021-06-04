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
            
            <!-- 회원 가입 영역 -->
			<article class="col-md-10">
				<form action="/join/register_exec.php" method="post" id="joinForm">
                    <FieldSet>
                        <legend style="text-align: center;"><strong>JENIBOOKS 회원가입</strong></legend>
                        <br>
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="email1" class="regiLabel">Email</label>
                            </div>
    
                            <div class="col-sm-6 input-group" style="display: inline-table; float:left;">
                                <input class="form-control" type="text" name="email1" id="email1" maxlength="20" placeholder="이메일 명">
                                <span class="input-group-addon">@</span>
                                <input type="text" id="email2" name="email2" class="form-control" placeholder="이메일 주소">
                            </div>
    
                            <div class="col-sm-2">                                        
                                <select id="domainAddr" name="domainAddr" onclick="mychange()"  class="form-control" >
                                    <option value="직접입력">직접입력</option>
                                    <option value="naver.com">naver.com</option>
                                    <option value="gmail.com">gmail.com</option>
                                    <option value="nate.com">nate.com</option>
                                    <option value="daum.com">daum.com</option>
                                </select>
                            </div>
                            
                            <div class="col-sm-2">
                                <input type="button" value="중복확인" id="mycheck"  class="btn btn-info" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="pwd" class="regiLabel">비밀번호</label>
                            </div>
    
                            <div class="col-sm-6" style="padding-left: 0px; padding-right: 0px;">
                                <input type="password" name="pwd" id="pwd" maxlength="20"  class="form-control" >
                                <span id="pwdCheck1"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="pwdConfirm" class="regiLabel">비밀번호 확인</label>
                            </div>
                            <div class="col-sm-6" style="padding-left: 0px; padding-right: 0px;">
                                <input type="password" name="pwdConfirm" id="pwdConfirm" maxlength="20"  class="form-control" >
                                <span id="pwdCheck2"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="pstcode1" class="regiLabel">주소</label>
                            </div>
    
                            <div class="col-sm-6" style="padding-left: 0px; padding-right: 0px;">
                                <input type="text" id="postcode1" readonly="readonly" name="post1"  class="form-control" placeholder="우편번호">                            
                            </div>     
                            
                            <div class="col-sm-2">
                                <input class="btn btn-primary" type="button" onclick="execDaumPostcode()" value="우편번호 찾기" id="postfind">
                            </div>
                            <span id="addressCheck"></span>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6" style="padding-left: 0px; padding-right: 0px;">
                                <input type="text" id="postcode2" placeholder="주소" name="post2" readonly="readonly" class="form-control" >
                                <div id="layer" style="display:none;border:5px solid blue;position:fixed;z-index:999; width:550px;height:460px;left:50%;margin-left:-155px;top:50%;margin-top:-235px;overflow:hidden;-webkit-overflow-scrolling:touch;">
                                    <img src="http://i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
                                </div>
                                <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
                                <script type="text/javascript" src="/resources/js/regist.js"></script>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="phone1" class="regiLabel">전화번호</label>
                            </div>                                
                            <div class="col-sm-2" style="padding-left: 0px;">
                                <select name="phone1" class="form-control">
                                    <option value="010">010</option>
                                    <option value="011">011</option>
                                    <option value="070">070</option>
                                </select>
                            </div>                                
                            <div class="input-group col-sm-3">
                                <input class="form-control" type="text" name="phone2" id="phone2" maxlength="4" size="5px">
                                <span class="input-group-addon">-</span>
                                <input class="form-control" type="text" name="phone3" id="phone3" maxlength="4" size="5px">
                            </div>                                
                            <span id="phoneCheck"></span>
                        </div>
    
                        <br><br><br><br>
                        <div class="row col-sm-3"></div>                    
                        <div class="row col-sm-6"><button class="btn btn-lg btn-primary btn-block" type="button" id="joinBtn">회원가입</button></div>                    
                        <div class="row col-sm-3"></div>
                    </FieldSet>
                </form>
			</article>
		</div>
		<script>
			$(document).ready(function(){
				/* 아이디 중복체크 확인 */
				$("#mycheck").on("click", function(){
					if($("#email1").val() == ""){
						alert("이메일을 입력하세요.");
						return;
					}
					if($("#email2").val() == ""){
						alert("이메일 주소를 입력하세요.");
						return;
					}
					var email = $("#email1").val() + "@" + $("#email2").val();
					var popupX = (document.body.offsetWidth / 2) - (500 / 2);
					var popupY= (window.screen.height / 2) - (200 / 2);
					window.open("/join/checkId.php?email="+email, "ID 중복체크", 'status=no, height=200, width=500, left='+ popupX + ', top='+ popupY);
				});
				
				/* 회원가입 버튼 클릭 시 */
				$("#joinBtn").on("click", function(){
					if($("#email1").val() == ""){
						alert("이메일을 입력하세요.");
						return;
					}
					if($("#email2").val() == ""){
						alert("이메일 주소를 입력하세요.");
						return;
					}
						
					if($("#mycheck").is(":visible")){
						alert("이메일 중복 여부를 확인해 주세요.");
						return;
					}
					
					if($("#pwd").val() == ""){
						alert("비밀번호를 입력하세요.");
						return;
					}					
					if($("#pwdConfirm").val() == ""){
						alert("비밀번호 확인 값을 입력하세요.");
						return;
					}
					if($("#pwdConfirm").val() != $("#pwd").val()){
						alert("비밀번호와 비밀번호 확인 값이 서로 다릅니다.");
						return;
					}

					if($("#postcode1").val() == ""){
						alert("우편번호가 입력되지 않았습니다.");
						return;
					}
					if($("#postcode2").val() == ""){
						alert("주소가 입력되지 않았습니다.");
						return;
					}
					
					if($("#phone2").val() == ""){
						alert("전화번호를 입력하세요.");
						return;
					}

					if($("#phone3").val() == ""){
						alert("전화번호를 입력하세요.");
						return;
					}
					
					$("#joinForm").submit();
				});
			});
        </script>
		<hr>
        <?php require_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>        
	</div>
</body>
</html>