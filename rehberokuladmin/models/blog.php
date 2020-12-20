<?php
class BlogModel extends DBOperation {
    public static $roles;
    public static $tags;
    public static $blog_tags;

    public function roleAuths($role_name, $menu_id) {
        $this->findByColumn('role', 'role_name' , $role_name);
        $role = $this->single();
        $role_id = $role['role_id'];
        $this->findByColumn('auth', 'role_id', $role_id);
        $this->addAndClause('menu_id', $menu_id);
        return $this->single();
    }

    public function setTags() {
        $this->findAll('tag');
        $tags = $this->resultSet();
        self::$tags = $tags;
    }

    public function getCommentator($user_id) {
        $this->findByColumn('user', 'id', $user_id);
        $commentator = $this->single();
        return $commentator;
    }

    public function getBlogName($school_id) {
        $this->findByColumn('blog', 'id', $school_id);
        $blog = $this->single();
        return $blog['title'];
    }

    public function setBlogTags($blog_id) {
        $this->findByColumn('blog_tags', 'blog_id', $blog_id);
        $tags = $this->resultSet();
        self::$blog_tags = $tags;
    }



    public function getBlogTags($blog_id) {
        $this->findByColumn('blog_tags', 'blog_id', $blog_id);
        $tags = $this->resultSet();
        $result = '';
        for ( $i=0; $i< count($tags); $i++ ) {
            $result = $i != count($tags)-1 ? $result.$this->getTagName($tags[$i]['tag_id']).', '
                : $result.$this->getTagName($tags[$i]['tag_id']);
        }
        return $result;
    }

    public function getTagName($tag_id) {
        $this->findByColumn('tag', 'id', $tag_id);
        $tag = $this->single();
        return $tag['name'];
    }

