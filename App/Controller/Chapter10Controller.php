<?php

namespace App\Controller;

class Chapter10Controller extends Chapter
{
    protected function code63()// Web services overview
    {
        $this->getCode(__FILE__, 'code63');
        //<code63>
        //</code63>
        $html = $this->view->render('sample/code63');
        $this->view->set('result', $html);
    }

    protected function code64()// Security in parsing of XML
    {
        $this->getCode(__FILE__, 'code64');
        //<code64>
        //</code64>
        $html = $this->view->render('sample/code64');
        $this->view->set('result', $html);
    }

    protected function code65()// XML security
    {
        $this->getCode(__FILE__, 'code65');
        //<code65>
        //</code65>
        $html = $this->view->render('sample/code65');
        $this->view->set('result', $html);
    }

    protected function code66()// AJAX technologies overview
    {
        $this->getCode(__FILE__, 'code66');
        //<code66>
        //</code66>
        $html = $this->view->render('sample/code66');
        $this->view->set('result', $html);
    }

    protected function code67()// AJAX attack trends and common attacks
    {
        $this->getCode(__FILE__, 'code67');
        //<code67>
        //</code67>
        $html = $this->view->render('sample/code67');
        $this->view->set('result', $html);
    }

    protected function code68()// AJAX defense
    {
        $this->getCode(__FILE__, 'code68');
        //<code68>
        //</code68>
        $html = $this->view->render('sample/code68');
        $this->view->set('result', $html);
    }
}