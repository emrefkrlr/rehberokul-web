<?php
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if((isset($post['comment']) && $post['comment'] != '') &&
    (isset($post['like_type']) && $post['like_type'] != '')) {
    require_once('../php/Core.php');

    if(!(isset($_SESSION['user_data']) && isset($_SESSION['is_logged_in']))) {
        echo 99;
        exit();
    }

   

    $db->where('comment_id', $post['comment']);
    $db->where('user_id', $_SESSION['user_data']['user_id']);
    $commentUserLike = $db->getOne('comment_likes');
    if($commentUserLike && $commentUserLike['liked'] != $post['like_type']) {
        $likeData = Array (
            'liked' => $post['like_type']
        );
        $db->where('comment_id', $post['comment']);
        $db->where('user_id', $_SESSION['user_data']['user_id']);
        $db->update('comment_likes', $likeData);
    } else if($commentUserLike && $commentUserLike['liked'] == $post['like_type']) {
        $likeData = Array (
            'liked' => 0
        );
        $db->where('comment_id', $post['comment']);
        $db->where('user_id', $_SESSION['user_data']['user_id']);
        $db->update('comment_likes', $likeData);
    } else {
        $likeData = Array (
            'user_id' => $_SESSION['user_data']['user_id'],
            'comment_id' => $post['comment'],
            'liked' => $post['like_type']
        );
        $db->insert('comment_likes', $likeData);
    }
    $db->where('comment_id', $post['comment']);
    $db->where('liked', 1);
    $commentLikes = $db->get('comment_likes');
    $db->where('comment_id', $post['comment']);
    $db->where('liked', 2);
    $commentDislikes = $db->get('comment_likes');
    $data[] = array(
        'likes' => count($commentLikes),
        "dislikes"=> count($commentDislikes)
    );
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}
