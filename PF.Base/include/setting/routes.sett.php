<?php

return [
	// Activity Feed
	'/api/feed' => [
		'call' => '\Api\Feed'
	],
	'/api/feed/:id' => [
		'call' => '\Api\Feed',
		'where' => [
			':id' => '([0-9]+)'
		]
	],

	// User
	'/api/user' => [
		'call' => '\Api\User'
	],
	'/api/user/:id' => [
		'call' => '\Api\User',
		'where' => [
			':id' => '([0-9]+)'
		]
	],

	// Like
	'/api/like/:id' => [
		'call' => '\Api\Like',
		'where' => [
			':id' => '([0-9]+)'
		]
	],

	// Comment
	'/api/comment' => [
		'call' => '\Api\Comment'
	],
	'/api/comment/:id' => [
		'call' => '\Api\Comment',
		'where' => [
			':id' => '([0-9]+)'
		]
	],

	// Message
	'/api/message' => [
		'call' => '\Api\Message'
	],
	'/api/message/:id' => [
		'call' => '\Api\Message',
		'where' => [
			':id' => '([0-9]+)'
		]
	],
	'/api/message/thread/:id' => [
		'call' => '\Api\Message\Thread',
		'where' => [
			':id' => '([0-9]+)'
		]
	]
];