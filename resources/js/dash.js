require('./bootstrap');

addEv(document, 'DOMContentLoaded', () => {
	//actions('[data-role]', 'bs')
	addEv(querySelectors('.sidebar-toggle')[0], 'click', (e) =>{
		e.preventDefault();
		querySelectors('#sidebar')[0].classList.toggle('open');
	})
})
