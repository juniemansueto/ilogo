<?php

namespace ILOGO\Logoinc\FormFields;

class ImageHandler extends AbstractHandler
{
    protected $codename = 'image';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('logoinc::formfields.image', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
