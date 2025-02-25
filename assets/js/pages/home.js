export class HomePage {
	#videoPlayState = false;

	// ------- //
	// Méthode // -> API Publique
	// ------- //

	start() {
		let $btn = document.querySelector(".js-launch-video-btn");
		$btn?.addEventListener("click", this.#launchVideoPlayer);
	}

	// ------- //
	// Méthode // -> Privée
	// ------- //

	#launchVideoPlayer = () => {
		/**
		 * @type {HTMLDivElement|null}
		 */
		let $hero = document.querySelector(".js-hero");

		if ($hero) {
			$hero.style.display = "none";
		}

		/**
		 * @type {HTMLIFrameElement|null}
		 */
		let $iframe = document.querySelector(".js-yt-player");
		if ($iframe) {
			$iframe.hidden = false;
			$iframe.contentWindow?.postMessage(
				JSON.stringify({
					event: "command",
					func: "playVideo",
					args: "",
				}),
				"*"
			);

			this.#videoPlayState = true;

			let $iframeWrapper = $iframe.parentElement?.parentElement;

			$iframeWrapper?.addEventListener("click", () => {
				this.#videoPlayState = !this.#videoPlayState;

				$iframe.contentWindow?.postMessage(
					JSON.stringify({
						event: "command",
						func: this.#videoPlayState ? "playVideo" : "pauseVideo",
						args: "",
					}),
					"*"
				)
			});
		}
	};
}
