#!/usr/bin/env php
<?php

require __DIR__ . "/../../vendor/autoload.php";
$bench = new \Smuuf\Phpcb\PhpBenchmark(new \Smuuf\Phpcb\SerialEngine);

// Analyzing performance of possible mechanisms for expanding escape sequences
// performed inside StringValue class.
// Issue: https://github.com/smuuf/primi/pull/21

function originalFn(string $string) {
	return \str_replace('\n', "\n", $string);
}

function proposedFn(string $string) {
	$string = \str_replace('\\\\n', '__NEWLINE__', $string);
	$string = \str_replace('\n', "\n", $string);
	$string = \str_replace('__NEWLINE__', '\n', $string);
	return $string;
}

function regexverFn(string $string) {
	return preg_replace('#(?<!\\\\)\\\\n#', "\n", $string);
}

$strs = [
	'\n',
	'hello there',
	'\\n',
	'hello there,\nold chap',
	'\n\n',
	'hello there,\\nold chap',
	'\\n\\n',
	'Special relativity was originally proposed by Albert Einstein in a paper' .
	' published on 26 September 1905 titled "On the Electrodynamics of Moving' .
	' Bodies".\nThe incompatibility of Newtonian mechanics with Maxwell\'s eq' .
	'uations of electromagnetism and, experimentally, the Michelson-Morley nu' .
	'll result (and subsequent similar experiments) demonstrated that the his' .
	'torically hypothesized luminiferous aether did not exist.\nThis led to E' .
	'instein\'s development of special relativity, which corrects mechanics t' .
	'o handle situations involving all motions and especially those at a spee' .
	'd close to that of light (known as relativistic velocities).\nToday, spe' .
	'cial relativity is proven to be the most accurate model of motion at any' .
	' speed when gravitational effects are negligible. Even so, the Newtonian' .
	' model is still valid as a simple and accurate approximation at low velo' .
	'cities (relative to the speed of light), for example, the everyday motio' .
	'ns on Earth.',
];

$bench->addBench(function() use ($strs) {
	foreach ($strs as $s) {
		$res = originalFn($s);
	}
});

$bench->addBench(function() use ($strs) {
	foreach ($strs as $s) {
		$res = proposedFn($s);
	}
});

$bench->addBench(function() use ($strs) {
	foreach ($strs as $s) {
		$res = regexverFn($s);
	}
});

$bench->run(1e6);
