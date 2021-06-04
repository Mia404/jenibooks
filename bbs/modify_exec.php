<?php
    # 게시판 글 수정 처리    

    # 로그인 사용자 체크 및 사용자 권한 확인 필요

    session_start();
    
    # DB 연결하기
    require_once($_SERVER['DOCUMENT_ROOT']."/incLib/dbconn.php");
    
    # 전달받은 데이터 가져오기
    $user_id     = $_SESSION['USER_ID'];// 세션 사용자 ID
    $pageNum     = isset($_POST['pageNum']) ? $pageNum = $_POST['pageNum'] : 1; // 현재 페이지 번호
    $bbs_no      = $_POST['bbsNo'];     // 게시판 글 번호
    $bbs_type    = $_POST['bbsType'];   // 게시판 종류
    $bbs_title   = $_POST['title'];     // 게시글 제목
    $bbs_content = $_POST['contents'];  // 게시글 내용
    $ip_address  = get_client_ip();     // 사용자 IP
    
    # 게시글 수정 SQL
    $sql = "update jeni_bbs_tb 
               set BBS_TITLE = '$bbs_title', BBS_CONTENT = '$bbs_content', BBS_IP = '$ip_address', BBS_UPD_DATE = NOW() 
             where USER_ID = '{$user_id}' AND BBS_NO = {$bbs_no} AND BBS_TYPE = '{$bbs_type}'";    
    
    # SQL 실행
    if($conn->query($sql)){
        echo "<script>alert('게시글을 수정했습니다.');location.href='/bbs/view.php?bbsNo={$bbs_no}&bbsType={$bbs_type}&pageNum={$pageNum}';</script>";
    }else{
        echo "글 수정 중에 오류가 발생하였습니다.".$conn->error;
    }
?>