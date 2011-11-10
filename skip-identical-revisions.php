<?php
/*
Plugin Name: Skip Identical Revisions
Plugin URI: http://studioanino.com/
Description: Disables saving a post revision if the title, content and excerpt fields are all unmodified.
Author: John B. Fakorede
Author URI: http://studioanino.com/
Version: 1.0
License: GPL
Notes:
	* To-do: Add revision-related message to save notification
	* To-do: Workaround for visual editor auto-formatting when saving poorly indented, fully marked-up content
*/


// Disable built-in wp_save_post_revision()
remove_action('pre_post_update', 'wp_save_post_revision', 10);


/**
 * Collects new post data prior to post update and makes it available for global use.
 *
 * @param array $data Elements that make up post to insert.
 * @param array $postarr Elements that make up post to insert.
 * @global array $studioanino_newpost Post object holding new post fields.
 * @return array Post object holding new post fields.
**/
function studioanino_insert_post_data($data, $postarr) {
	global $studioanino_newpost;
	$studioanino_newpost = $data;
	return $data;
}
add_filter('wp_insert_post_data', 'studioanino_insert_post_data', 10, 2);


/**
 * Saves an already existing post as a post revision.
 *
 * Typically used immediately prior to post updates.
 *
 * Replaces built-in wp_save_post_revision()
 *
 * @uses $studioanino_newpost
 * @uses _wp_put_post_revision()
 *
 * @param int $post_id The ID of the post to save as a revision.
 * @global array $studioanino_newpost Post object holding new post fields.
 * @return mixed Null or 0 if error, new revision ID, if success.
**/
function studioanino_save_post_revision($post_id) {
	// We do autosaves manually with wp_create_post_autosave()
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	// WP_POST_REVISIONS = 0, false
	if ( ! WP_POST_REVISIONS )
		return;

	if ( !$post = get_post( $post_id, ARRAY_A ) )
		return;

	if ( !post_type_supports($post['post_type'], 'revisions') )
		return;
	
	// Compare post_title, post_content and post_excerpt
	global $studioanino_newpost;
	$studioanino_newpost = stripslashes_deep($studioanino_newpost);
	if ( $studioanino_newpost['post_title'] === $post['post_title'] && $studioanino_newpost['post_content'] === $post['post_content'] && $studioanino_newpost['post_excerpt'] === $post['post_excerpt'] )
		return;
	
	// Resume revision save process
	$return = _wp_put_post_revision( $post );

	// WP_POST_REVISIONS = true (default), -1
	if ( !is_numeric( WP_POST_REVISIONS ) || WP_POST_REVISIONS < 0 )
		return $return;

	// all revisions and (possibly) one autosave
	$revisions = wp_get_post_revisions( $post_id, array( 'order' => 'ASC' ) );

	// WP_POST_REVISIONS = (int) (# of autosaves to save)
	$delete = count($revisions) - WP_POST_REVISIONS;

	if ( $delete < 1 )
		return $return;

	$revisions = array_slice( $revisions, 0, $delete );

	for ( $i = 0; isset($revisions[$i]); $i++ ) {
		if ( false !== strpos( $revisions[$i]->post_name, 'autosave' ) )
			continue;
		wp_delete_post_revision( $revisions[$i]->ID );
	}

	return $return;
}
add_action('pre_post_update', 'studioanino_save_post_revision', 10);