<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param string $url
     *
     * @return \Illuminate\Http\Request
     */
    public function getRequest($url = 'http://www.foo.com/hello/world')
    {
        $request = \Illuminate\Http\Request::create($url);
        $request->headers->set('referer', 'http://www.site.com/hello/world');

        return $request;
    }
}
