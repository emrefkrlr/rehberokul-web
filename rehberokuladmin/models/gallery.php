<?php
class GalleryModel extends DBOperation {
    
    public static $folders;

    public function roleAuths($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        return $this->single();
    }
    
    public function getDirectoryName($parentId) {
        $this->findByColumn('gallery', 'id', $parentId);
        $parent = $this->single();
        return $parentId == 0 ? 'Yok' : $parent['name'];
    }

    public function isDir($is_dir) {
        return $is_dir == 0 ? 'Hayır' : 'Evet';
    }
    
    public function setFolders() {
        if($_SESSION['user_data']['role'] == 'Yönetici') {
            $this->findByColumn('gallery', 'isdir', 1);
            $allFolders = $this->resultSet();
        } else if($_SESSION['user_data']['role'] == 'Kurum Sahibi'){
            $allFolders = array();
            $this->findByColumn('gallery', 'user_id', $_SESSION['user_data']['user_id']);
            $this->addAndClause('isdir',1);
            $galleriesAddedByUser = $this->resultSet(); // Kurum sahibinin eklediği galeri ve fotoğraflar
            $this->findByColumn('school_owner', 'user_id', $_SESSION['user_data']['user_id']);
            $ownerSchoolIds = $this->resultSet(); // Kurum sahibinin hangi okulları var
            foreach($ownerSchoolIds as $ownerSchoolId) { // Okullara ait başkası tarafından galeri eklendiyse
                $this->findByColumn('school_gallery', 'school_id', $ownerSchoolId['school_id']);
                $schoolGallery = $this->single(); // Okul için seçilen galeri row
                if($schoolGallery['gallery_id'] != 0) { // Rowda gallery id var ise table listesine ekle
                    $this->findByColumn('gallery', 'id', $schoolGallery['gallery_id']);
                    $this->addAndClause('user_id', $_SESSION['user_data']['user_id'], 'NOT');
                    $this->orderBy('creation_time', 'desc');
                    $allFolders = array_merge($allFolders, $this->resultSet());
                }

            }
            $allFolders = array_merge($galleriesAddedByUser, $allFolders);
        } else {
            $allFolders = array();
            $this->findByColumn('gallery', 'user_id', $_SESSION['user_data']['user_id']);
            $this->addAndClause('isdir',1);
            $galleriesAddedByUser = $this->resultSet(); // Kurum sahibinin eklediği galeri ve fotoğraflar
            $this->findByColumn('school_executive', 'user_id', $_SESSION['user_data']['user_id']);
            $ownerSchoolIds = $this->resultSet(); // Kurum sahibinin hangi okulları var
            foreach($ownerSchoolIds as $ownerSchoolId) { // Okullara ait başkası tarafından galeri eklendiyse
                $this->findByColumn('school_gallery', 'school_id', $ownerSchoolId['school_id']);
                $schoolGallery = $this->single(); // Okul için seçilen galeri row
                if($schoolGallery['gallery_id'] != 0) { // Rowda gallery id var ise table listesine ekle
                    $this->findByColumn('gallery', 'id', $schoolGallery['gallery_id']);
                    $this->addAndClause('user_id', $_SESSION['user_data']['user_id'], 'NOT');
                    $this->orderBy('creation_time', 'desc');
                    $allFolders = array_merge($allFolders, $this->resultSet());
                }

            }
            $allFolders = array_merge($galleriesAddedByUser, $allFolders);

        }

        self::$folders = $allFolders;
    }

    
    
    
    public function index() { 
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            if($_SESSION['user_data']['role'] == 'Yönetici') {
                $this->findAll('gallery');
                $this->orderBy('creation_time', 'desc');
                $galleries =  $this->resultSet();
            } else if($_SESSION['user_data']['role'] == 'Kurum Sahibi'){
                $galleries = array();
                $this->findByColumn('gallery', 'user_id', $_SESSION['user_data']['user_id']);
                $galleriesAddedByUser = $this->resultSet(); // Kurum sahibinin eklediği galeri ve fotoğraflar
                $this->findByColumn('school_owner', 'user_id', $_SESSION['user_data']['user_id']);
                $ownerSchoolIds = $this->resultSet(); // Kurum sahibinin hangi okulları var
                foreach($ownerSchoolIds as $ownerSchoolId) { // Okullara ait başkası tarafından galeri eklendiyse
                    $this->findByColumn('school_gallery', 'school_id', $ownerSchoolId['school_id']);
                    $schoolGallery = $this->single(); // Okul için seçilen galeri row
                    if($schoolGallery['gallery_id'] != 0) { // Rowda gallery id var ise table listesine ekle
                        $this->findByColumn('gallery', 'id', $schoolGallery['gallery_id']);
                        $this->addAndClause('user_id', $_SESSION['user_data']['user_id'], 'NOT');
                        $this->orderBy('creation_time', 'desc');
                        $galleries = array_merge($galleries, $this->resultSet());

                        $this->findByColumn('gallery', 'parent', $schoolGallery['gallery_id']);
                        $this->addAndClause('user_id', $_SESSION['user_data']['user_id'], 'NOT');
                        $this->orderBy('creation_time', 'desc');
                        $galleries = array_merge($galleries, $this->resultSet());

                    }

                }
                $galleries = array_merge($galleriesAddedByUser, $galleries);
            } else {
                $galleries = array();
                $this->findByColumn('gallery', 'user_id', $_SESSION['user_data']['user_id']);
                $galleriesAddedByUser = $this->resultSet(); // Kurum sahibinin eklediği galeri ve fotoğraflar
                $this->findByColumn('school_executive', 'user_id', $_SESSION['user_data']['user_id']);
                $ownerSchoolIds = $this->resultSet(); // Kurum sahibinin hangi okulları var
                foreach($ownerSchoolIds as $ownerSchoolId) { // Okullara ait başkası tarafından galeri eklendiyse
                    $this->findByColumn('school_gallery', 'school_id', $ownerSchoolId['school_id']);
                    $schoolGallery = $this->single(); // Okul için seçilen galeri row
                    if($schoolGallery['gallery_id'] != 0) { // Rowda gallery id var ise table listesine ekle
                        $this->findByColumn('gallery', 'id', $schoolGallery['gallery_id']);
                        $this->addAndClause('user_id', $_SESSION['user_data']['user_id'], 'NOT');
                        $this->orderBy('creation_time', 'desc');
                        $galleries = array_merge($galleries, $this->resultSet());
                        $this->findByColumn('gallery', 'parent', $schoolGallery['gallery_id']);
                        $this->addAndClause('user_id', $_SESSION['user_data']['user_id'], 'NOT');
                        $this->orderBy('creation_time', 'desc');
                        $galleries = array_merge($galleries, $this->resultSet());
                    }

                }
                $galleries = array_merge($galleriesAddedByUser, $galleries);

            }

            return $galleries;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }
    
