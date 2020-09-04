export default {
	preloadMedia,
	absoluteCoords,
	relativeCoords,
	mergeArraysOfObjects,
	clone,
	///////////
	removeFromArray,
	stringToArray,
	stringToBoolean,
	getIntermediateImageSizesUrl
}

export function preloadMedia(data, callback) {
	let total = 0,
		loadedCout = 0;

	data.forEach((item, index) => {
		if (!item.thumbnail_data)
			return;

		if (item.thumbnail_data.file) {
			let image = new Image();

			total++;

			image.src = item.thumbnail_data.file;
			image.onload = () => {
				itemLoaded();
			}
			image.onerror = () => {
				data[index].thumbnail_data = false;
				itemLoaded();
			}
		}
	});

	if (total === 0)
		callback(data);

	function itemLoaded() {
		loadedCout++;
		if (total == loadedCout) {
			callback(data);
		}
	}
}

export function absoluteCoords(el) {
	var rect = el.getBoundingClientRect(),
		scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
		scrollTop = window.pageYOffset || document.documentElement.scrollTop;

	return {
		top: rect.top + scrollTop,
		left: rect.left + scrollLeft
	}
}

export function relativeCoords(el) {
	let elRect = el.getBoundingClientRect(),
		parentRect = el.offsetParent.getBoundingClientRect();

	return {
		top: elRect.top - parentRect.top,
		left: elRect.left - parentRect.left
	}
}

export function mergeArraysOfObjects(mergeArrays) {
	let mergedArray = [],
		arraysCount = mergeArrays.length,
		maxLength = Math.max.apply(Math, mergeArrays.map(array => {
			return array.length;
		}));

	for (let keyNumber = 0; keyNumber < maxLength; keyNumber++) {
		let obj = {};

		for (let arrayNumber = 0; arrayNumber < arraysCount; arrayNumber++) {
			obj = Object.assign(obj, mergeArrays[arrayNumber][keyNumber]);
		}
		mergedArray.push(obj);
	}

	return mergedArray;
}

export function clone(o) {
	let output, v, key;

	output = Array.isArray(o) ? [] : {};

	for (key in o) {
		v = o[key];
		output[key] = (typeof v === "object") ? clone(v) : v;
	}

	return output;
}









export function removeFromArray(array, val) {
	let index = array.indexOf(val);

	if (index > -1) {
		array.splice(index, 1);
	}

	return array;
}

export function stringToArray(str, type = false) {
	let array = [];

	if (str)
		array = type ? str.split(',').map(type) : str.split(',');

	return array;
}

export function getIntermediateImageSizesUrl(sizes, size = 'thumbnail') {
	if (sizes[size])
		return sizes[size];

	if (sizes['full'])
		return sizes['full'];

	return false;
}

export function stringToBoolean(string) {
	if (typeof string === 'boolean')
		return string;

	switch (string.toLowerCase().trim()) {
		case 'true': case 'yes': case '1': return true;
		case 'false': case 'no': case '0': case null: return false;
		default: return Boolean(string);
	}
}