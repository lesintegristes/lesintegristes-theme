<?php
# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="alert">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<div id="comments" class="comments">
		<div class="comments-top">
			<h2 class="comments-count"><?php comments_number('<strong><span>0</span></strong> <span>commentaires</span>', '<strong><span>1</span></strong> <span>commentaire</span>', '<strong><span>%</span></strong> <span>commentaires</span>'); ?></h2>
			<?php if (comments_open()): ?>
			<p class="post-comment"><a href="#respond" class="button"><span><span><span>Poster un commentaire</span></span></span></a></p>
				<?php endif; ?>
		</div>
		<p class="rss"><?php echo lesintegristes_get_feed_link(get_post_comments_feed_link( $post->ID, "rss2" ), "Flux RSS des commentaires de cet article"); ?></p>
		<?php if ( have_comments() ) : ?>
			<?php foreach ($comments as $comment): ?>
			<?php
				$comment_class_attribute = '';
				$comment_classes = '';
				if ( $comment->user_id > 0 ) {
					$comment_classes .= " blog-author";
				}
				if ( $comment->user_id === $post->post_author ) {
					$comment_classes .= " post-author";
				}
				if ( $comment->comment_type === "trackback" ) {
					$comment_classes .= " trackback";
				}

				if ($comment_classes !== '') {
					$comment_class_attribute = ' class="'. $comment_classes .'"';
				}
			?>
			<article id="comment-<?php comment_ID() ?>"<?php echo $comment_class_attribute ?>>
				<div class="avatar">
					<?php
						$cur_author_url = get_comment_author_url();
						if ($cur_author_url !== "") { ?><a title="<?php echo get_comment_author() ?>" href="<?php echo get_comment_author_url() ?>"><?php }
						echo get_avatar( $comment->comment_author_email, $size = '43', $default = get_bloginfo('template_url') . '/images/gravatar.png' );
						if ($cur_author_url !== "") { ?></a><?php }
					?>
				</div>
				<?php comment_text(); ?>
				<p class="metas"><a href="#comment-<?php comment_ID() ?>">Le <strong><?php echo comment_date("d M. Y") ?></strong> à <strong><?php echo comment_date("H\hi") ?></a></strong> par <strong><?php echo get_comment_author_link(); ?></strong><?php edit_comment_link("Modifier le commentaire", ". ", ".") ?></p>
			</article>
			<?php endforeach; ?>

		<?php else : // pas encore de commentaires ?>

		<?php endif; ?>

	<?php
	/* Pagination */
	/* <p class="comments-pagination"><?php previous_comments_link() ?> | <?php next_comments_link() ?></p> */
	?>
</div>



<div id="respond">

<?php if ( comments_open() ) : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

		<p>
			Publiez un commentaire en remplissant les champs ci-dessous.<br />
			Les champs marqués d'une astérisque (*) sont obligatoires.
		</p>

		<?php if ( is_user_logged_in() ) : ?>

		<p>Vous n'êtes pas <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php" class="action"><?php echo $user_identity; ?></a> ? <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Déconnexion" class="action">Déconnectez-vous</a>.</p>

		<?php else : ?>

		<p>
			<label for="author">Nom*</label>
			<input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" <?php if ($req) echo "aria-required='true'"; ?> />
		</p>

		<p>
			<label for="email">Mail* (non publié)</label>
			<input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" <?php if ($req) echo "aria-required='true'"; ?> />
		</p>

		<p>
			<label for="url">Site web</label>
			<input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" />
		</p>

		<?php endif; ?>

		<p class="comment">
			<label for="comment">Commentaire*</label>
			<textarea name="comment" id="comment" cols="70" rows="15"></textarea>
		</p>

		<p class="html-help"><span>Les commentaires peuvent utiliser <strong>HTML</strong>&nbsp;; seuls ces éléments sont autorisés&nbsp;: <code><?php echo allowed_tags(); ?></code></span></p>

		<?php do_action('comment_form', $post->ID); ?>

		<p class="submit"><button type="submit"><span><span>Publier le commentaire</span></span></button></p>

		<?php comment_id_fields(); ?>

	</form>
<?php else : // Commentaires fermés ?>
	<p class="no-comments">Les commentaires sont fermés sur cet article.</p>
<?php endif; ?>

</div>