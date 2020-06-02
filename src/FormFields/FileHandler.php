<?php

namespace ILOGO\Logoinc\FormFields;

class FileHandler extends AbstractHandler
{
    protected $codename = 'file';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('logoinc::formfields.file', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
