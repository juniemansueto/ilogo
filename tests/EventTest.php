<?php

namespace ILOGO\Logoinc\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use ILOGO\Logoinc\Events\BreadAdded;
use ILOGO\Logoinc\Events\BreadDataAdded;
use ILOGO\Logoinc\Events\BreadDataDeleted;
use ILOGO\Logoinc\Events\BreadDataUpdated;
use ILOGO\Logoinc\Events\BreadDeleted;
use ILOGO\Logoinc\Events\BreadImagesDeleted;
use ILOGO\Logoinc\Events\BreadUpdated;
use ILOGO\Logoinc\Events\FileDeleted;
use ILOGO\Logoinc\Events\MediaFileAdded;
use ILOGO\Logoinc\Events\TableAdded;
use ILOGO\Logoinc\Events\TableDeleted;
use ILOGO\Logoinc\Events\TableUpdated;
use ILOGO\Logoinc\Models\DataType;
use ILOGO\Logoinc\Models\Page;

class EventTest extends TestCase
{
    use DatabaseTransactions;

    public function testBreadAddedEvent()
    {
        Event::fake();
        Auth::loginUsingId(1);

        $this->post(route('logoinc.bread.store'), [
            'name'                  => 'Toast',
            'slug'                  => 'toast',
            'display_name_singular' => 'toast',
            'display_name_plural'   => 'toasts',
            'icon'                  => 'fa fa-toast',
            'description'           => 'This is a toast',
        ]);

        Event::assertDispatched(BreadAdded::class, function ($event) {
            return $event->dataType->name === 'Toast'
                || $event->dataType->slug === 'toast'
                || $event->dataType->display_name_singular === 'toast'
                || $event->dataType->display_name_plural === 'toasts'
                || $event->dataType->icon === 'fa fa-toast'
                || $event->dataType->description === 'This is a toast';
        });
    }

    public function testBreadUpdatedEvent()
    {
        Event::fake();
        Auth::loginUsingId(1);

        $this->post(route('logoinc.bread.store'), [
            'name'                  => 'Toast',
            'slug'                  => 'toast',
            'display_name_singular' => 'toast',
            'display_name_plural'   => 'toasts',
            'icon'                  => 'fa fa-toast',
            'description'           => 'This is a toast',
        ]);

        Event::assertNotDispatched(BreadUpdated::class);
        $dataType = DataType::where('slug', 'toast')->firstOrFail();

        $this->put(route('logoinc.bread.update', [$dataType->id]), [
            'name'                  => 'Test',
            'slug'                  => 'test',
            'display_name_singular' => 'test',
            'display_name_plural'   => 'tests',
            'icon'                  => 'fa fa-test',
            'description'           => 'This is a test',
        ]);

        Event::assertDispatched(BreadUpdated::class, function ($event) {
            return $event->dataType->name === 'Test'
                || $event->dataType->slug === 'test'
                || $event->dataType->display_name_singular === 'test'
                || $event->dataType->display_name_plural === 'tests'
                || $event->dataType->icon === 'fa fa-test'
                || $event->dataType->description === 'This is a test';
        });
    }

    public function testBreadDeletedEvent()
    {
        Event::fake();
        Auth::loginUsingId(1);

        $this->post(route('logoinc.bread.store'), [
            'name'                  => 'Toast',
            'slug'                  => 'toast',
            'display_name_singular' => 'toast',
            'display_name_plural'   => 'toasts',
            'icon'                  => 'fa fa-toast',
            'description'           => 'This is a toast',
        ]);

        Event::assertNotDispatched(BreadDeleted::class);
        $dataType = DataType::where('slug', 'toast')->firstOrFail();

        $this->delete(route('logoinc.bread.delete', [$dataType->id]));

        Event::assertDispatched(BreadDeleted::class);
    }

    public function testBreadDataAddedEvent()
    {
        Event::fake();
        Auth::loginUsingId(1);

        $this->post(route('logoinc.pages.store'), [
            'author_id' => 1,
            'title'     => 'Toast',
            'slug'      => 'toasts',
            'status'    => 'ACTIVE',
        ]);

        Event::assertDispatched(BreadDataAdded::class);
    }

    public function testBreadDataUpdatedEvent()
    {
        Event::fake();
        Auth::loginUsingId(1);

        $this->post(route('logoinc.pages.store'), [
            'author_id' => 1,
            'title'     => 'Toast',
            'slug'      => 'toasts',
            'status'    => 'ACTIVE',
        ]);

        Event::assertNotDispatched(BreadDataUpdated::class);

        $page = Page::where('slug', 'toasts')->firstOrFail();

        $this->put(route('logoinc.pages.update', [$page->id]), [
            'title'  => 'Test',
            'slug'   => 'tests',
            'status' => 'INACTIVE',
        ]);

        Event::assertDispatched(BreadDataUpdated::class);
    }

