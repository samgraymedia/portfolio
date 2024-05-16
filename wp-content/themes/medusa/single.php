<?php
// Load Timber context
$context = Timber::context();

// Get the current post
$context['post'] = Timber::get_post();

// Render the Twig template
Timber::render('single.twig', $context);
?>
