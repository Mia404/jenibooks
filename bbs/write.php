<!DOCTYPE html>
<html>
<head>
	<title>[제니북스] "좋은 책 고르는 방법"</title>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/incLib/lib.php"); ?>
    <script type="text/javascript" src="/editor/ckeditor/ckeditor.js"></script>
</head>
<body>	
    <div id="wrap" class="container">
    	<?php require_once($_SERVER['DOCUMENT_ROOT']."/header.php"); ?>
		
		<?php 
            # 게시판 등록 화면
            
            # 사용자 체크 및 사용자 권한 확인 필요(게시판을 등록할 수 있는 사용자인지)
            
            
            # 전달 파라미터 설정
            $bbs_type = $_GET['bbsType'];
            $user_id = $_SESSION['USER_ID']; // 사용자 ID (이메일)
            
            # 게시판 종류 조회
            $sql = "select BBS_TYPE, BBS_NAME_KR FROM JENI_BBS_LIST_TB WHERE BBS_TYPE = '$bbs_type'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            
            # 조회 파라미터 설정
            $bbs_type = $row['BBS_TYPE'];
            $bbs_name_kr = $row['BBS_NAME_KR'];
            
		?>
        <!-- 컨테이너 영역 -->
		<div class="container" style="position: relative;">
			<?php require_once($_SERVER['DOCUMENT_ROOT']."/aside.php"); ?>
						
			<article class="col-md-10">
                <div class="row"><span style="float: right;"><a href="/main.php">Home</a> &gt; <a href="/bbs/list.php?bbsType=<?= $bbs_type ?>"><?= $bbs_name_kr ?></a> &gt; <a href="#">글 쓰기</a></span></div>
                <h3><?= $bbs_name_kr ?></h3>
                
                <div class="row"> 
                    <form action="/bbs/write_exec.php" method="post" id="writeForm">
                        <table class="table">
                            <tr>
                                <td>작성자</td>
                                <td><input class="form-control" type="text" maxlength="47" value="<?= $user_id ?>" readonly="readonly"></td>
                            </tr>
                            <tr>
                                <td>제목</td>
                                <td><input class="form-control" type="text" placeholder="제목" id="title" name="title" maxlength="47"></td>
                            </tr>
                            <tr>
                                <td>내용</td>	
                                <td><textarea id="contents" name="contents"></textarea></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right">
                                	<input class="btn btn-secondary" type="button" value="취소" onclick="javascript:history.back();">
                                	<input class="btn btn-primary" type="button" value="등록" id="writeBtn">
								</td>
                            </tr>
                        </table>
                        <input type="hidden" name="bbsType" value="<?= $bbs_type ?>">
                        <input type="hidden" name="bbsName" value="<?= $bbs_name_kr ?>">
                    </form>
                </div>
			</article>
        </div>
		
		<hr>
        <?php require_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
	</div>
    <script type="text/javascript">
		// 에디터 생성
    	CKEDITOR.replace("contents");
    	
        $(document).ready(function(){
            $("#writeBtn").on("click", function(){
				if($("#title").val() == ""){
					alert("제목을 입력하세요.");
                    return false;            		
				}
                
                // submit 처리 시 입력되어있는지 체크
                if (!CKEDITOR.instances.contents.getData()) {
                    alert("내용을 입력하세요.");
                    return false;
                }
        		
                // 에디터에 입력된 값을 실제 textarea에 넣어줌
                CKEDITOR.instances.contents.updateElement();

                // submit 처리
                $("#writeForm").submit();
            });
        });
    </script>
</body>
</html>