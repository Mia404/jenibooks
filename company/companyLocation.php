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
            
            <article class="col-md-10">
                <div class="row"><span style="float: right;"><a href="/main.php">Home</a> &gt; <a href="#">제니북스</a> &gt; <a href="/company/companyLocation.php">찾아오시는 길</a></span></div>
                <h2 style="float: left;">찾아오시는 길</h2>
                
                <div class="row col-md-12"><hr><br></div>
                
                <div class="row col-md-12" id="map" style="height:400px;"></div>
                <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=f19ba5a1a5634cc4bdc2607fbe940e20"></script>
                <script type="text/javascript">
                    var container = document.getElementById('map'); //지도를 담을 영역의 DOM 레퍼런스
                    var options = { //지도를 생성할 때 필요한 기본 옵션
                        center: new kakao.maps.LatLng(37.873877765250214, 127.15601362628695), //지도의 중심좌표.
                        level: 3 //지도의 레벨(확대, 축소 정도)
                    };
                    
                    var map = new kakao.maps.Map(container, options); //지도 생성 및 객체 리턴

	                   // 마커를 표시할 위치와 title 객체 배열입니다 
                       var positions = [
                           {
                               title: '대진대학교', 
                               latlng: new kakao.maps.LatLng(37.873877765250214, 127.15601362628695)
                           }
                       ];

                       // 마커 이미지의 이미지 주소입니다
                       var imageSrc = "https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/markerStar.png"; 
                           
                       for (var i = 0; i < positions.length; i ++) {
                           // 마커 이미지의 이미지 크기 입니다
                           var imageSize = new kakao.maps.Size(24, 35); 
                           
                           // 마커 이미지를 생성합니다    
                           var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize); 
                           
                           // 마커를 생성합니다
                           var marker = new kakao.maps.Marker({
                               map: map, // 마커를 표시할 지도
                               position: positions[i].latlng, // 마커를 표시할 위치
                               title : positions[i].title, // 마커의 타이틀, 마커에 마우스를 올리면 타이틀이 표시됩니다
                               image : markerImage // 마커 이미지 
                           });
                       }
                </script>
                
                <div class="row col-md-12"><hr></div>
                
                <div class="row col-md-12">
                    <ul class="list-unstyled">
						<li><em>주소</em> : 경기도 포천시 호국로 1007(선단동)</li>
                        <li><em>이용시간</em> : 월~금 09:00 ~ 18:00 (12:00 ~ 13:00 점심시간)</li>
                    </ul>
                </div>

                <div class="row col-md-12"><!-- 지하철 정보 -->                    
                    <table class="table table-bordered">
                        <caption style="color: black;"><strong>제니북스로 오시는 지하철 이용노선</strong></caption>
                        <colgroup>
                            <col style="width:30%">
                            <col style="width:70%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col">노선</th>
                                <th scope="col">출구</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1호선</td>
                                <td>의정부역 1번 출구</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="row col-md-12">
                    <h2>버스 정보</h2>
                    <div class="col-md-5" style="padding-left: 0px;"><img src="https://www.seoul.go.kr/res_newseoul/images/seoul/pic-map-main.gif" alt="" /></div>
                    <div class="col-md-7">
                        <table class="table table-bordered">                            
                            <caption style="color: black;"><strong>제니북스로 오시는 버스의 이용노선 및 이용방법 정보 제공</strong></caption>
                            <colgroup>
                                <col style="width:40%">
                                <col style="width:60%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col">정류장명</th>
                                    <th scope="col">버스번호</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="left">2. 프레스센터(02507)</td>
                                    <td class="left">(마을) 종로09, 종로11<br>(경기) 799파주</td>
                                </tr>
                                <tr>
                                    <td class="left">3. 시청앞,덕수궁(02286)</td>
                                    <td class="left">(간선) 103, 150, 401, 402, 406, N16(심야)<br>(지선) 1711, 7016, 7022<br>(경기) 790파주, 799파주</td>
                                </tr>
                                <tr>
                                    <td class="left">4. 시청광장(02641)</td>
                                    <td class="left">(간선) 172, 405, 472, N62(심야)</td>
                                </tr>
                                <tr>
                                    <td class="left">5. 시청역(02503)</td>
                                    <td class="left">(마을) 종로09, 종로11</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </article>
		</div>
		
        <hr>
        <?php require_once($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
	</div>
</body>
</html>