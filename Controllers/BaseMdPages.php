<?php

namespace Denis303\MdPages\Controllers;

use Denis303\MdPages\Config\MdPages as MdPagesConfig;
use Denis303\MdPages\MdPagesEvents;
use CodeIgniter\Exceptions\PageNotFoundException;

class BaseMdPages extends BaseController
{ 

    protected function findFile(array $segments) : string
    {
        $config = config(MdPagesConfig::class);

        $segmentsNum = count(explode('/', $config->route));

        $segments = array_slice($segments, $segmentsNum);

        $path = $config->basePath;

        $filename = ROOTPATH . $path . '/' . implode('/', $segments);

        return $filename;
    }

    public function index()
    {
        $request = service('request');

        $uri = $request->uri;

        $segments = $uri->getSegments();

        $filename = $this->findFile($segments);

        $is_file = false;

        if (is_file($filename))
        {
            $is_file = true;
        }
        else
        {
            if (is_dir($filename))
            {
                $filename .= '/README.md';
            }

            if (!is_file($filename))
            {   
                throw PageNotFoundException::forPageNotFound();
            }   
        }

        $content = file_get_contents($filename);

        $param = [];

        $params['content'] = MdPagesEvents::render($content, $params);

        $params['title'] = $params['title'] ?? null;

        $params['is_file'] = $is_file;

        return app_view('Denis303\MdPages\view', $params);
    }

}