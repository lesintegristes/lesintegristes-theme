<?php
/*
Template Name: Auteurs
*/
wpcf7_enqueue_styles();
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
				<p class="photo"><img src="http://lesintegristes.dev/wp-content/uploads/2009/11/auteur-photo.jpg" alt="" width="120" height="150" /></p>
				<p>Il y a quelques années, Éric a courageusement pris la décision de consacrer toute son énergie à la réalisation d'interfaces web de <em>qualité</em>. Après avoir vaincu Internet Explorer et intégré l'inintégrable, il est parti à la recherche de nouveaux défis&nbsp;: l'accessibilité et l'expérience utilisateur pour le web. Il est diplomé <a href="http://www.accessiweb.org/">Expert Accessiweb</a>, et a atteint le rang de Grand Chevalier de l'Ergonomie sur le Web, distinction qu'il n'a malheureusement jamais voulu reconnaître. Éric est aujourd'hui responsable du pôle intégration chez Pixmania, et apporte son expérience à l'ensemble des projets du groupe.</p>
				<p class="desc-author"><em>Par Pierre Bertet.</em></p>
				<ul class="links">
					<li class="home"><a href="http://from-scratch.pro/" class="action">from-scratch.pro</a></li>
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
				<p class="photo"><img src="http://lesintegristes.dev/wp-content/uploads/2009/11/auteur-photo.jpg" alt="" width="120" height="150" /></p>
				<p>Qu’est-ce qui fait qu’une interface est agréable à utiliser ? Qu’elle soit intuitive, claire, que le regroupement des catégories soit logique, que les risques d’erreurs soit limités, que les messages d’information soient clairs ? Tout ça et bien d’autres choses encore. Je voudrais aujourd’hui parler plus particulièrement des boutons d’actions que ce soit des boutons de validation de formulaire ou des liens de navigations. En général et dans la plupart des sites professionnels il sont particulièrement mis en valeur (avec plus ou moins de succès).</p>
				<ul class="links">
					<li class="home"><a href="http://www.pierrebertet.net" class="action">www.pierrebertet.net</a></li>
					<li class="twitter"><a href="http://twitter.com/bpierre" class="action">twitter.com/bpierre</a></li>
				</ul>
				<p class="mail">Contacter Pierre : <a href="mailto:bonjour@pierrebertet.net" class="action">bonjour@pierrebertet.net</a></p>
			</div>
		</section>
		
		<p class="invitation"><strong>Les Intégristes est un blog ouvert à tous,<br /> n’hésitez pas à nous contacter<br /> pour participer à sa rédaction. :)</strong></p>
		
		<section class="contact">
			<h1>Contactez-nous&nbsp;!</h1>
			<?php the_content(); ?>
		</section>
		<script type="text/javascript">jQuery("section.contact span.wpcf7-not-valid-tip-no-ajax").closest("p").addClass("error");</script>
	<?php endwhile; endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>