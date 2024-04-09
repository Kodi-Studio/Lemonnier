<?php

declare(strict_types=1);

/**
 * Project: wordpress-skeleton-theme
 * 
 * @author Thilo Ratnaweera <thilo.ratnaweera@netbrothers.de>
 * @copyright © 2024 NetBrothers GmbH.
 * @license GPLv3
 * @todo search results
 */

$searchQuery = sprintf('<span>%s</span>', get_search_query());

// Récupérer les résultats de recherche
$searchResults = new WP_Query(array(
    's' => get_search_query(),
    'post_type' => 'post', // Vous pouvez spécifier ici les types de post à rechercher
    'post_status' => 'publish' // Rechercher uniquement les posts publiés
));

?>
<p>@todo search.php</p>
<h2><?php printf(__('Search Results for: %s'), $searchQuery); ?></h2>

<?php if ($searchResults->have_posts()) : ?>
    <ul>
        <?php while ($searchResults->have_posts()) : $searchResults->the_post(); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php endwhile; ?>
    </ul>
<?php else : ?>
    <p><?php _e('No results found.'); ?></p>
<?php endif; ?>

<?php get_search_form(); ?>