    public function viewEdit($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->setFolders();
            $this->findByColumn('gallery', 'link', $link);
            $gallery = $this->single();
            if($gallery) {
                return $gallery;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }
    
    public function viewAdd() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
            $this->setFolders();
            return;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }
    
    public function viewDelete($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->setFolders();
            $this->findByColumn('gallery', 'link', $link);
            $gallery = $this->single();
            if($gallery) {
                return $gallery;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }
    
    public function detail($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->setFolders();
            $this->findByColumn('gallery', 'link', $link);
            $gallery = $this->single();
            if($gallery) {
                return $gallery;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }
    
    public function edit($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();
                    $this->findByColumn('gallery', 'link', $link);
                    $folder = $this->single(); // Current File Or Gallery
                    //edite tıklanan obje folder ise ve formda seçilen değer de klasör ise ve tıklanan objeye ait klasör boş ise
                    if($folder['isdir'] == 1) {
                        $this->setWhereConditionForUpdate('link', $link);
                        $this->updateByColumn('gallery', array(
                            'name' => $post['folder_name'],
                            'user_id' => $_SESSION['user_data']['user_id'],
                            'link' => URLHelper::seflinkGenerator($post['folder_name'].'-0')
                        ), $link);
                        $this->databaseHandler->commit();
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Klasör Başarıyla Güncellendi!', 'success');
                        echo '<script>window.location.href ="'.ROOT_URL.'gallery";</script>';
                    } else {
                        $selectedFolderId = $post['select_folder']; // Selected gallery id from the dropdown
                        $this->findByColumn('gallery', 'id', $selectedFolderId);
                        $selectedFolder = $this->single(); // Selected Gallery found by selected gallery id
                        $selectedFolderHref = $selectedFolder['href'];
                        $allowed =  array('jpeg','png' ,'jpg', 'JPEG', 'PNG', 'JPG');
                        $filename = $_FILES['file-haber']['name'];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        if(!in_array($ext,$allowed) && !empty($filename)) { // If file upload is not empty and extensions are not allowed
                            $this->databaseHandler->rollback(); 
                            unset($_SESSION['token']);
                            Security::changeSessionIdAndCsrf();
                            Message::setMessage('Kaydetme Başarısız! <br />Fotoğraf uzantısı jpg, jpeg veya png olabilir!', 'error');
                            echo '<script>window.location.href ="'.ROOT_URL.'gallery";</script>'; 
                            return;
                        }
                        // Find the current photo's path/href -- If new file is uploaded swap old one with the new one
                        $filePath = !empty($filename) ? substr($selectedFolderHref.URLHelper::seflinkGenerator($post['photo_name']).'.jpg', 0, strrpos($selectedFolderHref.URLHelper::seflinkGenerator($post['photo_name']).'.jpg', '.')) : '';
                        $this->setWhereConditionForUpdate('link', $link);
                        $this->updateByColumn('gallery', array(
                            'name' => $post['photo_name'],
                            'parent' => $selectedFolderId,
                            'user_id' => $_SESSION['user_data']['user_id'],
                            'href' => !empty($filename) ? $filePath.'.jpg' : $folder['href'],
                            'link' => URLHelper::seflinkGenerator($post['photo_name'].'-'.$selectedFolderId)
                        ), $link);
                        if(!empty($filename)) {
                            FileUploader::uploadSingleFileToServerDynamic('file-haber', $selectedFolderHref, URLHelper::seflinkGenerator($post['photo_name']));
                            unlink($folder['href']);
                        }

                        if($folder['parent'] != $selectedFolder['parent']) {
                            if(empty($filename)) {
                                shell_exec('mv ' . $folder['href'] . ' ' . $selectedFolder['href']);
                                $imageFile = substr($folder['href'], strrpos($folder['href'], '/'));
                                $newPath = $selectedFolder['href'] . $imageFile;
                                $this->setWhereConditionForUpdate('id', $folder['id']);
                                $this->updateByColumn('gallery', array(
                                    'href' => $newPath
                                ), $folder['id']);
                            }
                        }



                        $this->databaseHandler->commit();
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Fotoğraf Başarıyla Güncellendi!', 'success');
                        echo '<script>window.location.href ="'.ROOT_URL.'gallery";</script>';                         
                        
                    }
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback(); 
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Güncelleme Başarısız! <br />Galeri / Fotoğraf Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'gallery";</script>';     
        }
        return;
    }
    
    public function add() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                        $this->databaseHandler->beginTransaction();
                        if($post['select_folder'] != 0) {
                            $selectedFolderId = $post['select_folder'];
                            $this->findByColumn('gallery', 'id', $selectedFolderId);
                            $selectedFolder = $this->single();
                            $selectedFolderHref = $selectedFolder['href'];
                        } else {
                            $selectedFolderHref = '../images/galeri/';
                        }

                        if($post['isdir'] != '1') {
                            $this->save('gallery',
                                array('name', 'user_id', 'parent', 'isdir', 'href', 'link'),
                                array($post['folder_name'], $_SESSION['user_data']['user_id'], 0, 1,
                                    $selectedFolderHref.URLHelper::seflinkGenerator($post['folder_name']).'/', URLHelper::seflinkGenerator($post['folder_name'].'-0')));
                            mkdir($selectedFolderHref.URLHelper::seflinkGenerator($post['folder_name']));
                        } else {

                            $file_names = $_FILES['file-haber']['name'];
                            $file_count = 0;
                            $selectedFolder = $post['select_folder'];
                            foreach ($file_names as $file_name) {
                                $allowed =  array('jpeg','png' ,'jpg', 'JPEG', 'PNG', 'JPG');
                                $filename = $file_name;
                                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                                if(!in_array($ext,$allowed) ) {
                                    $this->databaseHandler->rollback();
                                    unset($_SESSION['token']);
                                    Security::changeSessionIdAndCsrf();
                                    Message::setMessage('Kaydetme Başarısız! <br />Fotoğraf uzantısı jpg, jpeg veya png olabilir!', 'error');
                                    echo '<script>window.location.href ="'.ROOT_URL.'gallery";</script>';
                                    return;
                                }


                                $filePath = substr($selectedFolderHref.URLHelper::seflinkGenerator($post['photo_name'].'-'.$file_count).'.jpg', 0, strrpos($selectedFolderHref.URLHelper::seflinkGenerator($post['photo_name'].'-'.$file_count).'.jpg', '.'));
                                $this->save('gallery',
                                    array('name', 'user_id', 'parent', 'isdir', 'href', 'link'),
                                    array($post['photo_name'].' '.$file_count, $_SESSION['user_data']['user_id'], $selectedFolder, 0,
                                        $filePath.'.jpg', URLHelper::seflinkGenerator($post['photo_name'].'-'.$file_count.'-'.$post['select_folder'])));

                                FileUploader::multiUploadSingleFileToServerDynamic('file-haber', $selectedFolderHref, URLHelper::seflinkGenerator($post['photo_name'].'-'.$file_count), $_FILES['file-haber']['tmp_name'][$file_count]);
                                $file_count++;
                            }

                        }
                        
                        $this->databaseHandler->commit();
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Başarıyla Kaydedildi!', 'success');
                        echo '<script>window.location.href ="'.ROOT_URL.'gallery";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback(); 
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Kaydetme Başarısız! <br />Fotoğraf Adı Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'gallery";</script>'; 
        }
        return;
    }

    private function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                        rrmdir($dir. DIRECTORY_SEPARATOR .$object);
                    else
                        unlink($dir. DIRECTORY_SEPARATOR .$object);
                }
            }
            rmdir($dir);
        }
    }

    public function delete($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();
                    $this->findByColumn('gallery', 'link', $link);
                    $folder = $this->single();
                    if($folder['isdir'] == 1) {
                        $this->findByColumn('school_gallery', 'gallery_id', $folder['id']);
                        $school_gallery = $this->single();
                        if($school_gallery) {
                            $this->databaseHandler->rollback();
                            unset($_SESSION['token']);
                            Security::changeSessionIdAndCsrf();
                            Message::setMessage('Silme Başarısız! Galeri Bir Okul Detayında Kullanılıyor!', 'error');
                            echo '<script>window.location.href ="'.ROOT_URL.'gallery";</script>';
                        } else {
                            $this->deleteByColumn('gallery', 'parent', $folder['id']);
                            $this->execute();
                            $this->deleteByColumn('gallery', 'link', $link);
                            $this->execute();
                            $this->databaseHandler->commit();
                            $this->rrmdir($folder['href']);
                            unset($_SESSION['token']);
                            Security::changeSessionIdAndCsrf();
                            Message::setMessage('Klasör Başarıyla Silindi!', 'success');
                            echo '<script>window.location.href ="'.ROOT_URL.'gallery";</script>';
                        }

                    } else {
                        if(unlink($folder['href'])) {
                            $this->deleteByColumn('gallery', 'link', $link);
                            $this->execute();
                            $this->databaseHandler->commit();
                            unset($_SESSION['token']);
                            Security::changeSessionIdAndCsrf();
                            Message::setMessage('Fotoğraf Başarıyla Silindi!', 'success');
                            echo '<script>window.location.href ="'.ROOT_URL.'gallery";</script>';
                        } else {
                            $this->databaseHandler->rollback();
                            unset($_SESSION['token']);
                            Security::changeSessionIdAndCsrf();
                            Message::setMessage('Silme Başarısız!', 'error');
                            echo '<script>window.location.href ="'.ROOT_URL.'gallery";</script>'; 
                        }
                    }
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback(); 
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'gallery";</script>'; 
        }
        return;
    }

        
}

