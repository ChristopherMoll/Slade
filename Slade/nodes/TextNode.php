<?php namespace Slade\Nodes;

use Slade\Scope;

/**
 * @node /^\|/
 */
class TextNode extends Node {

    public static function parse($node, $inner, Scope &$scope, Scope &$sections) {
        $node = static::format($node . PHP_EOL . $inner);

        static::replaceVars($node, $scope);

        return rtrim($node, PHP_EOL) . PHP_EOL;
    }

    protected static function format($inner) {
        return implode(
            PHP_EOL,
            array_map(
                function($l) {
                    return substr($l, 2);
                },
                explode(PHP_EOL, $inner)
            )
        );
    }

    protected static function replaceVars(&$node, Scope $scope) {
        preg_match_all('/{{\s*(\w+)\s*}}/', $node, $escapedVars);
        foreach($escapedVars[1] as $i => $var)
            $node = str_replace($escapedVars[0][$i], he($scope->get($var)), $node);

        preg_match_all('/{!\s*(\w+)\s*!}/', $node, $unescapedVars);
        foreach($unescapedVars[1] as $i => $var)
            $node = str_replace($unescapedVars[0][$i], $scope->get($var), $node);
    }

}