/**
 * !(i)
 * Код попадает в итоговый файл, только когда вызвана функция, например FLSFunctions.spollers();
 * Или когда импортирован весь файл, например import "files/script.js";
 * Неиспользуемый код в итоговый файл не попадает.

 * Если мы хотим добавить модуль следует его раскомментировать
 */

jQuery(document).ready(function ($) {
	// Відкриття попапу при кліку на елементи з класом .post
	$('.post').click(function () {
		var i = $(this).attr('data-i');
		$('.popup-overlay[data-i="' + i + '"]').fadeIn();
	});

	$('.close-popup').click(function () {
		$('.popup-overlay').fadeOut();
	});

	$('.popup-overlay').click(function (event) {
		if (!$(event.target).closest('.popup-content').length) {
			$(this).fadeOut();
		}
	});
});
