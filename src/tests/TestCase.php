<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Mockery;
use Modules\Media\App\Services\V1\VideoFileService;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();


        $sendAuthLink = Mockery::mock(VideoFileService::class)
            ->makePartial()
            ->shouldReceive('convertToHLS')
            ->andReturn(null);

        $this->app->instance(VideoFileService::class, $sendAuthLink->getMock());
    }
}
