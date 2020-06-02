<?php

namespace ILOGO\Logoinc\Tests\Unit;

use Illuminate\Support\Facades\Config;
use ILOGO\Logoinc\Facades\Logoinc;
use ILOGO\Logoinc\Tests\TestCase;

class LogoincTest extends TestCase
{
    /**
     * Dimmers returns an array filled with widget collections.
     *
     * This test will make sure that the dimmers method will give us an array
     * of the collection of the configured widgets.
     */
    public function testDimmersReturnsCollectionOfConfiguredWidgets()
    {
        Config::set('logoinc.dashboard.widgets', [
            'ILOGO\\Logoinc\\Tests\\Stubs\\Widgets\\AccessibleDimmer',
            'ILOGO\\Logoinc\\Tests\\Stubs\\Widgets\\AccessibleDimmer',
        ]);

        $dimmers = Logoinc::dimmers();

        $this->assertEquals(2, $dimmers[0]->count());
    }

    /**
     * Dimmers returns an array filled with widget collections.
     *
     * This test will make sure that the dimmers method will give us a
     * collection of the configured widgets which also should be displayed.
     */
    public function testDimmersReturnsCollectionOfConfiguredWidgetsWhichShouldBeDisplayed()
    {
        Config::set('logoinc.dashboard.widgets', [
            'ILOGO\\Logoinc\\Tests\\Stubs\\Widgets\\AccessibleDimmer',
            'ILOGO\\Logoinc\\Tests\\Stubs\\Widgets\\InAccessibleDimmer',
            'ILOGO\\Logoinc\\Tests\\Stubs\\Widgets\\InAccessibleDimmer',
        ]);

        $dimmers = Logoinc::dimmers();

        $this->assertEquals(1, $dimmers[0]->count());
    }

    /**
     * Dimmers returns an array filled with widget collections.
     *
     * Tests that we build N / 3 (rounded up) widget collections where
     * N is the total amount of widgets set in configuration
     */
    public function testCreateEnoughDimmerCollectionsToContainAllAvailableDimmers()
    {
        Config::set('logoinc.dashboard.widgets', [
            'ILOGO\\Logoinc\\Tests\\Stubs\\Widgets\\AccessibleDimmer',
            'ILOGO\\Logoinc\\Tests\\Stubs\\Widgets\\AccessibleDimmer',
            'ILOGO\\Logoinc\\Tests\\Stubs\\Widgets\\AccessibleDimmer',
            'ILOGO\\Logoinc\\Tests\\Stubs\\Widgets\\AccessibleDimmer',
            'ILOGO\\Logoinc\\Tests\\Stubs\\Widgets\\AccessibleDimmer',
        ]);

        $dimmers = Logoinc::dimmers();

        $this->assertEquals(2, count($dimmers));
        $this->assertEquals(3, $dimmers[0]->count());
        $this->assertEquals(2, $dimmers[1]->count());
    }
}
