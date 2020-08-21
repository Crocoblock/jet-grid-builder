/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 61);
/******/ })
/************************************************************************/
/******/ ({

/***/ 61:
/***/ (function(module, exports) {

eval("(function ($) {\n\t'use strict';\n\n\tvar file_frame = wp.media.frames.file_frame = wp.media({\n\t\ttitle: 'Choose Thumbnail',\n\t\tlibrary: {\n\t\t\ttype: \"image\"\n\t\t},\n\t\tmultiple: false\n\t}),\n\t    $thumbnailWrapper = $('#thumbnail-field'),\n\t    $addThumbnailBtn = $('.add-term-thumbnail', $thumbnailWrapper),\n\t    $removeThumbnailBtn = $('.remove-term-thumbnail', $thumbnailWrapper),\n\t    $thumbnail = $('.attachment', $thumbnailWrapper),\n\t    $thumbnailID = $('#thumbnail', $thumbnailWrapper),\n\t    $img = $('.thumbnail img', $thumbnailWrapper);\n\n\t$addThumbnailBtn.on('click', open);\n\t$thumbnail.on('click', open);\n\n\tfunction open(evt) {\n\t\tevt.preventDefault();\n\n\t\tfile_frame.open();\n\t}\n\n\tfile_frame.on('select', function () {\n\t\tvar attachment = file_frame.state().get('selection').first().toJSON(),\n\t\t    size = attachment.sizes.hasOwnProperty('thumbnail') ? 'thumbnail' : 'full';\n\n\t\t$img.attr('src', attachment.sizes[size].url);\n\t\t$thumbnailID.attr('value', attachment.id);\n\t});\n\n\t$removeThumbnailBtn.on('click', function () {\n\t\t$thumbnailID.attr('value', '');\n\t});\n})(jQuery);\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9zcmMvaW5jbHVkZXMvYWRtaW4uanM/YWIyMCJdLCJuYW1lcyI6WyIkIiwiZmlsZV9mcmFtZSIsIndwIiwibWVkaWEiLCJmcmFtZXMiLCJ0aXRsZSIsImxpYnJhcnkiLCJ0eXBlIiwibXVsdGlwbGUiLCIkdGh1bWJuYWlsV3JhcHBlciIsIiRhZGRUaHVtYm5haWxCdG4iLCIkcmVtb3ZlVGh1bWJuYWlsQnRuIiwiJHRodW1ibmFpbCIsIiR0aHVtYm5haWxJRCIsIiRpbWciLCJvbiIsIm9wZW4iLCJldnQiLCJwcmV2ZW50RGVmYXVsdCIsImF0dGFjaG1lbnQiLCJzdGF0ZSIsImdldCIsImZpcnN0IiwidG9KU09OIiwic2l6ZSIsInNpemVzIiwiaGFzT3duUHJvcGVydHkiLCJhdHRyIiwidXJsIiwiaWQiLCJqUXVlcnkiXSwibWFwcGluZ3MiOiJBQUFBLENBQUMsVUFBVUEsQ0FBVixFQUFhO0FBQ2I7O0FBRUEsS0FBSUMsYUFBYUMsR0FBR0MsS0FBSCxDQUFTQyxNQUFULENBQWdCSCxVQUFoQixHQUE2QkMsR0FBR0MsS0FBSCxDQUFTO0FBQ3RERSxTQUFPLGtCQUQrQztBQUV0REMsV0FBUztBQUNSQyxTQUFNO0FBREUsR0FGNkM7QUFLdERDLFlBQVU7QUFMNEMsRUFBVCxDQUE5QztBQUFBLEtBT0NDLG9CQUFvQlQsRUFBRSxrQkFBRixDQVByQjtBQUFBLEtBUUNVLG1CQUFtQlYsRUFBRSxxQkFBRixFQUF5QlMsaUJBQXpCLENBUnBCO0FBQUEsS0FTQ0Usc0JBQXNCWCxFQUFFLHdCQUFGLEVBQTRCUyxpQkFBNUIsQ0FUdkI7QUFBQSxLQVVDRyxhQUFhWixFQUFFLGFBQUYsRUFBaUJTLGlCQUFqQixDQVZkO0FBQUEsS0FXQ0ksZUFBZWIsRUFBRSxZQUFGLEVBQWdCUyxpQkFBaEIsQ0FYaEI7QUFBQSxLQVlDSyxPQUFPZCxFQUFFLGdCQUFGLEVBQW9CUyxpQkFBcEIsQ0FaUjs7QUFjQUMsa0JBQWlCSyxFQUFqQixDQUFvQixPQUFwQixFQUE2QkMsSUFBN0I7QUFDQUosWUFBV0csRUFBWCxDQUFjLE9BQWQsRUFBdUJDLElBQXZCOztBQUVBLFVBQVNBLElBQVQsQ0FBY0MsR0FBZCxFQUFtQjtBQUNsQkEsTUFBSUMsY0FBSjs7QUFFQWpCLGFBQVdlLElBQVg7QUFDQTs7QUFFRGYsWUFBV2MsRUFBWCxDQUFjLFFBQWQsRUFBd0IsWUFBWTtBQUNuQyxNQUFJSSxhQUFhbEIsV0FBV21CLEtBQVgsR0FBbUJDLEdBQW5CLENBQXVCLFdBQXZCLEVBQW9DQyxLQUFwQyxHQUE0Q0MsTUFBNUMsRUFBakI7QUFBQSxNQUNDQyxPQUFPTCxXQUFXTSxLQUFYLENBQWlCQyxjQUFqQixDQUFnQyxXQUFoQyxJQUErQyxXQUEvQyxHQUE2RCxNQURyRTs7QUFHQVosT0FBS2EsSUFBTCxDQUFVLEtBQVYsRUFBaUJSLFdBQVdNLEtBQVgsQ0FBaUJELElBQWpCLEVBQXVCSSxHQUF4QztBQUNBZixlQUFhYyxJQUFiLENBQWtCLE9BQWxCLEVBQTJCUixXQUFXVSxFQUF0QztBQUNBLEVBTkQ7O0FBUUFsQixxQkFBb0JJLEVBQXBCLENBQXVCLE9BQXZCLEVBQWdDLFlBQVk7QUFDM0NGLGVBQWFjLElBQWIsQ0FBa0IsT0FBbEIsRUFBMkIsRUFBM0I7QUFDQSxFQUZEO0FBSUEsQ0F0Q0QsRUFzQ0dHLE1BdENIIiwiZmlsZSI6IjYxLmpzIiwic291cmNlc0NvbnRlbnQiOlsiKGZ1bmN0aW9uICgkKSB7XHJcblx0J3VzZSBzdHJpY3QnO1xyXG5cclxuXHRsZXQgZmlsZV9mcmFtZSA9IHdwLm1lZGlhLmZyYW1lcy5maWxlX2ZyYW1lID0gd3AubWVkaWEoe1xyXG5cdFx0dGl0bGU6ICdDaG9vc2UgVGh1bWJuYWlsJyxcclxuXHRcdGxpYnJhcnk6IHtcclxuXHRcdFx0dHlwZTogXCJpbWFnZVwiXHJcblx0XHR9LFxyXG5cdFx0bXVsdGlwbGU6IGZhbHNlXHJcblx0fSksXHJcblx0XHQkdGh1bWJuYWlsV3JhcHBlciA9ICQoJyN0aHVtYm5haWwtZmllbGQnKSxcclxuXHRcdCRhZGRUaHVtYm5haWxCdG4gPSAkKCcuYWRkLXRlcm0tdGh1bWJuYWlsJywgJHRodW1ibmFpbFdyYXBwZXIpLFxyXG5cdFx0JHJlbW92ZVRodW1ibmFpbEJ0biA9ICQoJy5yZW1vdmUtdGVybS10aHVtYm5haWwnLCAkdGh1bWJuYWlsV3JhcHBlciksXHJcblx0XHQkdGh1bWJuYWlsID0gJCgnLmF0dGFjaG1lbnQnLCAkdGh1bWJuYWlsV3JhcHBlciksXHJcblx0XHQkdGh1bWJuYWlsSUQgPSAkKCcjdGh1bWJuYWlsJywgJHRodW1ibmFpbFdyYXBwZXIpLFxyXG5cdFx0JGltZyA9ICQoJy50aHVtYm5haWwgaW1nJywgJHRodW1ibmFpbFdyYXBwZXIpO1xyXG5cclxuXHQkYWRkVGh1bWJuYWlsQnRuLm9uKCdjbGljaycsIG9wZW4pO1xyXG5cdCR0aHVtYm5haWwub24oJ2NsaWNrJywgb3Blbik7XHJcblxyXG5cdGZ1bmN0aW9uIG9wZW4oZXZ0KSB7XHJcblx0XHRldnQucHJldmVudERlZmF1bHQoKTtcclxuXHJcblx0XHRmaWxlX2ZyYW1lLm9wZW4oKTtcclxuXHR9XHJcblxyXG5cdGZpbGVfZnJhbWUub24oJ3NlbGVjdCcsIGZ1bmN0aW9uICgpIHtcclxuXHRcdGxldCBhdHRhY2htZW50ID0gZmlsZV9mcmFtZS5zdGF0ZSgpLmdldCgnc2VsZWN0aW9uJykuZmlyc3QoKS50b0pTT04oKSxcclxuXHRcdFx0c2l6ZSA9IGF0dGFjaG1lbnQuc2l6ZXMuaGFzT3duUHJvcGVydHkoJ3RodW1ibmFpbCcpID8gJ3RodW1ibmFpbCcgOiAnZnVsbCc7XHJcblxyXG5cdFx0JGltZy5hdHRyKCdzcmMnLCBhdHRhY2htZW50LnNpemVzW3NpemVdLnVybCk7XHJcblx0XHQkdGh1bWJuYWlsSUQuYXR0cigndmFsdWUnLCBhdHRhY2htZW50LmlkKTtcclxuXHR9KTtcclxuXHJcblx0JHJlbW92ZVRodW1ibmFpbEJ0bi5vbignY2xpY2snLCBmdW5jdGlvbiAoKSB7XHJcblx0XHQkdGh1bWJuYWlsSUQuYXR0cigndmFsdWUnLCAnJyk7XHJcblx0fSk7XHJcblxyXG59KShqUXVlcnkpO1xuXG5cbi8vIFdFQlBBQ0sgRk9PVEVSIC8vXG4vLyAuL3NyYy9pbmNsdWRlcy9hZG1pbi5qcyJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///61\n");

/***/ })

/******/ });