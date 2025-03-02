<?php

/**
 * Construit un élément HTML, ex: `<div ...> ... </div>`
 */
function element(string $tagName, array $attrs = [], string $children = ""): string
{
	$render = elementStart($tagName, $attrs);
	$render .= $children;
	$render .= elementEnd($tagName);
	return $render;
}

/**
 * Construit le début d'un élément HTML, ex: `<div ...>`
 */
function elementStart(string $tagName, array $attrs = []): string
{
	return '<' . htmlspecialchars($tagName) . ' ' .attributes($attrs) . '>';
}

/**
 * Construit la fin d'un élément HTML, ex: `</div>`
 */
function elementEnd(string $tagName): string
{
	return '</' . htmlspecialchars($tagName) . '>';
}

/**
 * Construit un élément vide, ex: `<input ....>`
 */
function voidElement(string $tagName, array $attrs = []): string
{
	return elementStart($tagName, $attrs);
}

/**
 * Construit les attributs d'un élément HTML, ex: `name="x" placeholder="y"`.
 */
function attributes(array $attrs): string
{
	$str = "";

	foreach ($attrs as $attrName => $attrValue) {
		if (is_bool($attrValue)) {
			if ($attrValue) {
				// ex: name
				$str .= htmlspecialchars($attrName);
				$str .= ' ';
			}

			continue;
		}

		// ex: name="value"
		$str .= htmlspecialchars($attrName) . '=';
		$str .= '"' . htmlspecialchars($attrValue) . '"';
		$str .= ' ';
	}

	// ex: 'name1="value1" name2="value2"'
	return trim($str);
}

/**
 * Construit un élément avec une icône en SVG en contenu.
 */
function icon(string $tagName, string $iconName, array $attrs = []): string
{
	ob_start();
	include "./assets/svg/$iconName.svg";
	$svg = ob_get_clean();
	return element($tagName, $attrs, $svg);
}
