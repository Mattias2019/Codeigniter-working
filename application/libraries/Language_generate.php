<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Created by PhpStorm.
 * User: morozov-ia
 * Date: 06.10.17
 * Time: 12:15
 */
class Language_generate
{
    public $path;
    public $pathViews;
    public $filesArr;
    public $t;

    function __construct()
    {
        $this->path = $_SERVER['DOCUMENT_ROOT'] . '/';
        $this->pathViews = $this->path . 'application/views/';
        $this->pathControllers = $this->path . 'application/controllers/';
    }

    public function search_file($folderName)
    {
        $dir = opendir($folderName);
        while (($file = readdir($dir)) !== false) {
            if ($file != "." && $file != "..") {

                $folderWhile = $folderName;
                if (substr($folderWhile, -1) != '/') {
                    $folderWhile = $folderWhile . '/';
                }
                if (is_file($folderWhile . $file)) {
                    $parsExt = explode('.', $file);
                    if ($parsExt[1] == 'php') {
                        $this->filesArr[] = $folderWhile . $file;
                    }
                    continue;
                }
                $dirWhile = $folderName . $file;
                if (substr($dirWhile, -1) != '/') {
                    $dirWhile = $dirWhile . '/';
                }
                if (is_dir($dirWhile)) {
                    $this->search_file($dirWhile);
                }
            }
        }
        closedir($dir);
    }


    public function getFiles($path)
    {
        $this->search_file($path);

        return $this->filesArr;
    }

    public function getFilesControllers()
    {
        $this->search_file($this->pathViews);

        return $this->filesArr;
    }

    public function parseFilesViews($type)
    {
        foreach ($this->filesArr as $file) {
            $handle = file_get_contents($file);
            if ($type == 'view') {
//                $pattern = "/\st\(\'([\w\d-_].*?)\'\)\;\s/";//Views
                $pattern = "/\st\(\'([\w\d-_].*?)\'\)\;\s[\?\>]/";//Views
            } elseif ($type == 'controller') {
                $pattern = "/[\s(]t\(\'([\w\d-_].*?)\'\)/";//Controllers
            }

            $returnValue = preg_match_all($pattern, $handle, $matches);
            $this->t[$file] = $matches;
            unset($handle, $matches);
        }
        return;
    }

    public function strString($string)
    {
        $string = strip_tags($string);
        $string = substr($string, 0, 10);
        $string = trim($string);
        $from = array(
            "?",
            "!",
            "-",
            " ",
            "/",
            "|",
            "\/",
            "(",
            ")",
            "'",
            "%",
        );
        $to = array(
            "_",
            "_",
            "_",
            "_",
            "_",
            "_",
            "_",
            "_",
            "_",
            "_",
            "_",
        );
        return strtolower(str_replace($from, $to, $string)) . '_lang';
    }

    public function writeFirst()
    {
        $text = "<?php\n";
        $fp = fopen($this->path . "lang.php", "w");
        fwrite($fp, $text);
        fclose($fp);
    }

    public function writeFile($string)
    {
        $text = $string . "\n";
        $fp = fopen($this->path . "lang.php", "a");
        fwrite($fp, $text);
        fclose($fp);
    }
}
