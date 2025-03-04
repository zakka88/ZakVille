<?php

require_once __DIR__ . "/element.php";

/**
 * Vérifie si les valeurs des champs de formulaires vides ou non. Dès qu'un
 * champ est vide, un retour true est renvoyé. Dans le cas où toutes les valeurs
 * ne sont pas vide, un retour false est renvoyé.
 *
 * Cette fonction inclue des choses que l'on n'a pas vu :
 *
 * - https://www.php.net/manual/en/function.in-array.php
 * - https://www.php.net/manual/en/function.is-array.php
 * - https://www.php.net/manual/en/function.trim.php
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

	// Pas besoin de garder les données en session si tous les champs ont une
	// valeur.
	foreach ($fields as $field) {
		unset($_SESSION["form.inputs.$field"]);
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
function input(string $name, array $attrs = [], array $props = []): string
{
	$render = elementStart("div", ["class" => "input-container"]);

	if (isset($props["icon-left"])) {
		$render .= icon("label", $props["icon-left"], ["for" => $name]);
	}

	$attrs["id"]   = $name;
	$attrs["name"] = $name;

	if (!isset($attrs["value"])) {
		if (isset($_POST[$name])) {
			$attrs["value"] = $_POST[$name];
		} else if (isset($_SESSION["form.inputs.$name"])) {
			$attrs["value"] = $_SESSION["form.inputs.$name"];
			unset($_SESSION["form.inputs.$name"]);
		}
	}

	$render .= voidElement("input", $attrs);

	if (isset($props["icon-right"])) {
		$render .= icon("span", $props["icon-right"]);
	}

	$render .= elementEnd("div");

	return $render;
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
 *
 * Cette fonction inclue des choses que l'on n'a pas vu :
 *
 * - https://www.php.net/manual/en/function.htmlspecialchars.php
 */
function select(string $name, array $attrs = [], array $props = []): string
{
	$render = elementStart("div", ["class" => "input-container"]);

	if (isset($props["icon-left"])) {
		$render .= icon("label", $props["icon-left"], ["for" => $name]);
	}

	$attrs["id"]   = $name;
	$attrs["name"] = $name;

	$placeholder = isset($props["placeholder"]) ? $props["placeholder"] : "";
	$options     = $props["options"] ?: [];

	$render .= elementStart("select", $attrs);

	if (isset($props["default-group"])) {
		$render .= element("option", ["hidden" => true, "placeholder" => true, "selected" => true],
			htmlspecialchars($placeholder),
		);

		$render .= elementStart("optgroup", ["label" => $placeholder]);
	}

	$selectedValue = isset($_SESSION["form.inputs.$name"])
		? $_SESSION["form.inputs.$name"]
		: false;

	foreach ($options as $value => $text) {
		$selected = false;

		if (!isset($attrs["value"])) {
			$selected = $selectedValue == $value;
			unset($_SESSION["form.inputs.$name"]);
		}

		$render .= element("option", ["value" => $value, "selected" => $selected],
			htmlspecialchars($text)
		);
	}

	if (isset($props["default-group"])) {
		$render .= elementEnd("optgroup");
	}

	$render .= elementEnd("select");

	if (isset($props["icon-right"])) {
		$render .= icon("span", $props["icon-right"], ["hidden" => !(bool) $selectedValue]);
	}

	$render .= elementEnd("div");

	return $render;
}
