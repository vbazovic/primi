<?php

namespace Smuuf\Primi\Handlers;

use \Smuuf\Primi\Context;
use \Smuuf\Primi\Helpers\SimpleHandler;
use \Smuuf\Primi\Structures\RegexValue;

class RegexLiteral extends SimpleHandler {

	public static function handle(array $node, Context $context) {

		$content = $node['core']['text'];

		// Trim slashes from the start and the end using substr().
		// Using trim("/", ...) would make /abc\// into abc\ instead of abc\/,
		// so do this a little more directly.
		$content = \mb_substr($content, 1, \mb_strlen($content) - 2);

		return new RegexValue($content);

	}

}