    public function testBreadDataDeletedEvent()
    {
        Event::fake();
        Auth::loginUsingId(1);

        $this->post(route('logoinc.pages.store'), [
            'author_id' => 1,
            'title'     => 'Toast',
            'slug'      => 'toasts',
            'status'    => 'ACTIVE',
        ]);

        Event::assertNotDispatched(BreadDataDeleted::class);

        $page = Page::where('slug', 'toasts')->firstOrFail();

        $this->delete(route('logoinc.pages.destroy', [$page->id]));

        Event::assertDispatched(BreadDataDeleted::class);
    }

    public function testBreadImagesDeletedEvent()
    {
        Event::fake();
        Auth::loginUsingId(1);
        Storage::fake(config('filesystems.default'));

        $image = UploadedFile::fake()->image('test.png');

        $this->call('POST', route('logoinc.pages.store'), [
            'author_id' => 1,
            'title'     => 'Toast',
            'slug'      => 'toasts',
            'status'    => 'ACTIVE',
        ], [], [
            'image' => $image,
        ]);

        Event::assertNotDispatched(BreadImagesDeleted::class);

        $page = Page::where('slug', 'toasts')->firstOrFail();

        $this->delete(route('logoinc.pages.destroy', [$page->id]));

        Event::assertDispatched(BreadImagesDeleted::class);
    }

    public function testFileDeletedEvent()
    {
        Event::fake();
        Auth::loginUsingId(1);
        Storage::fake(config('filesystems.default'));

        $image = UploadedFile::fake()->image('test.png');

        $this->call('POST', route('logoinc.pages.store'), [
            'author_id' => 1,
            'title'     => 'Toast',
            'slug'      => 'toasts',
            'status'    => 'ACTIVE',
        ], [], [
            'image' => $image,
        ]);

        Event::assertNotDispatched(FileDeleted::class);

        $page = Page::where('slug', 'toasts')->firstOrFail();

        $this->delete(route('logoinc.pages.destroy', [$page->id]));

        Event::assertDispatched(FileDeleted::class);
    }

    public function testTableAddedEvent()
    {
        Event::fake();
        Auth::loginUsingId(1);

        $this->post(route('logoinc.database.store'), [
            'table' => [
                'name'    => 'test',
                'columns' => [
                    [
                        'name' => 'id',
                        'type' => [
                            'name' => 'integer',
                        ],
                    ],
                ],
                'indexes'     => [],
                'foreignKeys' => [],
                'options'     => [],
            ],
        ]);

        Event::assertDispatched(TableAdded::class);
    }

    public function testTableUpdatedEvent()
    {
        Event::fake();
        Auth::loginUsingId(1);

        $this->post(route('logoinc.database.store'), [
            'table' => [
                'name'    => 'test',
                'columns' => [
                    [
                        'name' => 'id',
                        'type' => [
                            'name' => 'integer',
                        ],
                    ],
                ],
                'indexes'     => [],
                'foreignKeys' => [],
                'options'     => [],
            ],
        ]);

        Event::assertNotDispatched(TableUpdated::class);

        $this->put(route('logoinc.database.update', ['test']), [
            'table' => json_encode([
                'name'    => 'test',
                'oldName' => 'test',
                'columns' => [
                    [
                        'name'    => 'id',
                        'oldName' => 'id',
                        'type'    => [
                            'name' => 'integer',
                        ],
                    ],
                ],
                'indexes'     => [],
                'foreignKeys' => [],
                'options'     => [],
            ]),
        ]);

        Event::assertDispatched(TableUpdated::class);
    }

    public function testTableDeletedEvent()
    {
        Event::fake();
        Auth::loginUsingId(1);

        $this->post(route('logoinc.database.store'), [
            'table' => [
                'name'    => 'test',
                'columns' => [
                    [
                        'name' => 'id',
                        'type' => [
                            'name' => 'integer',
                        ],
                    ],
                ],
                'indexes'     => [],
                'foreignKeys' => [],
                'options'     => [],
            ],
        ]);

        Event::assertNotDispatched(TableDeleted::class);

        $this->delete(route('logoinc.database.destroy', ['test']));

        Event::assertDispatched(TableDeleted::class);
    }

    public function testMediaFileAddedEvent()
    {
        Event::fake();
        Auth::loginUsingId(1);
        Storage::fake(config('filesystems.default'));

        $image = UploadedFile::fake()->image('test.png');

        $this->json('POST', route('logoinc.media.upload'), ['file'=>$image]);

        Event::assertDispatched(MediaFileAdded::class);
    }
}
