<?php

namespace ILOGO\Logoinc\Tests;

use ILOGO\Logoinc\Alert;
use ILOGO\Logoinc\Facades\Logoinc;

class AlertTest extends TestCase
{
    public function testAlertsAreRegistered()
    {
        $alert = (new Alert('test', 'warning'))
            ->title('Title');

        Logoinc::addAlert($alert);

        $alerts = Logoinc::alerts();

        $this->assertCount(1, $alerts);
    }

    public function testComponentRenders()
    {
        Logoinc::addAlert((new Alert('test', 'warning'))
            ->title('Title')
            ->text('Text')
            ->button('Button', 'http://example.com', 'danger'));

        $alerts = Logoinc::alerts();

        $this->assertEquals('<strong>Title</strong>', $alerts[0]->components[0]->render());
        $this->assertEquals('<p>Text</p>', $alerts[0]->components[1]->render());
        $this->assertEquals("<a href='http://example.com' class='btn btn-danger'>Button</a>", $alerts[0]->components[2]->render());
    }

    public function testAlertsRenders()
    {
        Logoinc::addAlert((new Alert('test', 'warning'))
            ->title('Title')
            ->text('Text')
            ->button('Button', 'http://example.com', 'danger'));

        Logoinc::addAlert((new Alert('foo'))
            ->title('Bar')
            ->text('Foobar')
            ->button('Link', 'http://example.org'));

        $this->assertXmlStringEqualsXmlFile(
            __DIR__.'/rendered_alerts.html',
            view('logoinc::alerts')->render()
        );
    }
}
