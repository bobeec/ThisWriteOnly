<?php
/**
 * Comments Template
 *
 * @package BLOGthemeWP
 */

// Prevent direct access
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
            $blogthemewp_comment_count = get_comments_number();
            printf(
                /* translators: %s: comment count */
                esc_html( _n( '%s件のコメント', '%s件のコメント', $blogthemewp_comment_count, 'blogthemewp' ) ),
                number_format_i18n( $blogthemewp_comment_count )
            );
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'callback'    => 'blogthemewp_comment_callback',
                'avatar_size' => 40,
            ) );
            ?>
        </ol>

        <?php
        the_comments_navigation( array(
            'prev_text' => __( '古いコメント', 'blogthemewp' ),
            'next_text' => __( '新しいコメント', 'blogthemewp' ),
        ) );
        ?>

        <?php if ( ! comments_open() ) : ?>
            <p class="no-comments"><?php esc_html_e( 'コメントは受け付けていません。', 'blogthemewp' ); ?></p>
        <?php endif; ?>

    <?php endif; ?>

    <?php
    comment_form( array(
        'title_reply'          => __( 'コメントを残す', 'blogthemewp' ),
        'title_reply_to'       => __( '%sへの返信', 'blogthemewp' ),
        'cancel_reply_link'    => __( 'キャンセル', 'blogthemewp' ),
        'label_submit'         => __( 'コメントを送信', 'blogthemewp' ),
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . __( 'コメント', 'blogthemewp' ) . '</label><textarea id="comment" name="comment" cols="45" rows="6" required></textarea></p>',
    ) );
    ?>

</div><!-- #comments -->
