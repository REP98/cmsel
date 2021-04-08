require('./bootstrap');

addEv(document, 'DOMContentLoaded', () => {
	const plyr = querySelectors('[data-role*="plyr"]'),
		slider = querySelectors('.slider'),
		offCanvas = querySelectors('#offcanvaMenu')

	import ('plyr')
		.then((plyrvideo) => {
			console.log(55, plyrvideo);
		})

	if (plyr.length > 0) {
		Array.from(plyr).map( (video) => {
			const dataset = video.dataset;
			const player = new Plyr(video, {
				blankVideo: uri+ 'img/blank.mp4',
				autoplay: dataset.autoplay !== undefined ? dataset.autoplay : false,
				autopause: dataset.autopause !== undefined ? dataset.autopause : false,
				hideControls: dataset.hideControls !== undefined ? dataset.hideControls : true,
			});
			video.plyr = player;
		});
	}

	if (slider.length > 0) {
		const listVideo = querySelectors(".plyr", slider[0]);
		if (listVideo.length > 0) {
			Array.from(listVideo).map((plyr) => {
				let video = querySelectors("video", plyr)[0];
				MOfn(plyr.parentNode, {
					childList: true,
					attributes: true,
					subtree: false
				},
				mutation => {
					if (mutation.type === 'attributes') {
						if (mutation.attributeName === 'class') {
							if (mutation.target.classList.contains('active')) {
								video.plyr.play();
							} else {
								video.plyr.stop();
							}						
						}
					}					
				})
			});			
		}
	}

	/*
	Menú
	 */
	if (offCanvas.length > 0) {
		const timesOffC = querySelectors('.btn-close', offCanvas[0]),
			navLinkOffC = querySelectors('.nav-link', offCanvas[0]),
			menuButton = querySelectors('.togglemenu'),
			offMenu = new bs.Offcanvas(offCanvas[0])

		addEv(menuButton[0], 'click', (e) => {
			offCanvas[0].classList.add('show')
		});
		let listEl = [].concat(timesOffC, Array.from(navLinkOffC))
		listEl.forEach(el => {
				addEv(el, 'click', (e) => {
				offCanvas[0].classList.remove('show')
			})
		})
	}

	console.log('DOM Cargado')
})