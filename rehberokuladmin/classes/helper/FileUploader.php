<?php
class FileUploader {
    
    public static function uploadSingleFileToServerSchoolType($file_input_name,$ttl) {
        $targetdir = '../images/schooltype/';
        if(empty($_FILES[$file_input_name]))
        {
            exit();
        }
        // name of the directory where the files should be stored
        $targetfile = strtolower($targetdir.$ttl.'.jpg');
        if(file_exists(substr($targetfile, 0, strrpos($targetfile, '.')).'.jpg')
                || file_exists(substr($targetfile, 0, strrpos($targetfile, '.')).'.png')
                || file_exists(substr($targetfile, 0, strrpos($targetfile, '.')).'.jpeg')) {
            $temp = substr($ttl.'.jpg', 0, strrpos($ttl.'.jpg', '.')); // son noktadan 
            $newfilename = $temp.round(microtime(true)) . '.' . substr($ttl.'.jpg', strrpos($ttl.'.jpg', '.') + 1);//son noktadan sonraki 
            $targetfile = strtolower($targetdir.$newfilename);  
        }
        
        if (move_uploaded_file($_FILES[$file_input_name]['tmp_name'], $targetfile)) {
          $targetfile = self::compressAndToJpeg($targetfile);
          unlink(substr($targetfile, 0, strrpos($targetfile, '.')).'.png');
          unlink(substr($targetfile, 0, strrpos($targetfile, '.')).'.jpeg');
          return $targetfile;
        } else { 
          return;
        }
    }

    public static function uploadSingleFileToServerBlog($file_input_name,$ttl) {
        $targetdir = '../images/blog/';
        if(empty($_FILES[$file_input_name]))
        {
            exit();
        }
        // name of the directory where the files should be stored
        $targetfile = strtolower($targetdir.$ttl.'.jpg');
        if(file_exists(substr($targetfile, 0, strrpos($targetfile, '.')).'.jpg')
            || file_exists(substr($targetfile, 0, strrpos($targetfile, '.')).'.png')
            || file_exists(substr($targetfile, 0, strrpos($targetfile, '.')).'.jpeg')) {
            $temp = substr($ttl.'.jpg', 0, strrpos($ttl.'.jpg', '.')); // son noktadan
            $newfilename = $temp.round(microtime(true)) . '.' . substr($ttl.'.jpg', strrpos($ttl.'.jpg', '.') + 1);//son noktadan sonraki
            $targetfile = strtolower($targetdir.$newfilename);
        }

        if (move_uploaded_file($_FILES[$file_input_name]['tmp_name'], $targetfile)) {
            $targetfile = self::compressAndToJpeg($targetfile);
            unlink(substr($targetfile, 0, strrpos($targetfile, '.')).'.png');
            unlink(substr($targetfile, 0, strrpos($targetfile, '.')).'.jpeg');
            return $targetfile;
        } else {
            return;
        }
    }


    public static function uploadSingleFileToServerScholdership($file_input_name,$ttl) {
        $targetdir = '../images/scholdership/';
        if(empty($_FILES[$file_input_name]))
        {
            exit();
        }
        // name of the directory where the files should be stored
        $targetfile = strtolower($targetdir.$ttl.'.jpg');
        if(file_exists(substr($targetfile, 0, strrpos($targetfile, '.')).'.jpg')
            || file_exists(substr($targetfile, 0, strrpos($targetfile, '.')).'.png')
            || file_exists(substr($targetfile, 0, strrpos($targetfile, '.')).'.jpeg')) {
            $temp = substr($ttl.'.jpg', 0, strrpos($ttl.'.jpg', '.')); // son noktadan
            $newfilename = $temp.round(microtime(true)) . '.' . substr($ttl.'.jpg', strrpos($ttl.'.jpg', '.') + 1);//son noktadan sonraki
            $targetfile = strtolower($targetdir.$newfilename);
        }

        if (move_uploaded_file($_FILES[$file_input_name]['tmp_name'], $targetfile)) {
            $targetfile = self::compressAndToJpeg($targetfile);
            unlink(substr($targetfile, 0, strrpos($targetfile, '.')).'.png');
            unlink(substr($targetfile, 0, strrpos($targetfile, '.')).'.jpeg');
            return $targetfile;
        } else {
            return;
        }
    }
    
    public static function uploadSingleFileToServerDynamic($file_input_name, $dir, $ttl) {
        $targetdir = $dir;   
        if(empty($_FILES[$file_input_name]))
        {
            exit();
        }
        // name of the directory where the files should be stored
        $targetfile = strtolower($targetdir.$ttl.'.jpg');
        if(file_exists(substr($targetfile, 0, strrpos($targetfile, '.')).'.jpg')
                || file_exists(substr($targetfile, 0, strrpos($targetfile, '.')).'.png')
                || file_exists(substr($targetfile, 0, strrpos($targetfile, '.')).'.jpeg')) {
            $temp = substr($ttl.'.jpg', 0, strrpos($ttl.'.jpg', '.')); // son noktadan 
            $newfilename = $temp.round(microtime(true)) . '.' . substr($ttl.'.jpg', strrpos($ttl.'.jpg', '.') + 1);//son noktadan sonraki 
            $targetfile = strtolower($targetdir.$newfilename);  
        }

        if (move_uploaded_file($_FILES[$file_input_name]['tmp_name'], $targetfile)) {
          $targetfile = self::compressAndToJpeg($targetfile);
          unlink(substr($targetfile, 0, strrpos($targetfile, '.')).'.png');
          unlink(substr($targetfile, 0, strrpos($targetfile, '.')).'.jpeg');
          return $targetfile;
        } else { 
          return;
        }
    }
    
    public static function multiUploadSingleFileToServerDynamic($file_input_name, $dir, $ttl, $files) {
        $targetdir = $dir;   
        if(empty($_FILES[$file_input_name]))
        {
            exit();
        }
        // name of the directory where the files should be stored
        $targetfile = strtolower($targetdir.$ttl.'.jpg');
        if(file_exists(substr($targetfile, 0, strrpos($targetfile, '.')).'.jpg')
                || file_exists(substr($targetfile, 0, strrpos($targetfile, '.')).'.png')
                || file_exists(substr($targetfile, 0, strrpos($targetfile, '.')).'.jpeg')) {
            $temp = substr($ttl.'.jpg', 0, strrpos($ttl.'.jpg', '.')); // son noktadan 
            $newfilename = $temp.round(microtime(true)) . '.' . substr($ttl.'.jpg', strrpos($ttl.'.jpg', '.') + 1);//son noktadan sonraki 
            $targetfile = strtolower($targetdir.$newfilename);  
        }
                
        if (move_uploaded_file($files, $targetfile)) {
          $targetfile = self::compressAndToJpeg($targetfile);
          unlink(substr($targetfile, 0, strrpos($targetfile, '.')).'.png');
          unlink(substr($targetfile, 0, strrpos($targetfile, '.')).'.jpeg');
          return $targetfile;
        } else { 
          return;
        }
    }

    
    public static function compressAndToJpeg($filePath) {
        $image = imagecreatefrompng($filePath);
        $bg = imagecreatetruecolor(imagesx($image), imagesy($image)); // source img'in boyutlarını alıyoruz
        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255)); 
        imagealphablending($bg, TRUE);
        imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imagedestroy($image);
        $quality = 90; // 0 dan 100e doğru çıktıkça kalite artıyor
        $filePath = substr($filePath, 0, strrpos($filePath, '.')); // dosya adı .jpg den öncesi
        imagejpeg($bg, $filePath . ".jpg", $quality);
        imagedestroy($bg);
        return $filePath.'.jpg';
    }

}