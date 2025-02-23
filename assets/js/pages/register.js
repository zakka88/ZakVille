export function start() {
	/**
	 * @type {HTMLSelectElement|null}
	 */
	let $selectCity = document.querySelector('select[name="city"]');

	$selectCity?.addEventListener("change", onCityChangeHandler);
}

/**
 * @param {HTMLElementEventMap["change"]} evt
 */
function onCityChangeHandler(evt) {
	/**
	 * @type {HTMLElement|null}
	 */
	let $presentation = document.querySelector('section[role="presentation"]');
	let $pictures = document.querySelector(".js-pictures");
	let $sliderItems = document.querySelector(".js-slider-items");

	/**
	 * @type {HTMLSelectElement}
	 */
	let $selectCity = evt.target;
	let cityId = $selectCity.value;

	let $selectedOption = $selectCity.options.item(cityId);
	let cityFlag = $selectedOption.textContent
		.split(/\(([a-z]{2})\)/i)[1]
		.toLowerCase();

	$sliderItems.innerHTML = "";
	$presentation?.removeAttribute("hidden");

	let pictureIds = [];
	for (let $picture of Array.from($pictures.children)) {
		$picture.classList.add("hide");

		if ($picture.getAttribute("src").startsWith(`./assets/img/${cityFlag}_`)) {
			$picture.classList.remove("hide");
			pictureIds.push($picture.id);
		}
	}

	if (pictureIds.length === 0) {
		$presentation.setAttribute("hidden", "hidden");
	}

	for (let pictureId of pictureIds) {
		let $sliderItem = document.createElement("a");
		$sliderItem.classList.add("slider-item");
		$sliderItem.href = `#${pictureId}`;
		$sliderItems.append($sliderItem);
	}
}
