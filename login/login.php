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
            # 쿠키에서 로그인정보 불러오기#
            $user_id = "";
            $loginChecked = "";
            // 쿠키 확인
            if (isset($_COOKIE['JENI_USER_ID'])){
                // 쿠키 데이터 확인
                if($_COOKIE['JENI_USER_ID'] == "") return;
                $user_id = $_COOKIE['JENI_USER_ID'];
                $loginChecked = "checked";
            }
            
            // 로그인 세션 데이터가 존재하면 Main page 이동 
            if(isset($_SESSION['USER_ID'])){
                header("/main.php");
            }
        ?>
        <!-- 컨테이너 영역 -->
		<div class="container" style="position: relative;">
			<?php require_once($_SERVER['DOCUMENT_ROOT']."/aside.php"); ?>
            
			<article class="col-md-10">                
				<div class="col-md-2"></div>
                <div class="col-md-6" >
                    <div class="" align="center">
                    	<form action="/login/login_exec.php" method="post" id="loginForm">
                            <h1>JENIBOOKS</h1>
                            <input class="form-control" type="text" id="email" name="email" value="<?= $user_id ?>" maxlength="25" placeholder="아이디">
                            <input class="form-control" type="password" id="pwd" name="pwd" value="" maxlength="21" placeholder="비밀번호"><br>
                            <div class="checkbox">
                                <label style="float: left;">
                                    <input type="checkbox" id="check" name="loginChkBox[]" <?= $loginChecked ?>>로그인 상태 유지
                                </label>	
                            </div>
                            <input class="btn btn-primary btn-block" type="button" value="로그인" id="loginbtn">
                        </form>
                    </div>
                </div>                
                <div class="col-md-2"></div>
            </article>
        </div>
		<!--로그인 폼 유효성 체크 부분-->
        <script>
			$(document).ready(function(){
				function login(){
					// 아이디 체크
					if($("#email").val() == ""){
						alert("아이디를 입력해주세요.");
						return;
					}
					// 비밀번호 체크
					if($("#pwd").val() == ""){
						alert("패스워드를 입력해주세요.");
						return;
					}
					// 로그인 처리
					$("#loginForm").submit();
				};
				
				/* 로그인 버튼 클릭 시 */
				$("#loginbtn").on("click", function(){
					login();
				});
				
				/* 로그인 엔터 처리 */
				$("#loginForm").keypress(function (e) {
			        if (e.keyCode === 13) {
			            login();
			        }
			    });
			});
        </script>
		<hr>        
        <?php require_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>        
	</div>
</body>
</html>