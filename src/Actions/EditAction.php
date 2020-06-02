<?php

namespace ILOGO\Logoinc\Actions;

class EditAction extends AbstractAction
{
    public function getTitle()
    {
        return __('logoinc::generic.edit');
    }

    public function getIcon()
    {
        return 'logoinc-edit';
    }

    public function getPolicy()
    {
        return 'edit';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right edit',
        ];
    }

    public function getDefaultRoute()
    {
        return route('logoinc.'.$this->dataType->slug.'.edit', $this->data->{$this->data->getKeyName()});
    }
}
