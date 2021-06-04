<?php
    # 게시판 글 쓰기 처리    

    # 로그인 사용자 체크 및 사용자 권한 확인 필요

    session_start();
    
    # DB 연결하기
    require_once($_SERVER['DOCUMENT_ROOT']."/incLib/dbconn.php");
    
    # 전달받은 데이터 가져오기
    $user_id     = $_SESSION['USER_ID'];// 세션 사용자 ID
    $bbs_type    = $_POST['bbsType'];   // 게시판 종류
    $bbs_name    = $_POST['bbsName'];   // 게시판 이름
    $bbs_title   = $_POST['title'];     // 게시글 제목
    $bbs_content = $_POST['contents'];  // 게시글 내용
    $ip_address  = get_client_ip();     // 사용자 IP
    
    # 게시글 등록 SQL
    $sql = "insert into jeni_bbs_tb(BBS_TYPE, USER_ID, BBS_TITLE, BBS_CONTENT, BBS_DATE, BBS_SEE_CNT, BBS_IP) 
            values('$bbs_type', '$user_id', '$bbs_title', '$bbs_content', NOW(), 0, '$ip_address')";
    
    # SQL 실행
    if($conn->query($sql)){
        echo "<script>alert('게시글을 등록했습니다.');location.href='/bbs/list.php?bbsType={$bbs_type}';</script>";
    }else{
        echo "글 등록 중에 오류가 발생하였습니다.".$conn->error;
    }
?>