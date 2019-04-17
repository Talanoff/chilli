<?php

namespace App\Models\Bitrix;


use App\Services\Parse1CImport;
use Illuminate\Database\Eloquent\Model;
use Mavsan\LaProtocol\Interfaces\Import;

class Exchange extends Model implements Import
{
	protected $fillable = [
		'path',
		'status',
	];

	/**
	 * Обработка данных
	 *
	 * Метод должен возвращать self::answerSuccess, когда текущий файл
	 * обработан
	 * полностью (1С пошлет запрос на обработку следующего файла) или
	 * self::answerProgress, если требуется (большой объем, длительное время
	 * обработки и прочее) приостановить выполнение (тогда 1С пошлет снова
	 * запрос на обработку текущего файла обмена), или self::answerFailure
	 * в случае возникновения какой-либо ошибки. С любым из ответом можно
	 * отправить комментарий, например: 'progress\nОбработано 700 записей из
	 * 1000000', т.е. разделитель - перенос строки
	 *
	 * @param string $fileName полный путь к обрабатываемому файлу
	 *
	 * @return string success или progress, если какая-то ошибка - failure,
	 *                далее /n и описание
	 */
	public function import($fileName)
	{
		$type = substr($fileName, -10, 6);

		if ($type === 'import') {
			(new Parse1CImport($fileName))->handle();
		} else {
			//			Parse1COffers::dispatch($fileName);
		}

		return self::answerSuccess;
	}

	/**
	 * Метод возвращает развернутый ответ статуса, или пустую строку. Необходим,
	 * для отправки ответа к 1С, например:
	 * 'обработано 800 записей'
	 * или:
	 * 'в файле обмена имеется информация о изображении, но его нет'
	 *
	 * Если таких сообщений несколько, они должны быть разделены символом \n
	 *
	 * @return string
	 */
	public function getAnswerDetail()
	{
		// TODO: Implement getAnswerDetail() method.
	}
}
