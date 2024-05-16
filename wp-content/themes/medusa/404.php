<?php
// Load Timber context
$context = Timber::context();

// Set the 404 page title and message
$context['title'] = 'Page Not Found';
$context['message'] = 'Sorry, but the page you are looking for does not exist.';

// Render the 404 Twig template
Timber::render('404.twig', $context);
?>
