<?php

namespace Adduc\AMvc;

class Route {
    protected
        /**
         * Uri to match.
         * @var string $uri
         */
        $uri,

        /**
         * Default parameters to use.
         * @var array $defaults
         */
        $defaults = array(
            'class' => 'index',
            'method' => 'index',
            'error' => false
        ),

        /**
         * Restrictions for named parameters in URI.
         * @var array $restrictions
         */
        $restrictions = array(),

        /**
         * Generated regex for URI
         */
        $regex;


    public function __construct($uri, $defaults = array(),
        $restrictions = array()) {
        $this->uri($uri, false);
        $this->defaults($defaults);
        $this->restrictions($restrictions);
    }

    public function uri($uri = null, $refresh_regex = true) {
        if(is_null($uri)) {
            return $uri;
        }
        $this->uri = $uri;
        $refresh_regex && $this->regex(false);
    }


    public function defaults(array $defaults = null) {
        if(is_null($defaults)) {
            return $defaults;
        }
        $this->defaults = $defaults + $this->defaults;
    }

    public function restrictions(array $restrictions = null,
        $refresh_regex = true) {
        if(is_null($restrictions)) {
            return $restrictions;
        }
        $this->restrictions = $restrictions;
        $refresh_regex && $this->regex(false);
    }

    public function regex($cached = true) {
        if($cached && $this->regex) {
            return $this->regex;
        }

        $segments = explode("/", $this->uri);

        $regex = "";

        foreach($segments as $segment) {
            if(!$segment) {
                continue;
            }

            $regex .= "/";

            if(strpos($segment,':') === 0) {
                $named_segment = substr($segment, 1);
                $re = "[^/]+";
                if(isset($restrictions[$named_segment])) {
                    $re = $restrictions[$named_segment];
                }

                $regex .= "(?P<{$named_segment}>{$re})";
            } else {
                $regex .= $segment;
            }

        }

        $this->regex = "/^" . str_replace("/", "\\/", $regex ?: '/' ) . "$/i";
    }

    public function match($uri) {
        if(preg_match($this->regex, $uri, $matches)) {
            return $matches + $this->defaults;
        }
        return false;
    }
}
