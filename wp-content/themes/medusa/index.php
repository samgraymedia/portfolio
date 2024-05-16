<?php
// Load Timber context
$context = Timber::context();

// Get posts
$context['posts'] = new Timber\PostQuery();

// Render the Twig template
Timber::render('index.twig', $context);
?>
