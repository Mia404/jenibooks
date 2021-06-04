<?php
    # 도서 목록 페이징 구현
    
    # 전달된 데이터 받기
    $condition = isset($_GET['bookCondition']) ? $_GET['bookCondition'] : "";   // 검색조건
    $keyword   = isset($_GET['bookKeyword']) ? $_GET['bookKeyword'] : "";       // 검색 텍스트 박스
    $category = isset($_GET['category']) ? $_GET['category'] : "전체보기";        // 도서 카테고리, category 항목이 없을 경우 헤더에서 검색한 것으로 간주
    $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1; // 현재 페이지 번호
    
    $searchSQL = "";
    # 검색 키워드가 존재할 경우 쿼리 조건 추가
    if($keyword != "" && $condition == "bookName") $searchSQL = " AND BOOK_NAME   LIKE '%{$keyword}%' ";          // 셀렉트 박스 값이 제목인 경우
    if($keyword != "" && $condition == "bookAuthor") $searchSQL = " AND BOOK_AUTHOR   LIKE '%{$keyword}%' ";      // 셀렉트 박스 값이 저자인 경우
    if($keyword != "" && $condition == "bookPublisher") $searchSQL = " AND BOOK_PUBLISHER LIKE '%{$keyword}%' ";  // 셀렉트 박스 값이 출판사인 경우
    
    // 게시물 총 개수 가져오기
    $sql  = "";
    if($category == "전체보기"){ // 카테고리가 전체보기일 경우
        $sql = "select BOOK_NO, BOOK_NAME, BOOK_AUTHOR, BOOK_PUBLISHER, BOOK_PRICE, BOOK_POINT, 
                       BOOK_CATEGORY, BOOK_IMAGE, BOOK_DATE, BOOK_INTRODUCTION, BOOK_AUTHORINTRO 
                  from jeni_books_tb WHERE 1=1 ".$searchSQL;
    }else{
        $sql = "select BOOK_NO, BOOK_NAME, BOOK_AUTHOR, BOOK_PUBLISHER, BOOK_PRICE, BOOK_POINT, 
                       BOOK_CATEGORY, BOOK_IMAGE, BOOK_DATE, BOOK_INTRODUCTION, BOOK_AUTHORINTRO 
                  from jeni_books_tb 
                 where BOOK_CATEGORY = '$category'".$searchSQL;
    }
    
    $data = mysqli_query($conn, $sql);   // mysqli의 연결된 객체를 통해 mysql 쿼리를 실행시키는 함수, $conn은 dbconn.php의 DB 연결된 객체
    $totRowCnt = mysqli_num_rows($data); // 불러올 게시물 총 개수
    // echo $totRowCnt;
    
    $listCnt = 12; // 페이지에서 보여질 게시물 개수
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
    $pagingResult;
    if($category == "전체보기"){ // 카테고리가 전체보기일 경우
        $pagingResult = mysqli_query($conn, "select BOOK_NO, BOOK_NAME, BOOK_AUTHOR, BOOK_PUBLISHER, BOOK_PRICE, BOOK_POINT, 
                                                    BOOK_CATEGORY, BOOK_IMAGE, BOOK_DATE, BOOK_INTRODUCTION, BOOK_AUTHORINTRO 
                                               from jeni_books_tb 
                                              WHERE 1=1 ".$searchSQL.
                                            " order by BOOK_NO desc LIMIT $page_start, $listCnt"); // $page_start를 시작으로 $list의 수만큼 보여주도록 가져옴
    }else{
        $pagingResult = mysqli_query($conn, "select BOOK_NO, BOOK_NAME, BOOK_AUTHOR, BOOK_PUBLISHER, BOOK_PRICE, BOOK_POINT, 
                                                    BOOK_CATEGORY, BOOK_IMAGE, BOOK_DATE, BOOK_INTRODUCTION, BOOK_AUTHORINTRO 
                                               from jeni_books_tb 
                                              where BOOK_CATEGORY = '$category' ".$searchSQL.
                                             "order by BOOK_NO desc LIMIT $page_start, $listCnt"); // $page_start를 시작으로 $list의 수만큼 보여주도록 가져옴
    }
    $pagingResultCnt = mysqli_num_rows($pagingResult); // 현재 페이지의 게시물 개수   
?>