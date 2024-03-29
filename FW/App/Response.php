<?php


namespace FW\App;


class Response
{
    private static $instance;
    private $contentHasBeenSent = false;

    private function __construct()
    {
    }

    public function header($name, $value = null)
    {
        if ($this->contentHasBeenSent) return false;
        $value ? header("{$name}: $value") : header($name);
        return true;
    }

    public function contentType($contentType)
    {
        return $this->header('Content-Type', $contentType);
    }

    public function redirect($url)
    {
        if (!$this->header('Location', $url)) {
            $this->html("<script>window.location.href='{$url}'</script>");
        }
    }

    public function json($data)
    {
        if (!$this->contentHasBeenSent) {
            header('Content-Type: application/json; charset=utf-8');
            $this->contentHasBeenSent = true;
        }
        echo json_encode($data);
    }

    public function text($data)
    {
        if (!$this->contentHasBeenSent) {
            header('Content-Type: text/plain; charset=utf-8');
            $this->contentHasBeenSent = true;
        }
        echo $data;
    }

    public function html($html)
    {
        if (!$this->contentHasBeenSent) {
            header('Content-Type: text/html; charset=utf-8');
            $this->contentHasBeenSent = true;
        }
        echo $html;
    }

    public function write($content)
    {
        $this->contentHasBeenSent = true;
        echo $content;
        flush();
    }

    static function getInstance(): Response
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}