    public function post() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findAll('blog');
            $this->orderBy('publish_date', 'DESC');
            $posts = $this->resultSet();
            return $posts;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function comment() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findAll('comment');
            $this->where('blog_id', 0, 'NOT');
            $this->orderBy('publish_date', 'DESC');
            $comments = $this->resultSet();
            return $comments;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function tag() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findAll('tag');
            $this->orderBy('id', 'DESC');
            $tags = $this->resultSet();
            return $tags;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewEditComment($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('comment', 'link', $link);
            $comment = $this->single();
            if($comment) {
                return $comment;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewDeleteComment($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->findByColumn('comment', 'link', $link);
            $comment = $this->single();
            if($comment) {
                return $comment;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function detailComment($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('comment', 'link', $link);
            $comment = $this->single();
            if($comment) {
                return $comment;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewEdit($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('blog', 'link', $link);
            $post = $this->single();
            $this->setTags();
            $this->setBlogTags($post['id']);
            if($post) {
                return $post;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewEditTag($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
            $this->findByColumn('tag', 'link', $link);
            $tag = $this->single();
            if($tag) {
                return $tag;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewAddTag() {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
            return;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function viewDeleteTag($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->findByColumn('tag', 'link', $link);
            $tag = $this->single();
            if($tag) {
                return $tag;
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }

    public function detailTag($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['reading']) {
            $this->findByColumn('tag', 'link', $link);
            $tag = $this->single();
            if($tag) {
                return $tag;
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
            $this->setTags();
            return;
        } else {
            echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
            return;
        }
    }



    public function viewDelete($link) {
        if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
            $this->findByColumn('blog', 'link', $link);
            $post = $this->single();
            $this->setTags();
            $this->setBlogTags($post['id']);
            if($post) {
                return $post;
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
            $this->findByColumn('blog', 'link', $link);
            $post = $this->single();
            $this->setTags();
            $this->setBlogTags($post['id']);
            if($post) {
                return $post;
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


                    $allowed =  array('jpeg','png' ,'jpg', 'JPEG', 'PNG', 'JPG');
                    $filename = $_FILES['file-icerik']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if(!in_array($ext,$allowed) && !empty($filename) ) {
                        $this->databaseHandler->rollback();
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Kaydetme Başarısız! <br />Fotoğraf uzantısı jpg, jpeg veya png olabilir!', 'error');
                        echo '<script>window.location.href ="'.ROOT_URL.'blog/post";</script>';
                        return;
                    }


                    $this->findByColumn('blog', 'link', $link);
                    $currentPost = $this->single();
                    $currentPostId = $currentPost['id'];

                    $old_fotograf = $currentPost['photo'];
                    !empty($_FILES['file-icerik']['name']) ? unlink($old_fotograf) : '';

                    $description = str_replace("&#39;","'",$post['description']);
                    $title = str_replace("&#39;","'",$post['title']);

                    // Upload Images in Content To Server
                    $this->summernoteUpload(URLHelper::seflinkGenerator($title));
                    // Delete Images If Post Had First But Not Now
                    $this->editSummernoteImagesAtServer(htmlspecialchars_decode($currentPost['content']),
                        htmlspecialchars_decode($_POST['content']));

                    $content = htmlspecialchars($_POST['content']);

                    $date = new DateTime($post['publish_date']);


                    // Updating Blog Post
                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('blog', array(
                        'content' => $content,
                        'photo' => !empty($_FILES['file-icerik']['name']) ? FileUploader::uploadSingleFileToServerBlog('file-icerik', URLHelper::seflinkGenerator($post['title'].'-'.$date->format('d-m-Y'))) : $old_fotograf,
                        'publish_date' => $post['publish_date'],
                        'description' => $description,
                        'title' => $title,
                        'link' => URLHelper::seflinkGenerator($post['title'].'-'.$date->format('d-m-Y'))
                    ), $link);

                    // Updating tags of post
                    $this->deleteByColumn('blog_tags', 'blog_id', $currentPostId);
                    $this->execute();
                    $tagss = $post['tagss'];
                    foreach($tagss as $tag) {
                        $this->save('blog_tags',
                            array('blog_id', 'tag_id'),
                            array($currentPostId, +$tag));
                    }

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Yazı Başarıyla Güncellendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'blog/post";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Güncelleme Başarısız! <br />Yazı/Başlık Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'blog/post";</script>';
        }
        return;
    }

    public function add() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    $allowed =  array('jpeg','png' ,'jpg', 'JPEG', 'PNG', 'JPG');
                    $filename = $_FILES['file-icerik']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if(!in_array($ext,$allowed) && !empty($filename) ) {
                        $this->databaseHandler->rollback();
                        unset($_SESSION['token']);
                        Security::changeSessionIdAndCsrf();
                        Message::setMessage('Kaydetme Başarısız! <br />Fotoğraf uzantısı jpg, jpeg veya png olabilir!', 'error');
                        echo '<script>window.location.href ="'.ROOT_URL.'blog/post";</script>';
                        return;
                    }


                    $title = str_replace("&#39;","''",$post['title']);
                    $description = str_replace("&#39;","''",$post['description']);


                    //Upload Images in Content To Server
                    $this->summernoteUpload(URLHelper::seflinkGenerator($title));

                    $date = new DateTime($post['publish_date']);

                    $content = htmlspecialchars($_POST['content']);
                    $content = str_replace("'", "''", $content);

                    // Adding a blog post
                    $this->save('blog',
                        array('title', 'description', 'photo', 'content', 'publish_date', 'link'),
                        array($title, $description, FileUploader::uploadSingleFileToServerBlog('file-icerik', URLHelper::seflinkGenerator($post['title'].'-'.$date->format('d-m-Y'))),
                            $content, $post['publish_date'], URLHelper::seflinkGenerator($post['title'].'-'.$date->format('d-m-Y'))));

                    // Last added post id
                    $addedPostId = $this->lastInsertId();

                    // Adding tags of post
                    $tagss = $post['tagss'];
                    foreach($tagss as $tag) {
                        $this->save('blog_tags',
                            array('blog_id', 'tag_id'),
                            array($addedPostId, +$tag));
                    }

                    $this->databaseHandler->commit();
                    Message::setMessage('Yazı Başarıyla Kaydedildi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'blog/post";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Kaydetme Başarısız! <br />Yazı/Başlık Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'blog/post";</script>';
        }
        return;
    }

    public function delete($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();
                    $this->findByColumn('blog', 'link', $link);
                    $currentPost = $this->single();
                    $currentPostId = $currentPost['id'];

                    // Delete tags of post
                    $this->deleteByColumn('blog_tags', 'blog_id', $currentPostId);
                    $this->execute();
                    // Delete Images In The Content From Server
                    $this->deleteSummernoteImagesFromServer(htmlspecialchars_decode($currentPost['content']));
                    // Delete Post
                    $this->deleteByColumn('blog', 'link', $link);
                    $this->execute();

                    $this->databaseHandler->commit();
                    Message::setMessage('Yazı Başarıyla Silindi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'blog/post";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'blog/post";</script>';
        }
        return;
    }

    public function addTag() {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['adding']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();
                    // Adding a tag
                    $this->save('tag',
                        array('name', 'description', 'link'),
                        array($post['tag_name'], $post['description'], URLHelper::seflinkGenerator($post['tag_name'])));

                    $this->databaseHandler->commit();
                    Message::setMessage('Kategori Başarıyla Kaydedildi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'blog/tag";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Kaydetme Başarısız! <br />Kategori Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'blog/tag";</script>';
        }
        return;
    }

    public function editTag($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {

                    $this->databaseHandler->beginTransaction();
                    // Updating a tag
                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('tag', array(
                        'description' => $post['description'],
                        'name' => $post['tag_name'],
                        'link' => URLHelper::seflinkGenerator($post['tag_name'])
                    ), $link);

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Kategori Başarıyla Güncellendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'blog/tag";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Güncelleme Başarısız! <br />Kategori Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'blog/tag";</script>';
        }
        return;
    }

    public function deleteTag($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();
                    // Deleting a tag
                    $this->deleteByColumn('tag', 'link',  $link);
                    $this->execute();
                    $this->databaseHandler->commit();
                    Message::setMessage('Kategori Başarıyla Silindi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'blog/tag";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'blog/tag";</script>';
        }
        return;
    }

    private function summernoteUpload($postTitle) {
        global $ttl;
        $ttl = $postTitle;
        $_POST['content'] = preg_replace_callback("/src=\"data:([^\"]+)\"/", function ($matches) {
            global $ttl;
            list($contentType, $encContent) = explode(';', $matches[1]);
            if (substr($encContent, 0, 6) != 'base64') {
                return $matches[0]; // Eğer base64 yoksa terminate et
            }
            $imgBase64 = substr($encContent, 6);
            $imgFilename = md5($imgBase64); // Dosya adı oluştur
            $imgExt = '';
            switch($contentType) {
                case 'image/jpeg':  $imgExt = 'jpg'; break;
                case 'image/gif':   $imgExt = 'jpg'; break;
                case 'image/png':   $imgExt = 'jpg'; break;
                default:            return $matches[0]; // hiç bir uzantı değilse terminate et
            }
            $imgPath = "../images/yazilar/".$ttl.'-'.uniqid().'.'.$imgExt; // yüklenecek yer
            // Eğer kayıtlı değilse sunucuya kaydet
            if (!file_exists($imgPath)) {
                $imgDecoded = base64_decode($imgBase64); // decode base64
                $fp = fopen($imgPath, 'w'); //stream aç
                if (!$fp) {
                    return $matches[0];//eğer başarılı değilse terminate et
                }
                fwrite($fp, $imgDecoded);//stream ile servera yaz
                fclose($fp);//streami kapat
            }

            return 'src="'.$imgPath.'" title="'.$ttl.'" alt="'.$ttl.'"';
        }, $_POST['content']);
    }



    private function deleteSummernoteImagesFromServer($html) {
        preg_match_all( '@src="([^"]+)"@' , $html, $match );
        $src = array_pop($match);
        for( $i=0; $i< count($src); $i++ ) {
            unlink($src[$i]);
        }
    }

    private function editSummernoteImagesAtServer($prevContent, $finalContent) {
        preg_match_all('@src="([^"]+)"@' , $prevContent, $match );
        $src = array_pop($match);
        preg_match_all('@src="([^"]+)"@' , $finalContent, $matchFinal);
        $src_final = array_pop($matchFinal);
        for( $i=0; $i< count($src); $i++ ) {
            if(!in_array($src[$i], $src_final ))
            {
                unlink($src[$i]);
            }
        }

    }

    public function editComment($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['editing']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {

                    $this->databaseHandler->beginTransaction();

                    $this->setWhereConditionForUpdate('link', $link);
                    $this->updateByColumn('comment', array(
                        'state' => $post['state'],
                        'comment' => $post['comment']
                    ), $link);

                    $this->databaseHandler->commit();
                    unset($_SESSION['token']);
                    Security::changeSessionIdAndCsrf();
                    Message::setMessage('Yorum Başarıyla Güncellendi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'blog/comment";</script>';
                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            unset($_SESSION['token']);
            Security::changeSessionIdAndCsrf();
            Message::setMessage('Güncelleme Başarısız! <br />Yorum Mevcut Olabilir!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'blog/comment";</script>';
        }
        return;
    }


    public function deleteComment($link) {
        try {
            if($this->roleAuths($_SESSION['user_data']['role'], Controller::$active_id)['deleting']) {
                $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                if(isset($post['submit']) && Security::checkCsrf($post['token'])) {
                    $this->databaseHandler->beginTransaction();

                    $this->deleteByColumn('comment', 'link', $link);
                    $this->execute();

                    $this->databaseHandler->commit();
                    Message::setMessage('Yorum Başarıyla Silindi!', 'success');
                    echo '<script>window.location.href ="'.ROOT_URL.'blog/comment";</script>';

                }
            } else {
                echo '<script>window.location.href ="'.ROOT_URL.'";</script>';
                return;
            }
        } catch(PDOException $e) {
            $this->databaseHandler->rollback();
            Message::setMessage('Silme Başarısız!', 'error');
            echo '<script>window.location.href ="'.ROOT_URL.'blog/comment";</script>';
        }
        return;
    }

}

