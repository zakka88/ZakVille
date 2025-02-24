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

	#pictures = {
		au: 3,
		br: 3,
		ca: 3,
		cn: 3,
		it: 3,
		jp: 3,
		kr: 2,
		ma: 3,
		th: 3,
		us: 3,
	};

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

		for (let [country, count_pictures] of Object.entries(this.#pictures)) {
			for (let i = 1; i < count_pictures + 1; i++) {
				let $img = document.createElement("img");
				$img.id = `${country}_${i}`;
				$img.src = `./assets/img/${country}_${i}.jpg`;
				$img.loading = "lazy";
				$img.classList.add("hide");
				this.#$pictures.append($img);
			}
		}
	}

	// ------- //
	// Méthode // -> Privée
	// ------- //

	#startSlider(pictureIds) {
		this.#resetSlider();

		const changePicture = () => {
			for (let pictureId of pictureIds) {
				let $link = this.#$sliderItems.querySelector(
					`a[href="#${pictureId}"]`,
				);
				$link.classList.remove("active");

				if (pictureId.indexOf(this.#currentSliderIndex) > 0) {
					$link.classList.add("active");
					$link.click();
				}
			}

			if (
				this.#$sliderItems.childElementCount ===
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
		let cityId = this.#$selectCity.value;

		let $selectedOption = this.#$selectCity.options.item(cityId);
		let cityFlag = $selectedOption.textContent
			.split(/\(([a-z]{2})\)/i)[1]
			.toLowerCase();

		this.#$sliderItems.innerHTML = "";
		this.#$presentation?.removeAttribute("hidden");
		if (this.#$pictures) {
			this.#$pictures.scrollLeft = 0;
		}

		let pictureIds = [];
		for (let $picture of Array.from(this.#$pictures.children)) {
			$picture.classList.add("hide");

			if (
				$picture
					.getAttribute("src")
					.startsWith(`./assets/img/${cityFlag}_`)
			) {
				$picture.classList.remove("hide");
				pictureIds.push($picture.id);
			}
		}

		if (pictureIds.length === 0) {
			this.#$presentation.setAttribute("hidden", "hidden");
		}

		for (let pictureId of pictureIds) {
			let $sliderItem = document.createElement("a");
			$sliderItem.classList.add("slider-item");
			$sliderItem.href = `#${pictureId}`;
			this.#$sliderItems.append($sliderItem);
		}

		this.#resetSlider();
		this.#startSlider(pictureIds);
	};
}
