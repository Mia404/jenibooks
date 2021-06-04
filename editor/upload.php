<?php
    try {
        # 파라미터 설정
        $permit_exts = array("jpg", "jpeg", "png");             // 이미지 확장자
        $permit_size = 10485760;                                // 이미지 크기 10MB
        $default_dir = "/editor/uploadImages/".date("Ymd")."/"; // 이미지 저장경로
        $upload_dir  = $_SERVER['DOCUMENT_ROOT'].$default_dir;  // 브라우저에 표시할 이미지 경로
        
        # 이미지 디렉터리가 없을 경우 생성
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0707);

        # 업로드된 이미지 파일 배열 변수 받아옴
        $files = $_FILES['upload'];
        if ($files['tmp_name']) {
            # 임시 파일 배열변수 선언 및 확장자명 설정
            // $tmp_name = array();
            $tmp_file = array();
            $exp_name = pathinfo($files['name']);
            
            $tmp_file['name'] = preg_replace("/\s+/", "", strtolower($exp_name['filename']));
            $tmp_file['ext'] = strtolower($exp_name['extension']);
            $tmp_file['size'] = $files['size'];
            
            # 업로드 파일명 생성
            $upload_name = uniqid()."_".time().".".$tmp_file['ext'];
            
            # 같은 이름의 업로드 파일명이 업로드 폴더 내에 존재할 경우
            if (is_file($upload_dir.$upload_name)) {
                # 같은 이름의 파일이 존재하지 않을 때까지 업로드 파일명 재설정
                while (!is_file($upload_dir.$upload_name)) {
                    $upload_name = uniqid().'_'.time() .'.'.$tmp_file['ext'];
                }
            }
            
            # 업로드 파일이 이미지파일 확장자인지 체크
            if (!in_array($tmp_file['ext'], $permit_exts)){
                throw new Exception('이미지 파일만 첨부 할 수 있습니다.('.(implode(', ', $permit_exts)).')');
            }
            
            # 업로드 파일 사이즈 체크 
            if ($tmp_file['size'] > $permit_size){
                throw new Exception('10MB 이상 파일은 업로드할 수 없습니다.');
            }
            
            # 업로드 데이터 설정
            $data = array(
                'ori_name'    => $tmp_file['name'].'.'.$tmp_file['ext'],
                'tmp_name'    => $files['tmp_name'],
                'up_name'     => $upload_name,
                'error'       => $files['error'],
                'size'        => $files['size'],
                'path'        => $default_dir,
                'type'        => $files['type'],
                'img'         => $default_dir.$upload_name,
                'my_thumb_id' => explode('.',$upload_name)[0],
            );
            
            # 이미지 업로드
            move_uploaded_file($data['tmp_name'], $upload_dir.$data['up_name']);
            
            # 결과 리턴 JSON
            echo '{"filename" : "'.$data['up_name'].'", "uploaded" : 1, "url":"'.$default_dir.$data['up_name'].'"}';
        }else{
            throw new Exception('업로드된 파일이 없습니다.');
        }
    } catch (Exception $e) {
        # 에러 결과 리턴 JSON
        echo '{"uploaded": 0, "error": {"message": "'.$e->getMessage().'"}}';
    }
?>