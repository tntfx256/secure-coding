<?php

namespace App\Controller;

class Chapter5Controller extends Chapter
{
    protected function code45()// Data Validation Strategies
    {
        $this->getCode(__FILE__, 'code45');
        //<code45>
        //</code45>
        $html = $this->view->render('sample/code45');
        $this->view->set('result', $html);
    }

    protected function code46()// Sanitize with Whitelist
    {
        $this->getCode(__FILE__, 'code46');
        //<code46>
        //</code46>
        $html = $this->view->render('sample/code46');
        $this->view->set('result', $html);
    }

    protected function code47()// Sanitize with Blacklist
    {
        $this->getCode(__FILE__, 'code47');
        //<code47>
        //</code47>
        $html = $this->view->render('sample/code47');
        $this->view->set('result', $html);
    }

    protected function code48()// Implement Validator
    {
        $this->getCode(__FILE__, 'code48');
        //<code48>
        //</code48>
        $html = $this->view->render('sample/code48');
        $this->view->set('result', $html);
    }
}