<?php

namespace Denis303\MdPages;

use Denis303\MdPages\Events\MdPagesRenderEvent;
use Michelf\MarkdownExtra;
use DOMDocument;

class BaseMdPagesEvents extends \CodeIgniter\Events\Events
{

    const EVENT_RENDER = 'md-pages-render';

    public static function onRender($callback)
    {
        return static::on(static::EVENT_RENDER, $callback);
    }

    public static function render($content, &$params = [])
    {
        $event = new MdPagesRenderEvent;

        $event->params = (array) $params;

        $event->content = $content;

        $event->parser = new MarkdownExtra;

        static::trigger(static::EVENT_RENDER, $event);

        $params = $event->params;

        $content = $event->parser->transform($event->content);
    
        if (!array_key_exists('title', $params))
        {
            $dom = new DOMDocument;

            $dom->loadHTML($content);
            
            $headers = $dom->getElementsByTagName('h1');

            foreach($headers as $header)
            {
                $params['title'] = $header->nodeValue;

                break;
            }
        }

        return $content;
    }

}