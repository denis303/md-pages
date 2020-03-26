<?php

namespace Modules\Docs;

use Modules\Docs\Events\DocsRenderEvent;
use Michelf\MarkdownExtra;

class DocsEvents extends \CodeIgniter\Events\Events
{

    const EVENT_RENDER = 'ba:docs_render';

    public static function onRender($callback)
    {
        return static::on(static::EVENT_RENDER, $callback);
    }

    public static function render($content, &$params = [])
    {
        $event = new DocsRenderEvent;

        $event->params = $params;

        $event->content = $content;

        $event->parser = new MarkdownExtra;

        static::trigger(static::EVENT_RENDER, $event);

        $params = $event->params;

        $content = $event->parser->transform($event->content);
    
        if (!array_key_exists('title', $params))
        {
            $html = str_get_html($content);

            foreach($html->find('h1') as $element)
            {
                $params['title'] = $element->plaintext;

                break;
            }
        }

        return $content;
    }

}