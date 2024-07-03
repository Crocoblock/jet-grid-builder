module.exports = {
	limitation: function (string, value = 15) {
		if (string.split(/\s+/, value + 1).length >= value + 1) {
			string = string.split(/\s+/, value).join(' ') + '...';
		}

		return string;
	}
};