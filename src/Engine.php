<?php namespace Franzl\LaravelPlates;

use Illuminate\View\Engines\EngineInterface;
use League\Plates\Engine as PlatesEngine;
use League\Plates\Template;

class Engine implements EngineInterface
{
    /** @var PlatesEngine */
    private $engine;

    public function __construct(PlatesEngine $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Get the evaluated contents of the view.
     *
     * @param  string  $path
     * @param  array   $data
     * @return string
     */
    public function get($path, array $data = array())
    {
	    $path 	  = str_replace('.plates.php', '', $path);
	    $viewpath = $this->getViewDirPath($path);
	    $view 	  = str_replace($viewpath, '', $path);

	    // the Laravel view path, in which the view is found
	    $this->engine->setDirectory($viewpath);

	    // make the data available to all views and layouts being part of this render
	    $this->engine->addData($data);

	    return $this->engine->render($view);
    }


	/**
	 * Find Laravel view path for template
	 * @param $path
	 * @return string
	 */
	private function getViewDirPath($path)
	{
		foreach (\Config::get('view.paths') as $viewpath) {
			if (strpos($path, $viewpath) === 0) {
				return $viewpath;
			}
		}
	}

}