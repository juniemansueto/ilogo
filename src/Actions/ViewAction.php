<?php

namespace ILOGO\Logoinc\Actions;

class ViewAction extends AbstractAction
{
    public function getTitle()
    {
        return __('logoinc::generic.view');
    }

    public function getIcon()
    {
        return 'logoinc-eye';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-warning pull-right view',
        ];
    }

    public function getDefaultRoute()
    {
        return route('logoinc.'.$this->dataType->slug.'.show', $this->data->{$this->data->getKeyName()});
    }
}
