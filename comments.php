        <!-- Za komentare -->    
        <div class="spacing">
            <ul class="media-list">
                <?php   //Uzmi komentae za ovaj članak
                $comments = get_comments(array(
                    'post_id' => get_the_ID(),
                    'status' => 'approve' //Samo oni koji su odobreni
                ));
                
                /* Prikaži listu komentara */
                wp_list_comments(array(
                    'type' => 'comment',
                    'callback' => 'wpb3_comment',
                    'reverse_top_level' => false //Prikaži najnovije komentare prije
                ), $comments); ?>
            </ul>
            
            
            <?php
            
                        /* Omogućavanje unosa emaila i imena */
            $commenter = wp_get_current_commenter();
            $req = get_option( 'require_name_email' );
            $aria_req = ( $req ? " aria-required='true'" : '' );
            
            $polja = array(
                'author' => '<div class="form-group"><label for="author">' . __('Name')
                . ( $req ? '<span class="required">*</span>' : '' ) . '</label>'
                . '<input id="author" name="author" class="form-control" placeholder="your name" type="text" value"'
                . esc_attr( $commenter['comment_author']) . '" size="30"' . $aria_req . ' /></div>',
                'email' => '<div class="form-group"><label for="email">' . __('Email')
                . ( $req ? '<span class="required">*</span>' : '' ) . '</label>'
                . '<input id="email" name="email" class="form-control" placeholder="email@example.com" type="text" value"'
                . esc_attr( $commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></div>',
            );
            
            $comments_args = array(
                'fields' => $polja,
                'label_submit' => 'Comment',                    //change the title of send button
                'title_reply' => 'Write a Reply or Comment',    //Change the title of the reply section
                'comments_notes_after' => '',               //Remove "Text or HTML to be displayed after hte set of comment fields"
                'comment_field' => '<p class="comment-form-comment">'
                . '<label for="comment">' . _x('Comment', 'noun') . '</label><br />'
                . '<textarea id="comment" name="comment" class="form-control" aria-required="true"></textarea>'
                . '</p>'
            );
            
            comment_form($comments_args); 
           
            
            ?>
        </div>