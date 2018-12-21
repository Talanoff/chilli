<?php
/**
 * ProtocolController.php
 * Date: 16.05.2017
 * Time: 16:09
 * Author: Maksim Klimenko
 * Email: mavsan@gmail.com
 */

namespace Mavsan\LaProtocol\Http\Controllers;

use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Mavsan\LaProtocol\Interfaces\Import;
use Mavsan\LaProtocol\Model\FileName;

class CatalogController extends BaseController
{
    /** @var  Request */
    protected $request;
    protected $stepCheckAuth = 'checkauth';
    protected $stepInit = 'init';
    protected $stepFile = 'file';
    protected $stepImport = 'import';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function catalogIn()
    {
        $type = $this->request->get('type');
        $mode = $this->request->get('mode');

        if (config('protocolExchange1C.logCommandsOf1C', false)) {
            \Log::debug('Command from 1C type: '.$type.'; mode: '.$mode);
        }

        if ($type != 'catalog') {
            return $this->failure();
        }

        if (! $this->userLogin()) {
            return $this->failure('wrong username or password');
        }

        switch ($mode) {
            case $this->stepCheckAuth:
                return $this->checkAuth();
                break;

            case $this->stepInit:
                return $this->init();
                break;

            case $this->stepFile:
                return $this->getFile();
                break;

            case $this->stepImport:
                return $this->import();
                break;
        }

        return $this->failure();
    }

    /**
     * Сообщение о ошибке
     *
     * @param string $details - детали, строки должны быть разделены /n
     *
     * @return string
     */
    protected function failure($details = '')
    {
        $return = "failure".(empty($details) ? '' : "\n$details");

        return $this->answer($return);
    }

    /**
     * Ответ серверу
     *
     * @param $answer
     *
     * @return string
     */
    protected function answer($answer)
    {
        return iconv('UTF-8', 'windows-1251', $answer);
    }

    /**
     * Попытка входа
     * @return bool
     */
    protected function userLogin()
    {
        if (Auth::getUser() === null) {
            $user = \Request::getUser();
            $pass = \Request::getPassword();

            $attempt = Auth::attempt(['email' => $user, 'password' => $pass]);

            if (! $attempt) {
                return false;
            }

            $gates = config('protocolExchange1C.gates', []);
            if (! is_array($gates)) {
                $gates = [$gates];
            }

            foreach ($gates as $gate) {
                if (\Gate::has($gate) && \Gate::denies($gate, Auth::user())) {
                    Auth::logout();

                    return false;
                }
            }

            return true;
        }

        return true;
    }

    /**
     * Авторизация 1с в системе
     */
    protected function checkAuth()
    {
        $cookieName = config('session.cookie');
        $cookieID = \Session::getId();

        return $this->answer("success\n$cookieName\n$cookieID");
    }

    /**
     * Инициализация соединения
     * @return string
     */
    protected function init()
    {
        $zip = "zip=".($this->canUseZip() ? 'yes' : 'no');

        return $this->answer("$zip\nfile_limit="
                             .config('protocolExchange1C.maxFileSize'));
    }

    /**
     * Можно ли использовать ZIP
     * @return bool
     */
    protected function canUseZip()
    {
        return function_exists("zip_open");
    }

    /**
     * Получение файла(ов)
     * @return string
     */
    protected function getFile()
    {
        $modelFileName = new FileName($this->request->input('filename'));
        $fileName = $modelFileName->getFileName();

        if (empty($fileName)) {
            return $this->failure('Mode: '.$this->stepFile
                                  .', parameter filename is empty');
        }

        $fullPath = $this->getFullPathToFile($fileName, true);

        $fData = $this->getFileGetData();

        if (empty($fData)) {
            return $this->failure('Mode: '.$this->stepFile
                                  .', input data is empty.');
        }

        if ($file = fopen($fullPath, 'ab')) {

            $dataLen = mb_strlen($fData, 'latin1');
            $result = fwrite($file, $fData);

            if ($result === $dataLen) {
                // файлы, требующие распаковки
                $files = [];

                if ($this->canUseZip()) {
                    $files = session('inputZipped', []);
                    $files[$fileName] = $fullPath;
                }

                session(['inputZipped' => $files]);

                return $this->success();
            }

            $this->failure('Mode: '.$this->stepFile
                           .', can`t wrote data to file: '.$fullPath);

        } else {
            return $this->failure('Mode: '.$this->stepFile.', cant open file: '
                                  .$fullPath.' to write.');
        }

        return $this->failure('Mode: '.$this->stepFile.', unexpected error.');
    }

    /**
     * Формирование полного пути к файлу
     *
     * @param string $fileName
     *
     * @param bool   $clearOld
     *
     * @return string
     */
    protected function getFullPathToFile($fileName, $clearOld = false)
    {
        $workDirName = $this->checkInputPath();

        if ($clearOld) {
            $this->clearInputPath($workDirName);
        }

        $path = config('protocolExchange1C.inputPath');

        return $path.'/'.$workDirName.'/'.$fileName;
    }

