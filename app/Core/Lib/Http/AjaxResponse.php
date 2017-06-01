<?php

/*
 * Copyright (c) 2017 Eshopera Team - https://github.com/eshopera/eshopera
 * This source file is subject to the BSD 3-Clause Licence.
 * Licence is bundled with this project in the file LICENCE.
 * Written by David Hubner <david.hubner@gmail.com>
 */

namespace Eshopera\Core\Lib\Http;

use Phalcon\Http\Response;

/**
 * Ajax HTTP response
 */
class AjaxResponse extends Response
{

    /**
     * @var string $location - redirect location
     */
    private $location;

    /**
     * @var array $history - history push item
     */
    private $history;

    /**
     * @var string $scroll - scroll to selector
     */
    private $scroll;

    /**
     * @var bool $noscroll - disable scroll
     */
    private $noscroll = false;

    /**
     * @var string $nav - preselects navigation
     */
    private $nav;

    /**
     * @var array $html - contents to replace
     */
    private $html = [];

    /**
     * @var array $attrs - attributes to set
     */
    private $attr = [];

    /**
     * @var array $analytics - analytics data
     */
    private $analytics = [];

    /**
     * Gets AJAX response data
     * @return array
     */
    public function getData()
    {
        $result = [];

        if ($this->location) {
            $result['location'] = $this->location;
        }
        if ($this->history) {
            $result['history'] = $this->history;
        }
        if ($this->html) {
            $result['html'] = $this->html;
        }
        if ($this->attr) {
            $result['attr'] = $this->attr;
        }
        if ($this->scroll) {
            $result['scroll'] = $this->scroll;
        }
        if ($this->noscroll) {
            $result['noscroll'] = $this->noscroll;
        }
        if ($this->nav) {
            $result['nav'] = $this->nav;
        }
        if ($this->analytics) {
            $result['analytics'] = $this->analytics;
        }

        return $result;
    }

    /**
     * Override base redirect function
     * @param  string $location - default null
     * @param  bool $externalRedirect - default false
     * @param  int $statusCode - default 302
     * @return \Popoverify\Http\AjaxResponse
     */
    public function redirect($location = null, $externalRedirect = false, $statusCode = 302)
    {
        return $this->setLocation($location);
    }

    /**
     * Sets redirect location
     * @param  string $location
     * @return \Popoverify\Http\AjaxResponse
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * Sets history item
     * @param  string $url
     * @param  string $title - default null
     * @return \Popoverify\Http\AjaxResponse
     */
    public function setHistory($url, $title = null)
    {
        $this->history = ['url' => $url, 'title' => $title];
        return $this;
    }

    /**
     * Sets attribute for given selector
     * @param  string $attr
     * @param  string $value
     * @param  string $selector
     * @return \Popoverify\Http\AjaxResponse
     */
    public function setAttr($attr, $value, $selector)
    {
        $this->attr[$selector] = [$attr => $value];
        return $this;
    }

    /**
     * Sets scroll to selector
     * @param  string $selector
     * @return \Popoverify\Http\AjaxResponse
     */
    public function setScroll($selector)
    {
        $this->noscroll = false;
        $this->scroll = $selector;
        return $this;
    }

    /**
     * Disables automatic scroll to top of the page
     * @return \Popoverify\Http\AjaxResponse
     */
    public function disableScroll()
    {
        $this->noscroll = true;
        return $this;
    }

    /**
     * Sets navigation preselection
     * @param  string $item
     * @return \Popoverify\Http\AjaxResponse
     */
    public function setNav($item)
    {
        $this->nav = $item;
        return $this;
    }

    /**
     * Sets analytics
     * @param  array $data
     * @return \Popoverify\Http\AjaxResponse
     */
    public function setAnalytics(Array $data)
    {
        $this->analytics = $data;
        return $this;
    }

    /**
     * Adds html to replace
     * @param  string $html
     * @param  string $selector
     * @return \Popoverify\Http\AjaxResponse
     */
    public function addHtml($html, $selector)
    {
        $this->html[$selector] = $html;
        return $this;
    }

    /**
     * Sends ajax response
     * @return \Popoverify\Http\AjaxResponse
     */
    public function send()
    {
        $this->getDI()->get('eventsManager')->fire('ajax:beforeSend', $this);

        if (!$this->isSent()) {
            $this->setJsonContent($this->getData());
            return parent::send();
        }
    }
}
