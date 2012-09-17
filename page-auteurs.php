<?php
/*
Template Name: Auteurs
*/

# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }

require_once ABSPATH . 'wp-admin/includes/plugin.php';

if (function_exists('wpcf7_enqueue_styles')) {
	wpcf7_enqueue_styles();
}
get_header();
?>

<div id="content" role="main" class="page-auteurs">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><?php the_title(); ?></h1>

		<section class="author">
			<header>
				<h1>Éric Le Bihan</h1>
				<h2>Responsable intégration web</h2>
			</header>
			<div class="content">
				<p class="photo photo-author"><img src="http://0.gravatar.com/avatar/17fc96622170237e61d15e34de93faf5?size=120" alt="" width="115" height="115" /></p>
				<p>Il y a quelques années, Éric a courageusement pris la décision de consacrer toute son énergie à la réalisation d'interfaces web de <em>qualité</em>. Après avoir vaincu Internet Explorer et intégré l'inintégrable, il est parti à la recherche de nouveaux défis&nbsp;: l'accessibilité et l'expérience utilisateur pour le web. Il est diplomé <a href="http://www.accessiweb.org/">Expert Accessiweb</a>, et a atteint le rang de Grand Chevalier de l'Ergonomie sur le Web, distinction qu'il n'a malheureusement jamais voulu reconnaître. Éric est aujourd'hui responsable du pôle intégration chez Pixmania, et apporte son expérience à l'ensemble des projets du groupe.</p>
				<p class="desc-author"><em>Par Pierre Bertet.</em></p>
				<ul class="links">
					<li class="home"><a href="http://www.ericlebihan.net" class="action">ericlebihan.net</a></li>
					<li class="twitter"><a href="http://twitter.com/ericlebihan" class="action">twitter.com/ericlebihan</a></li>
				</ul>
				<p class="mail">Contacter Éric : <a href="mailto:eric.ericlebihan@gmail.com" class="action">eric.ericlebihan@gmail.com</a></p>
			</div>
		</section>

		<section class="author">
			<header>
				<h1>Pierre Bertet</h1>
				<h2>Intégrateur web</h2>
			</header>
			<div class="content">
				<p class="photo"><img src="http://www.lesintegristes.net/wp-content/uploads/2009/11/auteur-photo.jpg" alt="" width="120" height="150" /></p>
				<p>Piru Berute (ピル ベルテ) comme l'appellent les Japonais, n'épargne pas sa peine dans la voie qu'il s'est tracée : non content de se lancer dans des entreprises de tout ordre comme travailler sur une multitude de projets open source, il a décidé de se mettre à son compte et de ridiculiser ses concurrents, même si sa modestie légendaire lui interdit de se vanter d'être un des meilleurs intégrateurs actuels. Si vous ajoutez à ça qu'il fait maintenant partie du <a href="http://www.accessiweb.org/fr/groupe_travail_accessibilite_du_web/">GTA</a>, on se demande quand ce mec prend le temps de dormir ! Il faut souligner que l'intégration du nouveau thème des intégristes, c'est lui&nbsp;!</p>
				<p class="desc-author"><em>Par Éric Le Bihan.</em></p>
				<ul class="links">
					<li class="home"><a href="http://www.pierrebertet.net" class="action">www.pierrebertet.net</a></li>
					<li class="twitter"><a href="http://twitter.com/bpierre" class="action">twitter.com/bpierre</a></li>
				</ul>
				<p class="mail">Contacter Pierre : <a href="mailto:bonjour@pierrebertet.net" class="action">bonjour@pierrebertet.net</a></p>
			</div>
		</section>

		<?php if (is_plugin_active('contact-form-7/wp-contact-form-7.php')): ?>
		<p class="invitation"><strong>Les Intégristes est un blog ouvert à tous,<br /> n’hésitez pas à nous contacter<br /> pour participer à sa rédaction. :)</strong></p>
		<section class="contact">
			<h1>Contactez-nous&nbsp;!</h1>
			<?php the_content(); ?>
		</section>
		<script type="text/javascript">jQuery("section.contact span.wpcf7-not-valid-tip-no-ajax").closest("p").addClass("error");</script>
		<?php endif; ?>
	<?php endwhile; endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>