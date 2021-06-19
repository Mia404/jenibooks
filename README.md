제니북스 온라인 서점 프로젝트
=============

# 1. 데이터 베이스
-------------
#### 1.1. jeni_user_tb 테이블의 USER_STATE
- 0 : 회원, 1 : 탈퇴회원, 2 : 관리자

#### 1.2 jeni_order_tb 테이블의 ORDER_STATE
- 0 : 배송준비중, 1 : 배송중, 2 : 배송완료, 3 : 반품

- - -

# 2. 세션 데이터 정보
------------- 
USER_ID      : ex) powk2005@naver.com
USER_ACCOUNT : ex) powk2005
USER_STATE   : ex) 0, 1, 2

- - -

# 3. 책 데이터 크롤링
-------------
네이버책 웹사이트에서 500개 데이터 크롤링, 삭제된 페이지 또는 파싱해오는 주요 데이터가 누락된 경우를 제외하고 448개의 책 데이터 수집

ex) 크롤링 페이지 시드 처리
int bookBid = 2623907 + i;
HttpClient httpClient = new DefaultHttpClient();
HttpGet httpget = new HttpGet("http://book.naver.com/bookdb/book_detail.nhn?bid="+Integer.toString(bookBid));

#### * 파싱해서 추출한 BOOK_CATEGORY 내용
해외도서, 잡지, 과학/공학, 자기계발, 컴퓨터/IT, 유아, 어린이, 시/에세이
취업/수험서, 학습/참고서, 국어/외국어, 가정/생활/요리, 경제/경영, 취미/레저, 사회, 종교, 소설, 만화, 기타

#### * 그외 추가로 수집된 카테고리
사전, 여행/지도, 역사/문화, 예술/대중문화, 인문, 건강

#### 메인 페이지의 오늘의 책, 베스트 셀러 관련 데이터 삽입.
크롤링할 때 추가한 데이터가 아닌, 메인페이지에 보일 데이터로 직접 테이블에 insert함.
(잡스의 기준) https://book.naver.com/bookdb/book_detail.nhn?bid=16364080
(442시간의 법칙) https://book.naver.com/bookdb/book_detail.nhn?bid=16377971

#### * DB에는 없는 카테고리명 : 전체보기
메뉴 경로의 도서 카테고리 항목을 누르면 전체보기를 할 수 있음, 현재 검색 시 전체보기를 기준으로 검색한다.

- - -

# 4. 게시판 추가 방법
-------------
jeni_bbs_list_tb와 jeni_bbs_tb를 이용한다. 
만약 jeni_bbs_tb에는 없는 고유 속성이 필요할땐  jeni_bbs_게시판명_tb 과 같이 만들어 사용.

jeni_bbs_list_tb ==> 해당 게시판의 종류, 이름 기입
jeni_bbs_tb      ==> 게시판 마스터 테이블 (기본적인 게시판 테이블, CRUD)
jeni_bbs_*_tb    ==> 게시판 디테일 테이블 (추가하려는 게시판에서 사용되는 고유 속성 테이블)

- - -

# 5. 그외
-------------
웹페이지 접속경로 : 118.32.77.105:8081

개발툴 eclipse(JDK-14)
서버 및 DB xampp
위지윅 에디터 ckeditor_4.16.1_standard

미흡한 유효성 검증 체크 처리
자주 사용되는 항목의 함수나 반복적인 처리작업은 함수화하고, 코드이그나이터 같은 프레임워크를 사용해 코드 개선필요 

추가 및 개선사항은 모두 ReadMe.txt에 적어두고, 깃헙 마크다운은 그때마다 수정하여 가독성을 높일 것.
- - -