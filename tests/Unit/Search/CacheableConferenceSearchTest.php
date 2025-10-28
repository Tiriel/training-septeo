<?php

namespace App\Tests\Unit\Search;

use App\Entity\Conference;
use App\Search\CacheableConferenceSearch;
use App\Search\ConferenceSearchInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CacheableConferenceSearchTest extends TestCase
{
    public function testCacheMissCallsInnerConferenceSearchInterface(): void
    {
        $conference = (new Conference())->setName('Test Conference');

        $mCache = $this->createMock(CacheInterface::class);
        $mCache->expects($this->once())
            ->method('get')
            ->willReturnCallback(function($key, $callback) {
                return $callback($this->createMock(ItemInterface::class));
            });

        $mSearch = $this->createMock(ConferenceSearchInterface::class);
        $mSearch->expects($this->once())
            ->method('search')
            ->with('Test Conference')
            ->willReturn([$conference]);

        $conferenceSearch = new CacheableConferenceSearch($mSearch, $mCache);
        $result = $conferenceSearch->search('Test Conference');

        $this->assertIsArray($result);
        $this->assertSame($conference, $result[0]);
    }

    public function testCacheHitReturnsResultFromCache(): void
    {
        $conference = (new Conference())->setName('Test Conference');

        $mCache = $this->createMock(CacheInterface::class);
        $mCache->expects($this->once())
            ->method('get')
            ->willReturn([$conference]);

        $mSearch = $this->createMock(ConferenceSearchInterface::class);
        $mSearch->expects($this->never())
            ->method('search');

        $conferenceSearch = new CacheableConferenceSearch($mSearch, $mCache);
        $result = $conferenceSearch->search('Test Conference');

        $this->assertIsArray($result);
        $this->assertSame($conference, $result[0]);
    }
}
