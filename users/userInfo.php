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
                # 회원정보 데이터 가져오기			     
                
    			# 로그인처리가 안된 경우 로그인 페이지 이동
    			if(!isset($_SESSION['USER_ID'])){
    			    echo "<script>alert('로그인이 필요합니다.');location.href = '/login/login.php';</script>";
    			}
    			
			    # 세션에서 사용자아이디를 가져와 정보 조회 
			    $user_id = $_SESSION['USER_ID'];
				$sql     = "select USER_ID, USER_PASSWORD, ADDRESS, PHONE, USER_POINT, USER_STATE, REG_DATE from jeni_users_tb where USER_ID = '$user_id'"; // 로그인된 사용자의 유저정보 가져오기
				$result  = $conn->query($sql);
				
				# 조회했는데 회원 정보가 없을 경우
				if($result->num_rows == 0) die("검색된 회원정보가 없습니다.".$conn->error);
				
				# 검색된 회원 레코드를 가져오기
				$row = $result->fetch_assoc(); 
				
				
				# 조회 데이터 처리
				
				// 주소
				$post1 = explode("!@", $row['ADDRESS'])[0]; // 우편번호
				$post2 = explode("!@", $row['ADDRESS'])[1]; // 주소
				
				// 핸드폰번호 ex) 010-1234-5678
				$phone1 = explode("-", $row['PHONE'])[0]; // 식별번호 ex) 010
				$phone2 = explode("-", $row['PHONE'])[1]; // 앞자리 ex) 1234
				$phone3 = explode("-", $row['PHONE'])[2]; // 뒷자리 ex) 5678
            ?>
			<article class="col-md-10">
                <div class="row"><span style="float: right;"><a href="/main.php">Home</a> &gt; <a href="#">회원정보</a> &gt; <a href="/users/userInfo.php">정보수정</a></span></div>
                <h2>회원 정보</h2>
                <br>
                <form action="/users/userInfoUpdProc.php" method="post" id="userInfoForm">
                    <table class="table col-md-12"> 
                        <tr>
                            <th style="width: 15%">이메일:</th> 
                            <td>
                                <span class="col-md-8" style="padding-right: 0px;">
                                    <input class="form-control" type="text" readonly="readonly" name="email" value="<?= $row['USER_ID'] ?>">
                                </span>
                            </td>
                        <tr>
                        <tr>
                            <th>비밀번호 :</th> 
                            <td>
                                <span class="col-md-8" style="padding-right: 0px;">
                                    <input class="form-control" maxlength="20" type="password" id="pwd" name="pwd" ><span id="pwdCheck1"></span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>비밀번호 확인 :</th> 
                            <td>
                                <span class="col-md-8" style="padding-right: 0px;">
                                    <input class="form-control" maxlength="20" type="password" id="pwdConfirm" name="pwdConfirm"><span id="pwdCheck2"></span>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>우편번호:</th>
                            <td>
                                <span class="col-md-5">
                                    <input class="form-control" id="postcode1" type="text" name="post1" readonly="readonly" value="<?= $post1 ?>">                                    
                                </span>
                                <input class="btn btn-primary" type="button" onclick="execDaumPostcode()" value="주소 찾기" id="postfind">
                                <div id="layer" style="display:none;z-index:999;border:5px solid blue;position:fixed;width:550px;height:460px;left:50%;margin-left:-155px;top:50%;margin-top:-235px;overflow:hidden;-webkit-overflow-scrolling:touch;">
									<img src="http://i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>주소:</th>
                            <td>
                                <span class="col-md-8" style="padding-right: 0px;">
                                    <input class="form-control" type="text" id="postcode2" name="post2" value="<?= $post2 ?>" readonly="readonly">
                                </span>
                                <span id="addressCheck"></span>
                                <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
                                <script type="text/javascript" src="/resources/js/regist.js"></script>
                            </td>
                        </tr>
                        <tr>
                            <th>전화번호:</th>
                            <td>
                                <span class="col-md-3">
                                    <select name="phone1" class="form-control">
                                        <option value="010" <?php if("010" == $phone1) echo "selected='selected'";?>>010</option>
                                        <option value="011" <?php if("011" == $phone1) echo "selected='selected'";?>>011</option>
                                        <option value="070" <?php if("070" == $phone1) echo "selected='selected'";?>>070</option>
                                    </select>
                                </span>
                                    <span class="input-group col-md-5">	
                                    <input class="form-control" id="phone2" type="text" name="phone2" value="<?= $phone2 ?>">
                                    <span class="input-group-addon">-</span>
                                    <input class="form-control" id="phone3" type="text" name="phone3" value="<?= $phone3 ?>">
                                </span>
                                <span id="phoneCheck"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>적립 포인트:</th>
                            <td>
                                <span class="col-md-8" style="padding-right: 0px;">
                                    <input class="form-control" type="text" readonly="readonly" value="<?= $row['USER_POINT'] ?>">
                                </span>	
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input class="btn btn-primary" type="button" value="수정" id="editBtn">
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <a class="btn btn-danger" href="#">탈퇴</a>
                            </td>
                        </tr>
                    </table>
                </form>
            </article>
        </div>
        <script>
			$(document).ready(function(){
				/* 수정버튼 클릭 시 */
				$("#editBtn").on("click", function(){
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
				
					if($("#phone2").val() == ""){
						alert("전화번호를 입력하세요.");
						return;
					}

					if($("#phone3").val() == ""){
						alert("전화번호를 입력하세요.");
						return;
					}
					
					var result = confirm("회원 정보를 수정하시겠습니까?"); 
					if(result) { 
						// 회원정보 수정 처리
						$("#userInfoForm").submit();
					}
				});
			});
        </script>
        <hr>
        <?php require_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
	</div>
</body>
</html>