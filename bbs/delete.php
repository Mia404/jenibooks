<?php
    # 게시판 글 삭제 처리 (게시글 상세화면 => 글 삭제 버튼 클릭 시)
    
    session_start(); // 세션 처리 시작
    require_once($_SERVER['DOCUMENT_ROOT']."/incLib/dbconn.php");
    
    # 로그인 세션 확인
    if(!isset($_SESSION['USER_ID'])){
        echo "<script>alert('로그인이 필요합니다.');location.href='/login/login.php';</script>";
    }
    
    # 전달 파라미터 받기
    $bbs_type = $_POST['bbsType'];    // 게시판 종류
    $bbs_no = $_POST['bbsNo'];        // 게시글 번호
    $pageNum = isset($_POST['pageNum']) ? $pageNum = $_POST['pageNum'] : 1; // 현재 페이지 번호
    $user_id = $_SESSION['USER_ID']; // 사용자 ID 
    
    # 삭제처리
    $sql = "delete from jeni_bbs_tb where USER_ID = '$user_id' AND BBS_NO = $bbs_no AND BBS_TYPE = '$bbs_type'";
    if(!($conn->query($sql))){
        echo "게시글 삭제 오류가 발생하였습니다.";
        echo $conn->error;
    }
    
    echo "<script>alert('게시물이 삭제되었습니다.');location.href='/bbs/list.php?bbsType={$bbs_type}&pageNum={$pageNum}';</script>";
?>