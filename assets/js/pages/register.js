export function start()
{
	/**
	 * @type {HTMLSelectElement|null}
	 */
	let $selectCity = document.querySelector('select[name="city"]');

	$selectCity?.addEventListener("change", onCityChangeHandler)
}

/**
 * @param {HTMLElementEventMap["change"]} evt
 */
function onCityChangeHandler(evt) {
	/**
	 * @type {HTMLElement|null}
	 */
	let $presentation = document.querySelector('section[role="presentation"]');

	$presentation?.removeAttribute("hidden");

	let cityId = evt.target?.value;
	console.log({cityId, target: evt.target})
}
