<?php

namespace Hexmedia\ContentBundle\Twig\Node;

/**
 * @author Krystian Kuczek <krystian@hexmedia.pl>
 */
class AreaNode extends \Twig_Node
{
    /**
     * @param \Twig_Node $content
     * @param \Twig_Node $areaName
     * @param bool $isGlobal
     * @param int $lineno
     * @param string $tag
     */
    public function __construct(
        \Twig_Node $content,
        \Twig_Node $areaName,
        \Twig_Node $language = null,
        $isGlobal = false,
        $lineno = 0,
        $tag = null
    ) {
        parent::__construct(
            [
                'content' => $content,
                'areaName' => $areaName,
                'language' => $language
            ],
            [
                'isGlobal' => $isGlobal
            ],
            $lineno,
            $tag
        );
    }

    /**
     * Compiles the node to PHP.
     *
     * @param \Twig_Compiler $compiler A Twig_Compiler instance
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $languageNode = $this->getNode("language");

        $compiler->write(
            'echo($this->env->getExtension(\'content_area_extension\')->get('
        );

        $compiler->subcompile($this->getNode("areaName"));
        $compiler->write(", ");
        $compiler->subcompile($this->compileString($this->getNode("content")));

        $compiler->write(", ");
        $compiler->write($this->getAttribute("isGlobal") ? 'true' : 'false');

        if ($languageNode instanceof Twig_Node) {
            $compiler->write(", ");
            $compiler->subcompile($languageNode);
        }

        $compiler->write("));");
    }

    protected function compileString(\Twig_Node $body)
    {
        if ($body instanceof \Twig_Node_Expression_Constant) {
            $msg = $body->getAttribute('value');
        } elseif ($body instanceof \Twig_Node_Text) {
            $msg = $body->getAttribute('data');
        } else {
            return $body;
        }

        return new \Twig_Node_Expression_Constant(trim($msg), $body->getLine());
    }
}
