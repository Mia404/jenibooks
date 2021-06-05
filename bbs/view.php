<!DOCTYPE html>
<html>
<head>
	<title>[제니북스] "좋은 책 고르는 방법"</title>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/incLib/lib.php"); ?>
	<style>
        #preContent{
            all: unset;
        }
	</style>
</head>
<body>	
    <div id="wrap" class="container">
    	<?php require_once($_SERVER['DOCUMENT_ROOT']."/header.php"); ?>
		
        <!-- 컨테이너 영역 -->
		<div class="container" style="position: relative;">
			<?php require_once($_SERVER['DOCUMENT_ROOT']."/aside.php"); ?>
			
			<?php 
                # 게시판 상세화면
                
                # 전달 파라미터 받기
                $bbs_no = $_GET['bbsNo'];       // 게시글 번호
                $bbs_type = $_GET['bbsType'];   // 게시판 종류
                $pageNum = isset($_GET['pageNum']) ? $pageNum = $_GET['pageNum'] : 1; // 현재 페이지 번호
                
                # 게시판 종류 조회
                $sql = "select BBS_TYPE, BBS_NAME_KR FROM JENI_BBS_LIST_TB WHERE BBS_TYPE = '$bbs_type'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                
                $bbs_name = $row['BBS_NAME_KR']; 

                # 조회 수 증가
                $sql = "update jeni_bbs_tb SET BBS_SEE_CNT = BBS_SEE_CNT + 1
                         where BBS_TYPE = '$bbs_type' AND BBS_NO = '$bbs_no'";
                if(!$conn->query($sql)){
                    die("게시글 상세조회 오류".$conn->error);
                }
                
                # 글 조회
                $sql = "select BBS_NO, BBS_TYPE, USER_ID, BBS_TITLE, BBS_CONTENT, BBS_DATE, BBS_SEE_CNT, BBS_IP 
                          from jeni_bbs_tb where BBS_TYPE = '$bbs_type' AND BBS_NO = '$bbs_no'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
			?>
            <article class="col-md-10">
                <div class="row"><span style="float: right;"><a href="/main.php">Home</a> &gt; <a href="/bbs/list.php?bbsType=<?= $bbs_type ?>"><?= $bbs_name ?></a></span></div>
                <div>
                    <h2><?= $bbs_name ?></h2>
                    <form method="post" id="viewForm">
                        <table class="table">
                            <tr>
                                <th width="10%;">제목</th>
                                <td width="90%;"><input type="text" readonly="readonly" value="<?= $row['BBS_TITLE'] ?>" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" size="100%"></td>
                            </tr>
                            <tr>
                                <th width="10%;">날짜</th>
                                <td width="90%;"><input  type="text" readonly="readonly" value="<?= $row['BBS_DATE'] ?>" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" size="100%"></td>
                            </tr>
                            <tr>
                                <th width="10%;">이름</th>
                                <td width="90%;"><input  type="text" readonly="readonly" value="<?= $row['USER_ID'] ?>" style="border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" size="100%"></td>
                            </tr>
                            <tr>
                                <th width="10%;">내용</th>
                                <td width="90%;"><pre id="preContent"><?= $row['BBS_CONTENT'] ?></pre></td>
                            </tr>
                        </table>
                        <hr>
                        <div style="float:left;"><a class="btn btn-primary" style="text-decoration: none" href="/bbs/list.php?bbsType=<?= $bbs_type ?>&pageNum=<?= $pageNum ?>">목록으로 이동</a></div>
                        <?php
                            # 수정,삭제 버튼 활성화(글작성ID와 세션사용자ID가 같은경우)
                            if(isset($_SESSION['USER_ID'])){
                                if($_SESSION['USER_ID'] == $row['USER_ID']){
                        ?>
                                    <div style="float:right;"">
                						<input type="button" class="btn btn-default" value="수정" id="updBtn">
                						<input type="button" class="btn btn-default" value="삭제" id="delBtn">
                                    </div>
                        <?php   
                                }
                            }
                        ?>
                        <input type="hidden" value="<?= $row['BBS_NO'] ?>" name="bbsNo">
                        <input type="hidden" value="<?= $row['BBS_TYPE'] ?>" name="bbsType">
                        <input type="hidden" value="<?= $pageNum ?>" name="pageNum">
                    </form>
                </div>
            </article>
		</div>
		
        <hr>
        <?php require_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
	</div>
	<script>
		$(document).ready(function(){
			/* 삭제버튼 클릭 시 */
			$("#delBtn").on("click", function(){
				var isCon = confirm("게시글을 삭제하면 복구가 안됩니다.\n게시글 삭제하시겠습니까?");
	            if(isCon == true){
					$("#viewForm").attr("action", "/bbs/delete.php").submit();
	            }
			});

			/* 수정버튼 클릭 시 */
			$("#updBtn").on("click", function(){
				$("#viewForm").attr("action", "/bbs/modify.php").submit();
			});
		});
	</script>
</body>
</html>