    /**
     * Формирование имени папки, куда будут сохранятся принимаемые файлы
     * @return string
     */
    protected function checkInputPath()
    {
        $folderName = session('inputFolderName');

        if (empty($folderName)) {
            $folderName = date('Y-m-d_H:i:s').'_'.time();

            $fullPath = config('protocolExchange1C.inputPath').'/'.$folderName;

            if (! \File::isDirectory($fullPath)) {
                \File::makeDirectory($fullPath, 0755, true);
            }

            session(['inputFolderName' => $folderName]);
        }

        return $folderName;
    }

    /**
     * Очистка папки, где хранятся входящие файлы от предыдущих принятых файлов
     *
     * @param $currentFolder
     */
    protected function clearInputPath($currentFolder)
    {
        $storePath = config('protocolExchange1C.inputPath');

        foreach (\File::directories($storePath) as $path) {
            if (\File::basename($path) != $currentFolder) {
                \File::deleteDirectory($path);
            }
        }
    }

    /**
     * получение контента файла
     *
     * @return string
     */
    protected function getFileGetData()
    {
        /*if (function_exists("file_get_contents")) {
            $fData = file_get_contents("php://input");
        } elseif (isset($GLOBALS["HTTP_RAW_POST_DATA"])) {
            $fData = &$GLOBALS["HTTP_RAW_POST_DATA"];
        } else {
            $fData = '';
        }

        if (\App::environment('testing')) {
            $fData = \Request::getContent();
        }

        return $fData;
        */

        return \Request::getContent();
    }

    /**
     * Отправка ответа, что все в порядке
     * @return string
     */
    protected function success()
    {
        return $this->answer('success');
    }

    /**
     * Импорт данных
     * @return string
     */
    protected function import()
    {
        $unZip = $this->unzipIfNeed();

        if ($unZip == 'more') {
            return $this->answer('progress');
        } elseif (! empty($unZip)) {
            return $this->failure('Mode: '.$this->stepImport.' '.$unZip);
        }

        // проверка валидности имени файла
        $fileName =
            $this->importGetFileName($this->request->get('filename'));
        if (empty($fileName)) {
            return $this->failure('Mode: '.$this->stepImport
                                  .' wrong file name: '
                                  .$this->request->get('filename'));
        }

        $modelCLass = config('protocolExchange1C.catalogWorkModel');
        // проверка модели
        if (empty($modelCLass)) {
            return $this->failure('Mode: '.$this->stepImport
                                  .', please set model to import data in catalogWorkModel key.');
        }

        /** @var Import $model */
        $model = \App::make($modelCLass);
        if (! $model instanceof Import) {
            return $this->failure('Mode: '.$this->stepImport.' model '
                                  .$modelCLass
                                  .' must implement \Mavsan\LaProtocol\Interfaces\Import');
        }

        try {
            $fullPath = $this->getFullPathToFile($fileName);

            if (! \File::isFile($fullPath)) {
                return $this->failure('Mode: '.$this->stepImport.', file '
                                      .$fullPath
                                      .' not exists');
            }

            $ret = $model->import($fullPath);

            $retData = explode("\n", $ret);
            $valid = [
                Import::answerSuccess,
                Import::answerProgress,
                Import::answerFailure,
            ];

            if (! in_array($retData[0], $valid)) {
                return $this->failure('Mode: '.$this->stepImport.' model '
                                      .$modelCLass
                                      .' model return wrong answer');
            }

            $log = $model->getAnswerDetail();

            return $ret."\n".$log;

        } catch (\Exception $e) {
            return $this->failure('Mode: '.$this->stepImport
                                  .", exception: {$e->getMessage()}\n"
                                  ."{$e->getFile()}, {$e->getLine()}\n"
                                  ."{$e->getTraceAsString()}");
        }
    }

    /**
     * Распаковка файлов, если требуется
     *
     * @return string
     */
    protected function unzipIfNeed()
    {
        $files = session('inputZipped', []);

        if (empty($files)) {
            return '';
        }

        $file = array_shift($files);

        session(['inputZipped' => $files]);

        /** @var \Chumper\Zipper\Zipper $zip */
        try {
            $zip = \Zipper::make($file);
            if ($zip->getStatus() === false) {
                return 'Error opening zipped: '.$file;
            }
        } catch (Exception $e) {
            return 'Error opening zipped: '.$e->getMessage();
        }

        $path =
            config('protocolExchange1C.inputPath').'/'.$this->checkInputPath();

        $zip->extractTo($path);

        \File::delete($file);

        return 'more';
    }

    /**
     * Получение и очистка имени файла. Все, что тут сделано - взято из 1С
     * Битрикс
     *
     * В случае, если имя переданное файла не проходит фильтры - будет
     * возвращена пустая строка
     *
     * @param string $fileName
     *
     * @return string
     */
    protected function importGetFileName($fileName)
    {
        $modeFileName = new FileName($fileName);
        if ($modeFileName->hasScriptExtension()
            || $modeFileName->isFileUnsafe()
            || ! $modeFileName->validatePathString("/$fileName")
        ) {
            return '';
        }

        return $modeFileName->getFileName();
    }
}