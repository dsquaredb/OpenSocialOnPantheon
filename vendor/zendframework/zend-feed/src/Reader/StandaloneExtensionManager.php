<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Feed\Reader;

class StandaloneExtensionManager implements ExtensionManagerInterface
{
    private $extensions = [
<<<<<<< HEAD
        'Atom\Entry'            => 'Zend\Feed\Reader\Extension\Atom\Entry',
        'Atom\Feed'             => 'Zend\Feed\Reader\Extension\Atom\Feed',
        'Content\Entry'         => 'Zend\Feed\Reader\Extension\Content\Entry',
        'CreativeCommons\Entry' => 'Zend\Feed\Reader\Extension\CreativeCommons\Entry',
        'CreativeCommons\Feed'  => 'Zend\Feed\Reader\Extension\CreativeCommons\Feed',
        'DublinCore\Entry'      => 'Zend\Feed\Reader\Extension\DublinCore\Entry',
        'DublinCore\Feed'       => 'Zend\Feed\Reader\Extension\DublinCore\Feed',
        'Podcast\Entry'         => 'Zend\Feed\Reader\Extension\Podcast\Entry',
        'Podcast\Feed'          => 'Zend\Feed\Reader\Extension\Podcast\Feed',
        'Slash\Entry'           => 'Zend\Feed\Reader\Extension\Slash\Entry',
        'Syndication\Feed'      => 'Zend\Feed\Reader\Extension\Syndication\Feed',
        'Thread\Entry'          => 'Zend\Feed\Reader\Extension\Thread\Entry',
        'WellFormedWeb\Entry'   => 'Zend\Feed\Reader\Extension\WellFormedWeb\Entry',
=======
        'Atom\Entry'            => Extension\Atom\Entry::class,
        'Atom\Feed'             => Extension\Atom\Feed::class,
        'Content\Entry'         => Extension\Content\Entry::class,
        'CreativeCommons\Entry' => Extension\CreativeCommons\Entry::class,
        'CreativeCommons\Feed'  => Extension\CreativeCommons\Feed::class,
        'DublinCore\Entry'      => Extension\DublinCore\Entry::class,
        'DublinCore\Feed'       => Extension\DublinCore\Feed::class,
        'Podcast\Entry'         => Extension\Podcast\Entry::class,
        'Podcast\Feed'          => Extension\Podcast\Feed::class,
        'Slash\Entry'           => Extension\Slash\Entry::class,
        'Syndication\Feed'      => Extension\Syndication\Feed::class,
        'Thread\Entry'          => Extension\Thread\Entry::class,
        'WellFormedWeb\Entry'   => Extension\WellFormedWeb\Entry::class,
>>>>>>> Update Open Social to 8.x-2.1
    ];

    /**
     * Do we have the extension?
     *
     * @param  string $extension
     * @return bool
     */
    public function has($extension)
    {
        return array_key_exists($extension, $this->extensions);
    }

    /**
     * Retrieve the extension
     *
     * @param  string $extension
     * @return Extension\AbstractEntry|Extension\AbstractFeed
     */
    public function get($extension)
    {
        $class = $this->extensions[$extension];
        return new $class();
    }
}
