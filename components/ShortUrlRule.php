<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 21.07.18
 * Time: 12:48
 */

namespace app\components;


use function var_dump;
use yii\base\BaseObject;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlRuleInterface;

class ShortUrlRule extends BaseObject implements UrlRuleInterface
{

    /**
     * Parses the given request and returns the corresponding route and parameters.
     *
     * @param UrlManager $manager the URL manager
     * @param Request $request the request component
     *
     * @return array|bool the parsing result. The route and the parameters are returned as an array.
     * If false, it means this rule cannot be used to parse this path info.
     */
    public function parseRequest($manager, $request)
    {
        var_dump($this);exit;
        // TODO: Implement parseRequest() method.
    }

    /**
     * Creates a URL according to the given route and parameters.
     *
     * @param UrlManager $manager the URL manager
     * @param string $route the route. It should not have slashes at the beginning or the end.
     * @param array $params the parameters
     *
     * @return string|bool the created URL, or false if this rule cannot be used for creating this URL.
     */
    public function createUrl($manager, $route, $params)
    {
        var_dump($this);exit;
        // TODO: Implement createUrl() method.
    }
}