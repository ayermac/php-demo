<?php
//构建上传文件的信息，是否为字符串或者数组
function getFiles()
{
    $i = 0;
    foreach ($_FILES as $file) {
        if (is_string($file['name'])) {
            $files[$i] = $file;
            $i++;
        } elseif (is_array($file['name'])) {
            foreach ($file['name'] as $key => $value) {
                $files[$i]['name'] = $file['name'][$key];
                $files[$i]['type'] = $file['type'][$key];
                $files[$i]['tmp_name'] = $file['tmp_name'][$key];
                $files[$i]['error'] = $file['error'][$key];
                $files[$i]['size'] = $file['size'][$key];
                $i++;
            }
        }
    }
        return $files;
    }
    function uploadFile($fileInfo,$flag = true,$maxsize = 1048576,$path ='./upload',$allowExt = array('jpeg','jpg','png','gif'))
    {
        if ($fileInfo['error'] === UPLOAD_ERR_OK) {

            //检测上传的文件有没有超过最大值
            if ($fileInfo['size'] > $maxsize) {
                $res['mes'] = $fileInfo['name'] . '上传文件过大';
            }
            //检测文件是否为非法类型
            $ext = getExt($fileInfo['name']);

            if(!in_array($ext,$allowExt)){
                $res['mes'] = $fileInfo['name'] . '非法文件类型';
            }
            //检测文件是否为真实的图片，默认为真
            if ($flag) {
                if (!getimagesize($fileInfo['tmp_name'])) {
                    $res['mes'] = $fileInfo['name'] . '非真实图片';
                }
            }
            //检测文件是否通过 http post上传的
            if (!is_uploaded_file($fileInfo['tmp_name'])) {
                $res['mes'] = $fileInfo['name'] . '不是通过HTTP POST上传';
            }
            if($res) return $res;

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
                chmod($path, 0777);
            }
            $uniName = getUniName();
            $destination = $path . '/' . $uniName . '.' . $ext;
            if (!move_uploaded_file($fileInfo['tmp_name'],$destination)) {
                $res['mes'] = $fileInfo['name'] . '文件移动失败';
            }
            $res['mes'] = $fileInfo['name'] . '上传成功';
            $res['des'] = $destination;
            return $res;
        } else {
            switch ($fileInfo['error']) {
                case 1 :
                    $res['mes'] = '上传文件超过了PHP配置文件中upload_max_filesize选项的值';
                    break;
                case 2 :
                    $res['mes'] = '超过了表单MAX_FILE_SIZE限制的大小';
                    break;
                case 3 :
                    $res['mes'] = '文件部分被上传';
                    break;
                case 4 :
                    $res['mes'] = '没有选择上传文件';
                    break;
                case 6 :
                    $res['mes'] = '没有找到临时目录';
                    break;
                case 7 :
                case 8 :
                    $res['mes'] = '系统错误';
                    break;
            }
            return $res;
        }
    }
?>

