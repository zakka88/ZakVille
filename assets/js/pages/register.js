export class RegisterPage {
	/**
	 * @type {HTMLDivElement|null}
	 */
	#$pictures;

	/**
	 * @type {HTMLDivElement|null}
	 */
	#$presentation;

	/**
	 * @type {HTMLSelectElement|null}
	 */
	#$selectCity;

	/**
	 * @type {HTMLDivElement|null}
	 */
	#$sliderItems;

	#currentSliderIndex = 1;
	#currentSliderTimer = 0;

	#pictures = {};

	constructor() {
		this.#$selectCity = document.querySelector('select[name="city"]');
		this.#$presentation = document.querySelector(
			'section[role="presentation"]',
		);
		this.#$pictures = document.querySelector(".js-pictures");
		this.#$sliderItems = document.querySelector(".js-slider-items");
	}

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	start() {
		this.#$selectCity?.addEventListener(
			"change",
			this.#onCityChangeHandler,
		);

		this.#$selectCity?.nextElementSibling?.addEventListener(
			"click",
			this.#resetSelectCity,
		);
		this.#$selectCity?.nextElementSibling?.setAttribute("hidden", "");

		for (let [country, count_pictures] of Object.entries(this.#pictures)) {
			for (let i = 1; i < count_pictures + 1; i++) {
				let $img = document.createElement("img");
				$img.id = `${country.toLowerCase()}_${i}`;
				$img.alt = `Image numéro ${i} du pays ${country}.`;
				$img.src = `./assets/img/${country.toLowerCase()}_${i}.jpg`;
				$img.loading = "lazy";
				$img.classList.add("hide");
				this.#$pictures?.append($img);
			}
		}
	}

	/**
	 * @param {Record<string,number>} pictures
	 */
	withPictures(pictures) {
		this.#pictures = pictures;
		return this;
	}

	// ------- //
	// Méthode // -> Privée
	// ------- //

	/**
	 * @param {Array<string>} pictureIds
	 */
	#startSlider(pictureIds) {
		this.#resetSlider();

		const changePicture = () => {
			for (let pictureId of pictureIds) {
				let $link = this.#$sliderItems?.querySelector(
					`a[href="#${pictureId}"]`,
				);
				$link?.classList.remove("active");

				if (pictureId.indexOf(this.#currentSliderIndex.toFixed()) > 0) {
					$link?.classList.add("active");
					// @ts-expect-error - cette méthode existe
					$link?.click();
				}
			}

			if (
				this.#$sliderItems?.childElementCount ===
				this.#currentSliderIndex
			) {
				this.#currentSliderIndex = 1;
			} else {
				this.#currentSliderIndex += 1;
			}
		};

		changePicture();

		this.#currentSliderTimer = window.setInterval(() => {
			changePicture();
		}, 5_000);
	}

	#resetSlider() {
		clearInterval(this.#currentSliderTimer);
		this.#currentSliderIndex = 1;
	}

	// ----- //
	// Event //
	// ----- //

	#onCityChangeHandler = () => {
		this.#$selectCity?.nextElementSibling?.removeAttribute("hidden");

		let cityId = Number.parseInt(this.#$selectCity?.value || "", 10);

		if (!cityId) {
			return;
		}

		let $selectedOption = Array.from(this.#$selectCity?.options)
			.find((opt) => opt.value == cityId);
		let cityFlag = $selectedOption?.textContent
			?.split(/\(([a-z]{2})\)/i)[1]
			?.toLowerCase();

		if (this.#$sliderItems) {
			this.#$sliderItems.innerHTML = "";
		}

		this.#$presentation?.removeAttribute("hidden");
		if (this.#$pictures) {
			this.#$pictures.scrollLeft = 0;
		}

		let pictureIds = [];
		for (let $picture of Array.from(this.#$pictures?.children || [])) {
			$picture.classList.add("hide");

			if (
				$picture
					.getAttribute("src")
					?.startsWith(`./assets/img/${cityFlag}_`)
			) {
				$picture.classList.remove("hide");
				pictureIds.push($picture.id);
			}
		}

		if (pictureIds.length === 0) {
			this.#$presentation?.setAttribute("hidden", "hidden");
		}

		for (let pictureId of pictureIds) {
			let $sliderItem = document.createElement("a");
			$sliderItem.classList.add("slider-item");
			$sliderItem.href = `#${pictureId}`;
			$sliderItem.ariaLabel = `Cliquez pour visualiser la photo de ${pictureId}`;
			this.#$sliderItems?.append($sliderItem);
		}

		this.#resetSlider();
		this.#startSlider(pictureIds);
	};

	#resetSelectCity = () => {
		if (this.#$selectCity) {
			this.#$selectCity.value = "";
			this.#$selectCity.nextElementSibling?.setAttribute("hidden", "");
			let firstOption = this.#$selectCity.options.item(0);
			if (firstOption) {
				firstOption.selected = true;
			}
			this.#resetSlider();
			this.#$presentation?.setAttribute("hidden", "");
		}
	};
}
