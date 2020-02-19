<?php

namespace Smuuf\Primi\Handlers;

use \Smuuf\Primi\Context;
use \Smuuf\Primi\HandlerFactory;
use \Smuuf\Primi\Structures\Value;
use \Smuuf\Primi\Helpers\ChainedHandler;

class Chain extends ChainedHandler {

	public static function chain(
		array $node,
		Context $context,
		Value $subject
	) {

		// Handle the item; pass in the origin subject.
		$handler = HandlerFactory::get($node['core']['name']);
		$value = $handler::chain($node['core'], $context, $subject);

		// If there's chain, handle it, too.
		if (isset($node['chain'])) {
			$handler = HandlerFactory::get($node['chain']['name']);
			return $handler::chain($node['chain'], $context, $value);
		}

		return $value;

	}

}
