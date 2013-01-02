<?php

namespace Front\Model\Common;

class Dom
{

    public static function getMetaTagsByUrl($url)
    {
        $url = substr_count($url, 'http://') ? $url : ('http://' . $url);
        $dom = new \Zend\Dom\Query(file_get_contents($url), 'UTF-8');

        $metaTag = array();
        foreach ($dom->execute('meta') as $meta) {
            $metaTag[$meta->getAttribute('name')] = $meta->getAttribute('content');
        }
        
        $metaTag['title'] = $dom->execute('title')->current()->nodeValue;
        return $metaTag;
    }

}