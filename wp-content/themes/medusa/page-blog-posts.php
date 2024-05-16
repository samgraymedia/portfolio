<?php
/**
 * Template Name: Blog Posts Page
 */

use Timber\Timber;
use Timber\PostQuery;



// Load Timber context
$context = Timber::context();

// Get the posts of custom post type 'blog_post'
$context['posts'] = new PostQuery(array(
    'post_type' => 'blog_post',
    'posts_per_page' => -1, // Change this to limit the number of posts displayed
));

// Set the title for the page
$context['title'] = 'Blog Posts';

// Render the Twig template
Timber::render('page-blog-posts.twig', $context);

