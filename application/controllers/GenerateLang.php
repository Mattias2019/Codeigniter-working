<?php


class GenerateLang extends \CI_Controller
{


    public function index()
    {
        $model = $this->language_generate;
        $model->getFiles($model->pathViews);
        $model->parseFilesViews('view');
        $model->getFiles($model->pathControllers);
        $model->parseFilesViews('controller');
        $langs = [];
        $model->writeFirst();
        echo '<pre>';
        foreach ($model->t as $item) {
            foreach ($item[1] as $i) {
                $model->writeFile("\$lang['" . $model->strString($i) . "']='" . $i . "';");
            }
        }
        echo '</pre>';
        return;
    }

}