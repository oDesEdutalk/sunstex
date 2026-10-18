/**
 * Sunstex History Timeline - Interactive UI/UX Component
 * Supports dedicated image per year, animated progress bar, autoplay & touch swipe
 */
document.addEventListener("DOMContentLoaded", function () {
	const timelineContainers = document.querySelectorAll(".sunstex-history");

	timelineContainers.forEach((timeline) => {
		const events = Array.from(timeline.querySelectorAll(".sunstex-history-event"));
		const yearButtons = Array.from(timeline.querySelectorAll(".sunstex-history-year"));
		const prevBtn = timeline.querySelector(".sunstex-history-prev");
		const nextBtn = timeline.querySelector(".sunstex-history-next");
		const yearsGroup = timeline.querySelector(".sunstex-history-years");

		if (!events.length || !yearButtons.length) {
			return;
		}

		// Inject dynamic glowing progress bar into years group
		let progressTrack = yearsGroup ? yearsGroup.querySelector(".sunstex-timeline-progress") : null;
		let progressFill = null;
		if (yearsGroup && !progressTrack) {
			progressTrack = document.createElement("div");
			progressTrack.className = "sunstex-timeline-progress";
			progressFill = document.createElement("div");
			progressFill.className = "sunstex-timeline-progress-fill";
			progressTrack.appendChild(progressFill);
			yearsGroup.insertBefore(progressTrack, yearsGroup.firstChild);
		} else if (progressTrack) {
			progressFill = progressTrack.querySelector(".sunstex-timeline-progress-fill");
		}

		let activeIndex = 0;
		let autoplayTimer = null;
		let isHovered = false;

		const updateActiveState = (index, userInitiated = false) => {
			activeIndex = (index + events.length) % events.length;

			// 1. Toggle active event (shows corresponding image & text together)
			events.forEach((ev, i) => {
				const isActive = i === activeIndex;
				ev.classList.toggle("is-active", isActive);
				ev.setAttribute("aria-hidden", String(!isActive));
			});

			// 2. Update year button states
			yearButtons.forEach((btn, i) => {
				const link = btn.querySelector(".elementor-button");
				const isActive = i === activeIndex;

				btn.classList.toggle("is-active", isActive);
				btn.classList.toggle("is-passed", i < activeIndex);
				if (link) {
					link.setAttribute("role", "button");
					link.setAttribute("aria-pressed", String(isActive));
				}
			});

			// 3. Update Progress Track Fill
			if (progressFill && yearButtons.length > 1) {
				const percent = (activeIndex / (yearButtons.length - 1)) * 100;
				progressFill.style.width = `${percent}%`;
			}

			// If clicked directly by user, reset autoplay timer so they have time to view
			if (userInitiated) {
				resetAutoplay();
			}
		};

		// Year button direct click
		yearButtons.forEach((btn, index) => {
			btn.addEventListener("click", (e) => {
				e.preventDefault();
				updateActiveState(index, true);
			});

			const btnLink = btn.querySelector(".elementor-button");
			if (btnLink) {
				btnLink.addEventListener("keydown", (e) => {
					if (e.key === "Enter" || e.key === " ") {
						e.preventDefault();
						updateActiveState(index, true);
					}
				});
			}
		});

		// Prev / Next button navigation
		if (prevBtn) {
			prevBtn.addEventListener("click", (e) => {
				e.preventDefault();
				updateActiveState(activeIndex - 1, true);
			});
		}

		if (nextBtn) {
			nextBtn.addEventListener("click", (e) => {
				e.preventDefault();
				updateActiveState(activeIndex + 1, true);
			});
		}

		// Keyboard Left / Right navigation
		timeline.addEventListener("keydown", (e) => {
			if (e.key === "ArrowLeft") {
				e.preventDefault();
				updateActiveState(activeIndex - 1, true);
			} else if (e.key === "ArrowRight") {
				e.preventDefault();
				updateActiveState(activeIndex + 1, true);
			}
		});

		// Mobile Touch Swipe support
		let touchStartX = 0;
		timeline.addEventListener(
			"touchstart",
			(e) => {
				touchStartX = e.changedTouches[0].screenX;
			},
			{ passive: true }
		);

		timeline.addEventListener(
			"touchend",
			(e) => {
				const touchEndX = e.changedTouches[0].screenX;
				const diff = touchStartX - touchEndX;
				if (Math.abs(diff) > 45) {
					if (diff > 0) {
						updateActiveState(activeIndex + 1, true);
					} else {
						updateActiveState(activeIndex - 1, true);
					}
				}
			},
			{ passive: true }
		);

		// Autoplay every 6 seconds (pauses on hover)
		function startAutoplay() {
			stopAutoplay();
			autoplayTimer = setInterval(() => {
				if (!isHovered && !document.body.classList.contains("elementor-editor-active")) {
					updateActiveState(activeIndex + 1, false);
				}
			}, 6000);
		}

		function stopAutoplay() {
			if (autoplayTimer) {
				clearInterval(autoplayTimer);
				autoplayTimer = null;
			}
		}

		function resetAutoplay() {
			stopAutoplay();
			startAutoplay();
		}

		timeline.addEventListener("mouseenter", () => {
			isHovered = true;
		});

		timeline.addEventListener("mouseleave", () => {
			isHovered = false;
		});

		// Initialize state
		updateActiveState(0, false);
		startAutoplay();
	});
});
