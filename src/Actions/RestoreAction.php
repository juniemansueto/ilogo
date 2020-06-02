<?php

namespace ILOGO\Logoinc\Actions;

class RestoreAction extends AbstractAction
{
    public function getTitle()
    {
        return __('logoinc::generic.restore');
    }

    public function getIcon()
    {
        return 'logoinc-trash';
    }

    public function getPolicy()
    {
        return 'restore';
    }

    public function getAttributes()
    {
        return [
            'class'   => 'btn btn-sm btn-success pull-right restore',
            'data-id' => $this->data->{$this->data->getKeyName()},
            'id'      => 'restore-'.$this->data->{$this->data->getKeyName()},
        ];
    }

    public function getDefaultRoute()
    {
        return route('logoinc.'.$this->dataType->slug.'.restore', $this->data->{$this->data->getKeyName()});
    }
}
