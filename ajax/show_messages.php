<?php 

include "../init.php";

$obj = new base_class();

if(isset($_GET['message'])) {
    $user_id = $_SESSION['user_id'];
    if($obj->Normal_Query("SELECT clean_message_id FROM clean WHERE clean_user_id = ?", [$user_id])){
        $last_msg_row = $obj->Single_result();
        $last_msg_id = $last_msg_row->clean_message_id;

        $obj->Normal_Query("SELECT msg_id FROM messages ORDER BY msg_id DESC LIMIT 1");
        $msg_row = $obj->Single_result();
        $msg_table_id = $msg_row->msg_id;

        $obj->Normal_Query("SELECT * FROM messages INNER JOIN users ON messages.user_id = users.id WHERE
        messages.msg_id BETWEEN $last_msg_id AND $msg_table_id ORDER BY messages.msg_id ASC");

        if($obj->Count_Rows() == 0){
            echo "<p class='clean_message'>You have no conversatins yet </p>";
        } else {
            $messages_row = $obj->fetch_all();

            foreach($messages_row as $message_data):
    
                $full_name = ucwords($message_data->name);
                $user_image = $message_data->image;
                $user_status = $message_data->status;

                $message = $message_data->message;
                $msg_type = $message_data->msg_type;
                $db_user_id = $message_data->user_id;
                $msg_time = $obj->time_ago($message_data->msg_time);

                if($user_status == 0){
                    $user_online_status = '<div class="offline-icon"></div>';
                } else {
                    $user_online_status = '<div class="online-icon"></div>';
                }


                if($db_user_id == $user_id) {
                    //right user's messages

                    if($msg_type == "text" ){

                        echo   '<div class="right-messages common-margin">
                                <div class="right-msg-area">
                                    <span class="date-time right-time">
                                        <span class="send-msg">&#10004;</span>'.$msg_time.'
                                    </span><!-- close date-time -->
                                    <div class="right-msg">
                                        <p>'.$message.'</p>
                                    </div>
                                </div><!-- close right-msg-area -->
                            </div><!-- close right-messages -->';

                    } elseif($msg_type == "jpg" || $msg_type == "JPG" || $msg_type == "jpeg" || $msg_type == "JPEG"){

                        echo   '<div class="right-messages common-margin">
                                <div class="right-msg-area">
                                    <span class="date-time right-time right-messege-time">
                                        <span class="send-msg">&#10004;</span> '.$msg_time.'
                                    </span><!-- close date-time -->
                                    <div class="right-files">
                                        <img src="assets/img/'.$message.'" class="common-images">
                                    </div>
                                </div><!-- close right-msg-area -->
                            </div><!-- close right-messages -->';

                    } elseif($msg_type == "png" || $msg_type == "PNG"){

                        echo   '<div class="right-messages common-margin">
                                <div class="right-msg-area">
                                    <span class="date-time right-time right-messege-time">
                                        <span class="send-msg">&#10004;</span>'.$msg_time.'
                                    </span><!-- close date-time -->
                                    <div class="right-files">
                                    <img src="assets/img/'.$message.'" class="common-images">
                                    </div>
                                </div><!-- close right-msg-area -->
                            </div><!-- close right-messages -->';

                    } elseif($msg_type == "zip" || $msg_type == "ZIP"){

                        echo   '<div class="right-messages common-margin">
                                <div class="right-msg-area">
                                    <span class="date-time right-time right-messege-time">
                                        <span class="send-msg">&#10004;</span>'.$msg_time.'
                                    </span><!-- close date-time -->
                                    <div class="right-files">
                                        <a href="assets/img/'.$message.'" class="all-files"><i class="fas fa-arrow-circle-down files-common">
                                        </i>'.$message.'</a>
                                    </div>
                                </div><!-- close right-msg-area -->
                            </div><!-- close right-messages -->';

                    } elseif($msg_type == "pdf" || $msg_type == "PDF"){

                        echo   '<div class="right-messages common-margin">
                                <div class="right-msg-area">
                                    <span class="date-time right-time right-messege-time">
                                        <span class="send-msg">&#10004;</span>'.$msg_time.'
                                    </span><!-- close date-time -->
                                    <div class="right-files">
                                        <a href="assets/img/'.$message.'" class="all-files" target="_blank"><i class="far fa-file-pdf files-common pdf">
                                        </i>'.$message.'</a>
                                    </div>
                                </div><!-- close right-msg-area -->
                            </div><!-- close right-messages -->';

                    } elseif($msg_type == "emoji"){

                        echo   '<div class="right-messages common-margin">
                                <div class="right-msg-area">
                                    <span class="date-time right-time right-messege-time">
                                        <span class="send-msg">&#10004;</span>'.$msg_time.'
                                    </span><!-- close date-time -->
                                    <div class="right-files">
                                    <img src="'.$message.'" class="animated-emoji">
                                    </div>
                                </div><!-- close right-msg-area -->
                            </div><!-- close right-messages -->';

                    } elseif($msg_type == "docx"){

                        echo   '<div class="right-messages common-margin">
                                <div class="right-msg-area">
                                    <span class="date-time right-time right-messege-time">
                                        <span class="send-msg">&#10004;</span>'.$msg_time.'
                                    </span><!-- close date-time -->
                                    <div class="right-files">
                                        <a href="assets/img/'.$message.'" class="all-files"><i class="far fa-file-word files-common word">
                                        </i>'.$message.'</a>
                                    </div>
                                </div><!-- close right-msg-area -->
                            </div><!-- close right-messages -->';

                    } elseif($msg_type == "xlsx"){

                        echo   '<div class="right-messages common-margin">
                                <div class="right-msg-area">
                                    <span class="date-time right-time right-messege-time">
                                        <span class="send-msg">&#10004;</span>'.$msg_time.'
                                    </span><!-- close date-time -->
                                    <div class="right-files">
                                        <a href="assets/img/'.$message.'" class="all-files"><i class="far fa-file-excel files-common word">
                                        </i>'.$message.'</a>
                                    </div>
                                </div><!-- close right-msg-area -->
                            </div><!-- close right-messages -->';

                    }

                } else {
                    //left user's messages

                    if($msg_type == "text" ){

                        echo '  <div class="left-message common-margin">
                                    <div class="sender-img-block">
                                            <img src="assets/img/'.$user_image.'" alt="sender-img" class="sender-img">
                                            '.$user_online_status.'

                                    </div><!-- close sender-img-block -->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                                <span class="sender-name">
                                                '.$full_name.'
                                                </span><!-- close sender-name -->
                                                <span class="date-time">
                                                    '.$msg_time.'
                                                </span><!-- close date-time -->
                                        </div><!-- close user-name-date -->
                                        <div class="left-msg">
                                            <p>'.$message.'</p>
                                        </div><!-- close left-msg -->
                                    </div><!-- close left-msg-area -->
                                </div><!-- close left message -->';

                    } elseif($msg_type == "jpg" || $msg_type == "JPG" || $msg_type == "jpeg" || $msg_type == "JPEG"){

                        echo '  <div class="left-message common-margin">
                                    <div class="sender-img-block">
                                            <img src="assets/img/'.$user_image.'" alt="sender-img" class="sender-img">
                                            '.$user_online_status.'

                                    </div><!-- close sender-img-block -->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                                <span class="sender-name">
                                                '.$full_name.'
                                                </span><!-- close sender-name -->
                                                <span class="date-time">
                                                    '.$msg_time.'
                                                </span><!-- close date-time -->
                                        </div><!-- close user-name-date -->
                                        <div class="left-files">
                                            <img src="assets/img/'.$message.'" class="common-images">
                                        </div><!-- close left-msg -->
                                    </div><!-- close left-msg-area -->
                                </div><!-- close left message -->';

                    } elseif($msg_type == "png" || $msg_type == "PNG"){

                        echo '  <div class="left-message common-margin">
                                    <div class="sender-img-block">
                                            <img src="assets/img/'.$user_image.'" alt="sender-img" class="sender-img">
                                            '.$user_online_status.'

                                    </div><!-- close sender-img-block -->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                                <span class="sender-name">
                                                '.$full_name.'
                                                </span><!-- close sender-name -->
                                                <span class="date-time">
                                                    '.$msg_time.'
                                                </span><!-- close date-time -->
                                        </div><!-- close user-name-date -->
                                        <div class="left-files">
                                            <img src="assets/img/'.$message.'" class="common-images">
                                        </div><!-- close left-msg -->
                                    </div><!-- close left-msg-area -->
                                </div><!-- close left message -->';

                    } elseif($msg_type == "zip" || $msg_type == "ZIP"){

                        echo '  <div class="left-message common-margin">
                                    <div class="sender-img-block">
                                            <img src="assets/img/'.$user_image.'" alt="sender-img" class="sender-img">
                                            '.$user_online_status.'

                                    </div><!-- close sender-img-block -->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                                <span class="sender-name">
                                                '.$full_name.'
                                                </span><!-- close sender-name -->
                                                <span class="date-time">
                                                    '.$msg_time.'
                                                </span><!-- close date-time -->
                                        </div><!-- close user-name-date -->
                                        <div class="left-files">
                                            
                                            <a href="assets/img/'.$message.'" class="all-files"><i class="fas fa-arrow-circle-down files-common">
                                            </i>'.$message.'</a>

                                        </div><!-- close left-msg -->
                                    </div><!-- close left-msg-area -->
                                </div><!-- close left message -->';

                    } elseif($msg_type == "pdf" || $msg_type == "PDF"){

                        echo '  <div class="left-message common-margin">
                                    <div class="sender-img-block">
                                            <img src="assets/img/'.$user_image.'" alt="sender-img" class="sender-img">
                                            '.$user_online_status.'

                                    </div><!-- close sender-img-block -->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                                <span class="sender-name">
                                                '.$full_name.'
                                                </span><!-- close sender-name -->
                                                <span class="date-time">
                                                    '.$msg_time.'
                                                </span><!-- close date-time -->
                                        </div><!-- close user-name-date -->
                                        <div class="left-files">
                                            
                                        <a href="assets/img/'.$message.'" class="all-files" target="_blank"><i class="far fa-file-pdf files-common pdf">
                                        </i>'.$message.'</a>

                                        </div><!-- close left-msg -->
                                    </div><!-- close left-msg-area -->
                                </div><!-- close left message -->';

                    } elseif($msg_type == "emoji"){

                        echo '  <div class="left-message common-margin">
                                    <div class="sender-img-block">
                                            <img src="assets/img/'.$user_image.'" alt="sender-img" class="sender-img">
                                            '.$user_online_status.'

                                    </div><!-- close sender-img-block -->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                                <span class="sender-name">
                                                '.$full_name.'
                                                </span><!-- close sender-name -->
                                                <span class="date-time">
                                                    '.$msg_time.'
                                                </span><!-- close date-time -->
                                        </div><!-- close user-name-date -->
                                        <div class="left-files">

                                            <img src="'.$message.'" class="animated-emoji">

                                        </div><!-- close left-msg -->
                                    </div><!-- close left-msg-area -->
                                </div><!-- close left message -->';

                    } elseif($msg_type == "docx"){

                        echo '  <div class="left-message common-margin">
                                    <div class="sender-img-block">
                                            <img src="assets/img/'.$user_image.'" alt="sender-img" class="sender-img">
                                            '.$user_online_status.'

                                    </div><!-- close sender-img-block -->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                                <span class="sender-name">
                                                '.$full_name.'
                                                </span><!-- close sender-name -->
                                                <span class="date-time">
                                                    '.$msg_time.'
                                                </span><!-- close date-time -->
                                        </div><!-- close user-name-date -->
                                        <div class="left-files">
                                            
                                        <a href="assets/img/'.$message.'" class="all-files"><i class="far fa-file-word files-common word">
                                        </i>'.$message.'</a>

                                        </div><!-- close left-msg -->
                                    </div><!-- close left-msg-area -->
                                </div><!-- close left message -->';

                    } elseif($msg_type == "xlsx"){

                        echo '  <div class="left-message common-margin">
                                    <div class="sender-img-block">
                                            <img src="assets/img/'.$user_image.'" alt="sender-img" class="sender-img">
                                            '.$user_online_status.'

                                    </div><!-- close sender-img-block -->
                                    <div class="left-msg-area">
                                        <div class="user-name-date">
                                                <span class="sender-name">
                                                '.$full_name.'
                                                </span><!-- close sender-name -->
                                                <span class="date-time">
                                                    '.$msg_time.'
                                                </span><!-- close date-time -->
                                        </div><!-- close user-name-date -->
                                        <div class="left-files">
                                            
                                        <a href="assets/img/'.$message.'" class="all-files"><i class="far fa-file-excel files-common word">
                                        </i>'.$message.'</a>

                                        </div><!-- close left-msg -->
                                    </div><!-- close left-msg-area -->
                                </div><!-- close left message -->';

                    }
                }
    
            endforeach;
        }

    }
}