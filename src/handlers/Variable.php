<?php

namespace Smuuf\Primi\Handlers;

use \Smuuf\Primi\HandlerFactory;
use \Smuuf\Primi\Context;

class Variable extends \Smuuf\Primi\Object implements IHandler {

	public static function handle(array $node, Context $context) {

		if (isset($node['pre']) || isset($node['post'])) {
			return UnaryOperator::handle($node, $context);
		}

		$variableName = HandlerFactory
			::get($node['core']['name'])
			::handle($node['core'], $context);

		return $context->getVariable($variableName);

	}

}
