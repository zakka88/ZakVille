<?php

/**
 * Vérifie si les valeurs des champs de formulaires vides ou non. Dès qu'un
 * champ est vide, un retour true est renvoyé. Dans le cas où toutes les valeurs
 * ne sont pas vide, un retour false est renvoyé.
 */
function isEmptyForm(array $fields, array $ignoreFields = []): bool
{
	foreach ($fields as $field) {
		if (in_array($field, $ignoreFields)) {
			continue;
		}

		if (is_array($_POST[$field]) && empty($_POST[$field])) {
			return true;
		}

		if (empty(trim($_POST[$field]))) {
			return true;
		}
	}
	return false;
}

function inputValue(string $field): string
{
	return isset($_POST[$field]) ? htmlspecialchars($_POST[$field]) : "";
}

function input(
	string $name,
	array $attrs = [],
	array $props = [],
): string {
	$render = '<div class="input-container">';

	if (isset($props["icon-left"])):
		$render .= labelIcon($name, $props["icon-left"]);
	endif;

	$attrs["id"] = $name;
	$attrs["name"] = $name;

	$render .= '<input ' . attributes($attrs) . '>';

	if (isset($props["icon-right"])):
		$iconName = $props["icon-right"];

		$render .= '<span>';
		ob_start();
		include "./assets/svg/$iconName.svg";
		$svg = ob_get_clean();
		$render .= $svg;
		$render .= '</span>';
	endif;

	$render .= '</div>';

	return $render;
}

function label(string $htmlFor, string $slot, array $attrs = []): string {
	$attrs["for"] = $htmlFor;
	$render = '<label ' . attributes($attrs) . '>';
	$render .= $slot;
	$render .= '</label>';
	return $render;
}

function labelIcon(
	string $htmlFor,
	string $iconName,
	array $attrs = [],
	array $props = [],
): string {
	ob_start();
	include "./assets/svg/$iconName.svg";
	$svg = ob_get_clean();
	return label($htmlFor, $svg, $attrs);
}

function select(
	string $name,
	array $attrs = [],
	array $props = [],
): string {
	$render = '<div class="input-container">';

	if (isset($props["icon-left"])):
		$render .= labelIcon($name, $props["icon-left"]);
	endif;

	$attrs["id"] = $name;
	$attrs["name"] = $name;

	$placeholder = isset($props["placeholder"]) ? $props["placeholder"] : "";
	$options = $props["options"] ?: [];

	$render .= '<select ' . attributes($attrs) . '>';


	if (isset($props["default-group"])) {
		$render .= '<option hidden selected>';
		$render .= htmlspecialchars($placeholder);
		$render .= '</option>';

		$render .= '<optgroup label="';
		$render .= htmlspecialchars($placeholder);
		$render .= '">';
	}

	foreach ($options as $value => $text) {
		$render .= '<option value="';
		$render .= htmlspecialchars($value);
		$render .= '"';
		$render .= '>';

		$render .= htmlspecialchars($text);
		$render .= '</option>';
	}

	if (isset($props["default-group"])) {
		$render .= "</optgroup>";
	}

	$render .= '</select>';

	if (isset($props["icon-right"])):
		$iconName = $props["icon-right"];

		$render .= '<span>';
		ob_start();
		include "./assets/svg/$iconName.svg";
		$svg = ob_get_clean();
		$render .= $svg;
		$render .= '</span>';
	endif;

	$render .= '</div>';
	return $render;
}

function attributes(array $attrs): string
{
	$str = "";

	foreach ($attrs as $attrName => $attrValue) {
		if (is_bool($attrValue)) {
			if ($attrValue) {
				$str .= $attrName;
				$str .= " ";
			}

			continue;
		} else {
			$str .= "$attrName=";
		}

		$str .= '"';
		$str .= htmlspecialchars($attrValue);
		$str .= '"';
		$str .= " ";
	}

	return trim($str);
}
