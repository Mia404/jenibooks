<?php
    # 게시판 목록 페이징 구현
    
    # 전달된 데이터 받기
    $condition = isset($_GET['condition']) ? $_GET['condition'] : "";   // 검색조건 
    $keyword   = isset($_GET['keyword']) ? $_GET['keyword'] : "";       // 검색 텍스트 박스
    $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;          // 현재 페이지 번호
    
    $searchSQL = "";
    # 검색 키워드가 존재할 경우 쿼리 조건 추가    
    if($keyword != "" && $condition == "title") $searchSQL = " AND a.BBS_TITLE   LIKE '%{$keyword}%' ";    // 셀렉트 박스 값이 제목인 경우
    if($keyword != "" && $condition == "content") $searchSQL = " AND a.BBS_CONTENT LIKE '%{$keyword}%' ";  // 셀렉트 박스 값이 내용인 경우
    
    // 게시물 총 개수 가져오기
    $sql = "select a.BBS_NO, a.BBS_TYPE, a.USER_ID, a.BBS_TITLE, a.BBS_CONTENT, a.BBS_DATE, a.BBS_SEE_CNT, a.BBS_IP, b.BBS_NAME_KR 
              from jeni_bbs_tb a, jeni_bbs_list_tb b
             where a.BBS_TYPE = b.BBS_TYPE AND a.BBS_TYPE = '$bbs_type'".$searchSQL;
    
    $data = mysqli_query($conn, $sql);   // mysqli의 연결된 객체를 통해 mysql 쿼리를 실행시키는 함수, $conn은 dbconn.php의 DB 연결된 객체
    $totRowCnt = mysqli_num_rows($data); // 불러올 게시물 총 개수
    
    $listCnt = 10; // 페이지에서 보여질 게시물 개수
    $blockCnt = 5; // 한 블록당 보여질 페이지 번호 개수 (5개씩 보이도록 1~5, 6~10, 11~15, ...)
    
    $block_num = ceil($pageNum / $blockCnt);               // 현재 페이지 블록
    $startPageNum = (($block_num - 1) * $blockCnt) + 1;    // 블록의 시작 번호
    $endPageNum = $startPageNum + $blockCnt - 1;           // 블록의 마지막 번호
    
    $totPageCount = ceil($totRowCnt / $listCnt); // 페이지 개수 구하기(페이징한 페이지 수)
    
    // 끝페이지 번호 처리
    // (마지막 페이지 > 전체 페이지 개수)
    if($endPageNum > $totPageCount){
        $endPageNum = $totPageCount; // 블록 마지막 번호가 총 페이지 수보다 크면 마지막 페이지 번호를 총 페이지 수로 지정함
    }
    
    $total_block = ceil($totPageCount / $blockCnt); // 블록의 총 개수
    $page_start  = ($pageNum - 1) * $listCnt; // 페이지의 시작 (SQL문에서 LIMIT 조건 걸 때 사용)

    // 페이지에 표시할 게시물 목록 가져오기
    $pagingResult = mysqli_query($conn, "select a.BBS_NO, a.BBS_TYPE, a.USER_ID, a.BBS_TITLE, a.BBS_CONTENT, a.BBS_DATE, a.BBS_SEE_CNT, a.BBS_IP, b.BBS_NAME_KR 
                                           from jeni_bbs_tb a, jeni_bbs_list_tb b
                                          where a.BBS_TYPE = b.BBS_TYPE AND a.BBS_TYPE = '$bbs_type'".$searchSQL.
                                          "order by a.BBS_NO desc LIMIT $page_start, $listCnt"); // $page_start를 시작으로 $list의 수만큼 보여주도록 가져옴
    $pagingResultCnt = mysqli_num_rows($pagingResult); // 현재 페이지의 게시물 개수   
?>