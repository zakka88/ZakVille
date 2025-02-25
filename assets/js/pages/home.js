export class HomePage {
	// ------- //
	// Méthode // -> API Publique
	// ------- //

	start() {
		let $btn = document.querySelector(".js-launch-video-btn");
		$btn.addEventListener("click", this.#launchVideoPlayer);
	}

	// ------- //
	// Méthode // -> Privée
	// ------- //

	#launchVideoPlayer() {
		document.querySelector(".js-hero").style.display = "none";

		let $iframe = document.querySelector(".js-yt-player");
		$iframe.hidden = false;
		$iframe.contentWindow.postMessage(
			`{"event":"command","func":"playVideo","args":""}`,
			"*",
		);
	}
}
