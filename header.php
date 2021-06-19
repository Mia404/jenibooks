<?php session_start(); ?>
<!-- 헤더 영역 -->
<header id="header">
   <nav class="navbar navbar-trans navbar-fixed-top" role="navigation" >
       <div class="container">
           <div class="navbar-header">
               <button class="navbar-toggle" type="button" data-target="#navbar-collapsible" data-toggle="collapse">
                   <span class="sr-only">Toggle navigation</span> 
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="/main.php">제니 북스</a>
           </div>
           <div class="navbar-collapse collapse" id="navbar-collapsible">
               <ul class="nav navbar-nav navbar-left">
			   <?php 
			       // 세션에 회원ID가 없는 경우, 비 로그인 상태
			       if(!isset($_SESSION['USER_ID'])){ 
			   ?>
                   <li><a href="/login/login.php">로그인</a></li>
                   <li><a href="/join/register.php">회원가입</a></li>
			   <?php 
        		   // 세션 데이터가 있을 경우, 로그인 상태
			       }else{  
			   ?>
				   <li><a href="/users/userInfo.php"><?= $_SESSION['USER_ACCOUNT'] ?>님 환영합니다.</a></li>
                   <li class="dropdown" >
                       <a href="#" class="dropdown-toggle navbar-link"  data-toggle="dropdown" role="button" aria-expanded="false">계정관리 <span class="caret"></span></a>
                       <ul class="dropdown-menu navbar-link" role="menu">
                           <li><a href="/users/cart.php">장바구니</a></li>
                           <li class="divider"></li>
                           <li><a href="/users/orderList.php">주문내역</a></li>
                           <li class="divider"></li>
                           <li><a href="/users/userTasteBooks.php">주문시각화</a></li>
                           <li class="divider"></li>	
                           <li><a href="/login/logout.php">로그아웃</a></li>
                       </ul>
				   </li>
			   <?php 
			       } 
			   ?>				   
                   <li class="dropdown">
                       <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">커뮤니티<span class="caret"></span></a>
                       <ul class="dropdown-menu" role="menu">
						   <li><a href="/bbs/list.php?bbsType=FREE">자유 게시판</a></li>
						   <!-- <li class="divider"></li> -->
                           <!-- <li><a href="#">리뷰 게시판</a></li> -->
                           <li class="divider"></li>
                           <li><a href="/bbs/list.php?bbsType=NOTICE">공지 사항</a></li>
                           <li class="divider"></li>
                           <li><a href="/bbs/list.php?bbsType=EVENT">이벤트</a></li>
                           <!-- <li class="divider"></li> -->
                           <!-- <li><a href="#">고객 센터</a></li> -->
                       </ul>
                   </li>
                   <li>&nbsp;</li>
               </ul>
               
               <!-- ===================================================================== -->
	           <!-- 검색기능 시작 -->
               <?php 
                    $bookCondition = isset($_GET['bookCondition']) ? $_GET['bookCondition'] : "";       // 검색조건
                    $bookKeyword = isset($_GET['bookKeyword']) ? $_GET['bookKeyword'] : ""; // 검색키워드
               ?>
               <form class="navbar-form" action="/category/bookList.php" method="get" id="headerSearchForm">
                   <div class="col-sm-2">
                       <select class="form-control" data-style="btn-info" name="bookCondition" style="width: 100%;">
                           <option value="bookName"         <?php if("bookName" == $bookCondition) echo "selected='selected'";?>>제목</option>
                           <option value="bookAuthor"       <?php if("bookAuthor" == $bookCondition) echo "selected='selected'";?>>저자</option>
                           <option value="bookPublisher"    <?php if("bookPublisher" == $bookCondition) echo "selected='selected'";?>>출판사</option>
                       </select>
                   </div>
                   <div class="col-sm-4">
                       <div class="form-group" style="display: inline;">
                           <div class="input-group col-sm-12">
                               <input class="form-control" type="text" placeholder="제목, 저자, 출판사 검색" name="bookKeyword" value="<?= $bookKeyword ?>"> 
                               <span class="input-group-addon" style="cursor:pointer" id="headerSearchBtn">
                                   <span class="glyphicon glyphicon-search"></span>
                               </span>
                           </div>
                       </div>
                   </div>
               </form>
               <!-- 검색기능 끝 -->
               <!-- ===================================================================== -->
               <script>
				$(document).ready(function(){
					/* 헤더 검색버튼 클릭 시  */
					$("#headerSearchBtn").on("click", function(){
						$("#headerSearchForm").submit();
					});
				});
               </script>               
           </div>
       </div>
   </nav>
</header>
<br>