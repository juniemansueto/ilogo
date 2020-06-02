<?php

namespace ILOGO\Logoinc\Tests;

class RouteTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetRoutes()
    {
        $this->disableExceptionHandling();

        $this->visit(route('logoinc.login'));
        $this->type('admin@admin.com', 'email');
        $this->type('password', 'password');
        $this->press(__('logoinc::generic.login'));

        $urls = [
            route('logoinc.dashboard'),
            route('logoinc.media.index'),
            route('logoinc.settings.index'),
            route('logoinc.roles.index'),
            route('logoinc.roles.create'),
            route('logoinc.roles.show', 1),
            route('logoinc.roles.edit', 1),
            route('logoinc.users.index'),
            route('logoinc.users.create'),
            route('logoinc.users.show', 1),
            route('logoinc.users.edit', 1),
            route('logoinc.posts.index'),
            route('logoinc.posts.create'),
            route('logoinc.posts.show', 1),
            route('logoinc.posts.edit', 1),
            route('logoinc.pages.index'),
            route('logoinc.pages.create'),
            route('logoinc.pages.show', 1),
            route('logoinc.pages.edit', 1),
            route('logoinc.categories.index'),
            route('logoinc.categories.create'),
            route('logoinc.categories.show', 1),
            route('logoinc.categories.edit', 1),
            route('logoinc.menus.index'),
            route('logoinc.menus.create'),
            route('logoinc.menus.show', 1),
            route('logoinc.menus.edit', 1),
            route('logoinc.database.index'),
            route('logoinc.bread.edit', 'categories'),
            route('logoinc.database.edit', 'categories'),
            route('logoinc.database.create'),
        ];

        foreach ($urls as $url) {
            $response = $this->call('GET', $url);
            $this->assertEquals(200, $response->status(), $url.' did not return a 200');
        }
    }
}
