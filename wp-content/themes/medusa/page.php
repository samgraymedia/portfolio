<?php
// Get the Timber context
$context = Timber::context();
// Get the current post
$context['post'] = new Timber\Post();

// Render the Twig template
Timber::render('page.twig', $context);
?>
