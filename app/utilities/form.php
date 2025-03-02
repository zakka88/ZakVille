<?php

/**
 * Vérifie si les valeurs des champs de formulaires vides ou non. Dès qu'un
 * champ est vide, un retour true est renvoyé. Dans le cas où toutes les valeurs
 * ne sont pas vide, un retour false est renvoyé.
 */
function isEmptyForm(array $fields, array $ignoreFields = []): bool
{
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}

	foreach ($fields as $field) {
		$_SESSION["form.inputs.$field"] = $_POST[$field];
	}

	foreach ($fields as $field) {
		if (in_array($field, $ignoreFields)) {
			continue;
		}

		if (is_array($_POST[$field])) {
			if (empty($_POST[$field])) {
				return true;
			}
		} else if (empty(trim($_POST[$field]))) {
			return true;
		}
	}
	return false;
}

function inputValue(string $field): string
{
	if (isset($_SESSION["form.inputs.$field"])) {
		$value = $_SESSION["form.inputs.$field"];
		unset($_SESSION["form.inputs.$field"]);
		return attributes(["value" => $value]);
	}
	return "";
}

/**
 * Construit un élément ```
 *   <div class="input-container">
 *      <label for="..."> <svg ... /> </label>
 *      <input name"..." ... />
 *      <span> <svg ... /> </span>
 *   </div>
 * ``` en fonction des arguments passés.
 */
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

	if (!isset($attrs["aria-label"]) && isset($attrs["placeholder"])) {
		$attrs["aria-label"] = $attrs["placeholder"];
	}

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

/**
 * Construit un élément ```
 *   <label for="..."> ... </label>
 * ``` en fonction des arguments passés.
 */
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

/**
 * Construit un élément ```
 *   <div class="input-container">
 *      <label for="..."> <svg ... /> </label>
 *      <select name"..." ...>
 * 	       ...
 *      </select>
 *      <span> <svg ... /> </span>
 *   </div>
 * ``` en fonction des arguments passés.
 */
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

/**
 * Construit les attributs d'un élément HTML.
 */
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

		$str .= '"' . htmlspecialchars($attrValue) . '"';
		$str .= " ";
	}

	return trim($str);
}
