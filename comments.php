<?php
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="mt-12">
    <?php if ( have_comments() ) : ?>
        <h2 class="text-2xl font-semibold mb-6">
            <?php
            $count = get_comments_number();
            if ( $count === 1 ) {
                echo "1 Comment";
            } else {
                echo "$count Comments";
            }
            ?>
        </h2>

        <ol class="space-y-4">
            <?php
            wp_list_comments([
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 48,
                'callback'    => function( $comment, $args, $depth ) {
                    $GLOBALS['comment'] = $comment;
                    ?>
                    <li <?php comment_class("bg-white/5 backdrop-blur-sm border border-gray-200 p-4 rounded-xl"); ?> id="comment-<?php comment_ID(); ?>">
                        <div class="flex items-start gap-4">
                            <?php echo get_avatar( $comment, 48, '', '', ['class'=>'w-12 h-12 rounded-full'] ); ?>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-lg"><?php comment_author(); ?></span>
                                    <span class="text-gray-600 text-sm"><?php comment_date(); ?> <?php comment_time(); ?></span>
                                </div>
                                <div class="mt-2 text-gray-600 text-lg">
                                    <?php comment_text(); ?>
                                </div>
                                <div class="mt-2">
                                    <?php comment_reply_link(array_merge($args, [
                                        'depth' => $depth,
                                        'max_depth' => $args['max_depth'],
                                        'class' => 'text-[var(--color-links)] hover:underline text-sm font-semibold'
                                    ])); ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                }
            ]);
            ?>
        </ol>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <nav class="mt-6 flex justify-between text-purple-400 font-semibold">
                <div class="previous"><?php previous_comments_link('&larr; Older Comments'); ?></div>
                <div class="next"><?php next_comments_link('Newer Comments &rarr;'); ?></div>
            </nav>
        <?php endif; ?>

    <?php endif; ?>

    <?php
    $comment_args = [
        'class_form' => 'mt-8 space-y-4',
        'fields' => [
            'author' => '<input type="text" name="author" placeholder="Name*" required class="w-full p-3 rounded-lg border border-gray-300"/>',
            'email'  => '<input type="email" name="email" placeholder="Email*" required class="w-full p-3 rounded-lg border border-gray-300"/>',
            'url'    => '<input type="url" name="url" placeholder="Website" class="w-full p-3 rounded-lg border border-gray-300"/>',
        ],
        'comment_field' => '<textarea name="comment" placeholder="Your Comment*" required class="w-full p-3 rounded-lg border border-gray-300"></textarea>',
        'class_submit' => 'bg-purple-400 text-white py-2 px-6 rounded-lg hover:bg-purple-500 transition-colors',
        'label_submit' => 'Post Comment',
    ];
    comment_form($comment_args);
    ?>
</div>
