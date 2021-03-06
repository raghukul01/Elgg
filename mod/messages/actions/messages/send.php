<?php
/**
* Ssend a message action
*
* @package ElggMessages
*/

$subject = strip_tags(get_input('subject'));
$body = get_input('body');
$recipients = (array) get_input('recipients');
$original_msg_guid = (int) get_input('original_guid');

elgg_make_sticky_form('messages');

if (empty($recipients)) {
	register_error(elgg_echo("messages:user:blank"));
	forward("messages/compose");
}

$recipient = (int) elgg_extract(0, $recipients);
if ($recipient == elgg_get_logged_in_user_guid()) {
	register_error(elgg_echo("messages:user:self"));
	forward("messages/compose");
}

$user = get_user($recipient);
if (!$user) {
	register_error(elgg_echo("messages:user:nonexist"));
	forward("messages/compose");
}

// Make sure the message field, send to field and title are not blank
if (!$body || !$subject) {
	register_error(elgg_echo("messages:blank"));
	forward("messages/compose");
}

// Otherwise, 'send' the message
$result = messages_send($subject, $body, $user->guid, 0, $original_msg_guid);

// Save 'send' the message
if (!$result) {
	register_error(elgg_echo("messages:error"));
	forward("messages/compose");
}

elgg_clear_sticky_form('messages');
	
system_message(elgg_echo("messages:posted"));

forward('messages/inbox/' . elgg_get_logged_in_user_entity()->username);
