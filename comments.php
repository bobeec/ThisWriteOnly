<?php
/**
 * Comments Template
 *
 * @package ThisWriteOnly
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
            $thiswriteonly_comment_count = get_comments_number();
            printf(
                /* translators: %s: comment count */
                esc_html( _n( '%s Comment', '%s Comments', $thiswriteonly_comment_count, 'thiswriteonly' ) ),
                number_format_i18n( $thiswriteonly_comment_count )
            );
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 40,
            ) );
            ?>
        </ol>

        <?php
        the_comments_navigation( array(
            'prev_text' => __( 'Older Comments', 'thiswriteonly' ),
            'next_text' => __( 'Newer Comments', 'thiswriteonly' ),
        ) );
        ?>

        <?php if ( ! comments_open() ) : ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'thiswriteonly' ); ?></p>
        <?php endif; ?>

    <?php endif; ?>

    <?php
    comment_form( array(
        'title_reply'          => __( 'Leave a Comment', 'thiswriteonly' ),
        'title_reply_to'       => __( 'Reply to %s', 'thiswriteonly' ),
        'cancel_reply_link'    => __( 'Cancel', 'thiswriteonly' ),
        'label_submit'         => __( 'Submit Comment', 'thiswriteonly' ),
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . __( 'Comment', 'thiswriteonly' ) . '</label><textarea id="comment" name="comment" cols="45" rows="6" required></textarea></p>',
    ) );
    ?>

</div><!-- #comments -->
