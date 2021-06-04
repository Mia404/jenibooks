<?php
    // MySQL 서버의 특정 데이터베이스로 연결하기
    $server = "localhost"; // MySQL 서버가 동작하는 호스트 컴퓨터의 IP주소 또는 도메인명
    $user = "root"; // MySQL 서버의 접속 계정
    $passwd = ""; // MySQL 서버의 접속 계정 비밀번호
    $dbname = "jenibooks_db"; // 연결할 DB명
                              
    // $conn 객체는 mysqli 클래스의 객체. 연결이 성공하면 정상적으로 생성됨.
    $conn = new mysqli($server, $user, $passwd, $dbname); // DB 서버에 접속 요청
                                                          
    // DB 접속 연결에 실패했을 시
    if ($conn->connect_error) {
        die("food_db 접속 오류");
    }
    
    // IP 가져오기
    function get_client_ip()
    {
        $ipaddress = "";
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = "UNKNOWN";
        return $ipaddress;
    }
?>