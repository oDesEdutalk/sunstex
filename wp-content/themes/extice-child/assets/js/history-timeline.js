/**
 * Sunstex History Timeline - Interactive UI/UX Component
 * Supports 5 Milestones, Smooth Crossfade Imagery, Progress Bar, Autoplay & Touch
 */
document.addEventListener("DOMContentLoaded", function () {
	const timelineContainers = document.querySelectorAll(".sunstex-history");

	timelineContainers.forEach((timeline) => {
		const events = Array.from(timeline.querySelectorAll(".sunstex-history-event"));
		const yearButtons = Array.from(timeline.querySelectorAll(".sunstex-history-year"));
		const prevBtn = timeline.querySelector(".sunstex-history-prev");
		const nextBtn = timeline.querySelector(".sunstex-history-next");
		const yearsGroup = timeline.querySelector(".sunstex-history-years");
		const featureContainer = timeline.querySelector(".sunstex-history-feature");
		const imageWrapper = timeline.querySelector(".sunstex-history-image");
		const featureImg = imageWrapper ? imageWrapper.querySelector("img") : null;

		if (!events.length || !yearButtons.length) {
			return;
		}

		// Milestone configuration with real high-resolution Sunstex assets
		const milestoneData = [
			{
				year: "2008",
				tag: "Khởi Nguyên Đặt Nền Móng",
				badge: "Xưởng May Đạt Chuẩn",
				img: "https://sunstex.vn/wp-content/uploads/2026/08/MG_7202-scaled.jpg",
				alt: "Xưởng may Sunstex thành lập năm 2008"
			},
			{
				year: "2014",
				tag: "Mở Rộng Quy Mô",
				badge: "Dây Chuyền May Hiện Đại",
				img: "https://sunstex.vn/wp-content/uploads/2026/08/Cover-2021-12.jpg",
				alt: "Dây chuyền máy may công nghiệp Sunstex 2014"
			},
			{
				year: "2018",
				tag: "Bước Ngoặt Bứt Phá",
				badge: "Hợp Tác Đối Tác Lớn",
				img: "https://sunstex.vn/wp-content/uploads/2026/08/Cover-2021-09.jpg",
				alt: "Đội ngũ nhân sự và chuỗi cung ứng Sunstex 2018"
			},
			{
				year: "2021",
				tag: "Tiên Phong Công Nghệ",
				badge: "In Lụa & Kỹ Thuật Số Tự Động",
				img: "https://sunstex.vn/wp-content/uploads/2026/08/Cover-2021-08.jpg",
				alt: "Phân xưởng in tự động hóa Sunstex 2021"
			},
			{
				year: "2024 - Nay",
				tag: "Vươn Tầm Quốc Tế",
				badge: "Dệt May Bền Vững & ODM/OEM",
				img: "https://sunstex.vn/wp-content/uploads/2026/08/MG_7347-scaled.jpg",
				alt: "Quy trình dệt may xanh và xuất khẩu Sunstex"
			}
		];

		// Preload images for silky-smooth instant switching
		milestoneData.forEach((m) => {
			const preloadImg = new Image();
			preloadImg.src = m.img;
		});

		// Create dynamic visual badge overlay on image wrapper
		if (imageWrapper && !imageWrapper.querySelector(".sunstex-img-overlay-badges")) {
			const overlayBadges = document.createElement("div");
			overlayBadges.className = "sunstex-img-overlay-badges";
			overlayBadges.innerHTML = `
				<div class="sunstex-badge-chip year-chip">2008</div>
				<div class="sunstex-badge-chip tag-chip">Khởi Nguyên Đặt Nền Móng</div>
			`;
			imageWrapper.appendChild(overlayBadges);
		}

		// Inject glowing progress line track into years group
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
			const current = milestoneData[activeIndex] || milestoneData[0];

			// 1. Update text events
			events.forEach((ev, i) => {
				const isActive = i === activeIndex;
				ev.classList.toggle("is-active", isActive);
				ev.setAttribute("aria-hidden", String(!isActive));
			});

			// 2. Update year buttons
			yearButtons.forEach((btn, i) => {
				const link = btn.querySelector(".elementor-button");
				const label = btn.querySelector(".elementor-button-text");
				const mData = milestoneData[i];
				const isActive = i === activeIndex;

				if (label && mData) {
					label.textContent = mData.year;
				}
				btn.classList.toggle("is-active", isActive);
				btn.classList.toggle("is-passed", i < activeIndex);
				if (link) {
					link.setAttribute("role", "button");
					link.setAttribute("aria-pressed", String(isActive));
					link.setAttribute("aria-label", `Xem mốc năm ${mData ? mData.year : ""}`);
				}
			});

			// 3. Update Progress Bar Fill
			if (progressFill && yearButtons.length > 1) {
				const percent = (activeIndex / (yearButtons.length - 1)) * 100;
				progressFill.style.width = `${percent}%`;
			}

			// 4. Update image with smooth crossfade
			if (featureImg && current) {
				featureImg.style.opacity = "0.2";
				featureImg.style.transform = "scale(0.97)";
				setTimeout(() => {
					featureImg.src = current.img;
					featureImg.alt = current.alt;
					featureImg.style.opacity = "1";
					featureImg.style.transform = "scale(1)";
				}, 160);
			}

			// 5. Update floating image badges
			if (imageWrapper) {
				const yearChip = imageWrapper.querySelector(".sunstex-badge-chip.year-chip");
				const tagChip = imageWrapper.querySelector(".sunstex-badge-chip.tag-chip");
				if (yearChip && current) yearChip.textContent = current.year;
				if (tagChip && current) tagChip.textContent = current.badge;
			}

			// If clicked directly, reset autoplay timer so user has time to read
			if (userInitiated) {
				resetAutoplay();
			}
		};

		// Year button click handlers (direct index click)
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

		// Arrow navigation
		if (prevBtn) {
			const link = prevBtn.querySelector(".elementor-button");
			if (link) {
				link.setAttribute("role", "button");
				link.setAttribute("aria-label", "Mốc thời gian trước đó");
			}
			prevBtn.addEventListener("click", (e) => {
				e.preventDefault();
				updateActiveState(activeIndex - 1, true);
			});
		}

		if (nextBtn) {
			const link = nextBtn.querySelector(".elementor-button");
			if (link) {
				link.setAttribute("role", "button");
				link.setAttribute("aria-label", "Mốc thời gian kế tiếp");
			}
			nextBtn.addEventListener("click", (e) => {
				e.preventDefault();
				updateActiveState(activeIndex + 1, true);
			});
		}

		// Keyboard left/right arrows
		timeline.addEventListener("keydown", (e) => {
			if (e.key === "ArrowLeft") {
				e.preventDefault();
				updateActiveState(activeIndex - 1, true);
			} else if (e.key === "ArrowRight") {
				e.preventDefault();
				updateActiveState(activeIndex + 1, true);
			}
		});

		// Touch swipe gestures for mobile
		let touchStartX = 0;
		let touchEndX = 0;

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
				touchEndX = e.changedTouches[0].screenX;
				const diff = touchStartX - touchEndX;
				if (Math.abs(diff) > 45) {
					if (diff > 0) {
						// Swiped left -> next
						updateActiveState(activeIndex + 1, true);
					} else {
						// Swiped right -> prev
						updateActiveState(activeIndex - 1, true);
					}
				}
			},
			{ passive: true }
		);

		// Autoplay management
		function startAutoplay() {
			stopAutoplay();
			autoplayTimer = setInterval(() => {
				if (!isHovered) {
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
