<?php

function isEmptyForm(array $fields, array $ignoreFields = []): bool
{
	foreach ($fields as $field) {
		if (in_array($field, $ignoreFields)) {
			continue;
		}

		if (empty($_POST[$field])) {
			return true;
		}
	}
	return false;
}

function inputValue(string $field): string
{
	return isset($_POST[$field]) ? htmlspecialchars($_POST[$field]) : "";
}
