<?php

namespace Slade\nodes;

use Slade\Scope;

/**
 * @node /^</
 */
class HtmlNode extends Node
{
    public static function parse($node, $inner, $depth, Scope & $scope, Scope & $sections)
    {
        $node .= indent($inner, $depth);

        static::replaceVars($node, $scope);

        return $node;
    }
}
