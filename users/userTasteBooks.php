<!DOCTYPE html>
<html>
<head>
	<title>[제니북스] "좋은 책 고르는 방법"</title>
	<?php require_once($_SERVER['DOCUMENT_ROOT']."/incLib/lib.php"); ?>
	<script src="/resources/js/springy/springy.js"></script>
	<script src="/resources/js/springy/springyui.js"></script>
</head>
<body>	
    <div id="wrap" class="container">
    	<?php require_once($_SERVER['DOCUMENT_ROOT']."/header.php"); ?>
		
		<script type="text/javascript">
			// 그래프 생성
			var graph = new Springy.Graph();
			var colors = ['#CC333F', '#EDC951', '#00A0B0', '#EB6841', '#6A4A3C', '#CC333F', '#00A0B0', '#6A4A3C', '#7DBE3C', '#EB6841'];
			
			// 그래프 JSON 배열 (각 요소마다 카테고리 별 책 이름들이 담긴 배열)
			var graphJSONArray = new Array();

			// 노드 추가 함수 (카테고리명, 책이름리스트)
			function addGraphJSON(category, bookNameList){
				var strArray = bookNameList.split("||");
				 
				var nodesArray = new Array(); // 노드 정보
				var edgesArray = new Array(); // 엣지 정보

				// 노드 배열 : 0번째 요소에 카테고리 넣기
				nodesArray[0] = category;
				
				// 노드 배열 : 데이터 추가(책 이름)
				for(var i=0; i<strArray.length; i++){
					nodesArray[i+1] = strArray[i];
				}

				// 엣지 배열 : 반복하여 각 원소마다 배열 형태 데이터 저장 [카테고리, 책이름1], [카테고리, 책이름2] , .. 
				for(var i=0; i<strArray.length; i++){
					var arr = new Array();
					arr[0] = category;					
					arr[1] = strArray[i];
					arr[2] = {'color' : colors[i % colors.length]};
					
					edgesArray[i] = arr;
					console.log(edgesArray[i]);
				}
				
				// json 오브젝트 생성
				var graphJSON = new Object();
				graphJSON.nodes = nodesArray;
				graphJSON.edges = edgesArray;

				// 그래프 JSON 배열에 요소 추가
				graphJSONArray.push(graphJSON);
			}
		</script>
		<?php
            # 추천 도서 페이지
            
    		# 로그인 세션정보 확인
    		if(!isset($_SESSION['USER_ID'])){
    		    echo "<script>alert('로그인이 필요합니다.');location.href='/login/login.php';</script>";
    		}
    		
    		$user_id = $_SESSION['USER_ID'];
    		
    		$sql = "SELECT C.BOOK_CATEGORY, COUNT(C.BOOK_CATEGORY) AS PURCHASE_QTY, GROUP_CONCAT(DISTINCT C.BOOK_NAME ORDER BY C.BOOK_NO ASC SEPARATOR '||') AS BOOK_NAME_LIST
    		          FROM jeni_order_tb a, jeni_order_detail_tb b, jeni_books_tb c
    		         WHERE A.ORDER_NO = B.ORDER_NO
    		           AND B.BOOK_NO  = C.BOOK_NO
    		           AND A.USER_ID  = '$user_id'
    		      GROUP BY C.BOOK_CATEGORY
    		      ORDER BY COUNT(C.BOOK_CATEGORY) DESC, C.BOOK_NO ASC";
    		
    		# 에러 처리
    		if(!$conn->query($sql)){
    		    die("도서 정보 조회 중 오류가 발생하였습니다.".$conn->error);
    		}
    		
    		$result = $conn->query($sql); // SQL 결과 데이터
    		$book_category_arr = array(); // 책 카테고리 배열리스트
    		
    		# 카테고리 내에 도서 정보 데이터를 가져온다.
    		if($result->num_rows > 0){
    		    while($row = $result->fetch_assoc()){
    		        array_push($book_category_arr, $row['BOOK_CATEGORY']); // 책 카테고리 배열리스트에 카테고리 추가
            ?>
    		        <script type="text/javascript">
    		        	addGraphJSON('<?= $row['BOOK_CATEGORY']?>', '<?= $row['BOOK_NAME_LIST']?>');
    		        </script>
			<?php 
    		    }
    		}
		?>
        <!-- 컨테이너 영역 -->
		<div class="container" style="position: relative;">
            <?php require_once($_SERVER['DOCUMENT_ROOT']."/aside.php"); ?>
            
            <article class="col-md-10">
                <div class="row"><span style="float: right;"><a href="/main.php">Home</a> &gt; <a href="/users/userInfo.php">회원정보</a> &gt; <a href="/users/userTasteBooks.php">주문시각화</a></span></div>
                <?php
                # 주문 데이터가 있는 경우 : 셀렉트 박스 처리
                if($result->num_rows > 0){
                    echo "<h2 style='float: left;'>카테고리별로 주문하신 도서들을 시각화했습니다.</h2>";
                    echo "<br>";
                    echo "<div style='float: right;'>";
                        echo "<select name='condition' class='form-control' id='selCategory'>";
    					 
    				    for($i=0; $i<count($book_category_arr); $i++){
                            echo "<option value='$i'>$book_category_arr[$i]</option>";
        				}
                    
        				echo "</select>";
    				echo "</div>";
    				
    				# 그래프 시각화를 위한 캔버스 엘리먼트
    				echo "<canvas id='springyCanvas' width='950' height='600' />";
                # 주문 데이터가 없는 경우 : 메시지 처리
                }else{
                    echo "<h2 style='float: left;'>주문 내역이 존재하지 않으므로 시각화하지 못했습니다.</h2>";
                    echo "<br>";
                }
                ?>
            </article>
		</div>
		
        <hr>
		<?php require_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?> 
	</div>    
    
    <?php 
        # 주문 데이터가 있는 경우 : 자바스크립트 처리
        if($result->num_rows > 0){
    ?>
            <script type="text/javascript">
                $(document).ready(function(){
                	/*            
                     jQuery('#springyCanvas').springy({ graph: graph, nodeSelected: function(node) {
                        if(node.data.label == "공학" || node.data.label == "과학/공학"){
                            document.location.href="/category/bookList.php";
                        }else{
                            document.location.href="/category/bookDetail.php";
                        }                
                    }});
         			*/
         			
                    // 화면에 그래프 그리기
                    var springy = jQuery('#springyCanvas').springy({graph : graph});			
                    
                    // 셀렉트 박스 항목 변경 시 
                    $("#selCategory").change(function () {
                    	for(var i=0; i<graphJSONArray.length; i++){
                        	// 현재 선택한 셀렉트 박스의 카테고리 value값과 graphJSONArray 인덱스가 같다면
                        	if(i == $(this).val()){
        						// 그래프의 현재 그려진 노드 삭제
                        		for(var j=graph.nodes.length-1; j>=0; j--){
        							graph.removeNode(graph.nodes[j]);
               					}
               					// 새로 화면에 그릴 카테고리 구매 도서 JSON 데이터 추가
                        		graph.loadJSON(graphJSONArray[i]);
                        	}
                    	}
        			}).change();
                });
            </script>
	<?php            
        }
    ?>
</body>
</html>