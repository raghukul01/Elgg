<?php
/**
 * Elgg owner block
 * Displays page ownership information
 *
 * @package Elgg
 * @subpackage Core
 *
 */

elgg_push_context('owner_block');

// groups and other users get owner block
$owner = elgg_get_page_owner_entity();
if ($owner instanceof ElggGroup || $owner instanceof ElggUser) {
	$header = elgg_view_entity($owner, ['full_view' => false]);

	$body = elgg_view_menu('owner_block', ['entity' => $owner]);

	$body .= elgg_view('page/elements/owner_block/extend', $vars);

	echo elgg_view('page/components/module', [
		'header' => $header,
		'body' => $body,
		'class' => 'elgg-owner-block',
	]);
}

elgg_pop_context();
