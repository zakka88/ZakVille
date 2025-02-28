export class RegisterPage {
	/**
	 * @type {HTMLDivElement|null}
	 */
	#$pictures;

	/**
	 * @type {HTMLDivElement|null}
	 */
	#$carousel;

	/**
	 * @type {HTMLSelectElement|null}
	 */
	#$selectCity;

	/**
	 * @type {HTMLDivElement|null}
	 */
	#$carouselControls;

	#currentCarouselControlIndex = 1;
	#currentCarouselControlTimer = 0;

	#pictures = {};
	#currentPictures = [];
	#currentInterval = 5_000;

	constructor() {
		this.#$selectCity = document.querySelector('select[name="city"]');
		this.#$carousel = document.querySelector(
			'section[aria-roledescription="carousel"]',
		);
		this.#$pictures = document.querySelector(".js-pictures");
		this.#$carouselControls = document.querySelector(
			".js-carousel-controls",
		);
	}

	// --------------- //
	// Getter | Setter //
	// --------------- //

	get carouselActive() {
		return this.#currentCarouselControlTimer > 0;
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

	#startCarousel(reset = true) {
		let pictureIds = this.#currentPictures;

		if (reset) {
			this.#resetCarouselControls();
		}

		const changePicture = () => {
			for (let pictureId of pictureIds) {
				let $link = this.#$carouselControls?.querySelector(
					`a[href="#${pictureId}"]`,
				);
				$link.ariaSelected = false;

				if (
					pictureId.indexOf(
						this.#currentCarouselControlIndex.toFixed(),
					) > 0
				) {
					$link.ariaSelected = true;
					// @ts-expect-error - cette méthode existe
					$link?.click();
				}
			}

			if (
				this.#$carouselControls?.childElementCount - 1 ===
				this.#currentCarouselControlIndex
			) {
				this.#currentCarouselControlIndex = 1;
			} else {
				this.#currentCarouselControlIndex += 1;
			}
		};

		changePicture();

		this.#currentCarouselControlTimer = window.setInterval(() => {
			changePicture();
		}, this.#currentInterval);
	}

	#resetCarouselControls() {
		clearInterval(this.#currentCarouselControlTimer);
		this.#currentCarouselControlIndex = 1;
		this.#currentCarouselControlTimer = 0;
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

		let $selectedOption = Array.from(this.#$selectCity?.options).find(
			(opt) => Number.parseInt(opt.value, 10) === cityId,
		);
		let cityFlag = $selectedOption?.textContent
			?.split(/\(([a-z]{2})\)/i)[1]
			?.toLowerCase();

		if (this.#$carouselControls) {
			this.#$carouselControls.innerHTML = "";

			let $toggleRun = document.createElement("button");
			$toggleRun.classList.add("toggle-controls")
			$toggleRun.type = "button";

			// Remet l'interval de temps à 5s à chaque changement de ville
			this.#currentInterval = 5_000;
			$toggleRun.ariaLabel = "Arrêter le diaporama automatique";
			$toggleRun.innerHTML = `<img src="./assets/svg/pause.svg" alt="">`;

			$toggleRun.addEventListener("click", () => {
				let currentIdx = this.#currentCarouselControlIndex;
				if (this.carouselActive) {
					this.#resetCarouselControls();
					this.#currentCarouselControlIndex = currentIdx;
					this.#currentInterval = 9e20;

					$toggleRun.ariaLabel = "Démarrer le diaporama automatique";
					$toggleRun.innerHTML = `<img src="./assets/svg/play.svg" alt="">`;
				} else {
					this.#currentInterval = 5_000;
					this.#currentCarouselControlIndex = currentIdx;
					this.#startCarousel(false);

					$toggleRun.ariaLabel = "Arrêter le diaporama automatique";
					$toggleRun.innerHTML = `<img src="./assets/svg/pause.svg" alt="">`;
				}
			});

			this.#$carouselControls.append($toggleRun);
		}

		this.#$carousel?.removeAttribute("hidden");
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
			this.#$carousel?.setAttribute("hidden", "hidden");
		}

		for (let pictureId of pictureIds) {
			let $controlItem = document.createElement("a");
			$controlItem.classList.add("carousel-item");
			$controlItem.href = `#${pictureId}`;
			$controlItem.setAttribute(
				"aria-label",
				`Cliquez pour visualiser la photo de ${pictureId}`,
			);
			$controlItem.setAttribute("aria-controls", pictureId);
			this.#$carouselControls?.append($controlItem);
		}

		this.#currentPictures = pictureIds;

		this.#resetCarouselControls();
		this.#startCarousel();
	};

	#resetSelectCity = () => {
		if (this.#$selectCity) {
			this.#$selectCity.value = "";
			this.#$selectCity.nextElementSibling?.setAttribute("hidden", "");
			let firstOption = this.#$selectCity.options.item(0);
			if (firstOption) {
				firstOption.selected = true;
			}
			this.#resetCarouselControls();
			this.#$carousel?.setAttribute("hidden", "");
		}
	};
}
