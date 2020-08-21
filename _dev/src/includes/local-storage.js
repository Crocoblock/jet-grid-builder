export default {
	setLocalStorageItem,
	getLocalStorageItem
}

export function setLocalStorageItem(name, value) {
	if (typeof (Storage) !== "undefined") {
		localStorage.setItem(name, value);
	}
}


export function getLocalStorageItem(name, def = '') {
	let localStorageValue = '';

	if (typeof (Storage) !== "undefined") {
		localStorageValue = localStorage.getItem(name);
	}

	return localStorageValue ? localStorageValue : def;
}