<?php

namespace Hexmedia\ContentBundle\Twig\Node;

/**
 * @author Krystian Kuczek <krystian@hexmedia.pl>
 */
class AreaNode extends \Twig_Node
{
    /**
     * @param \Twig_Node $content
     * @param string $name
     * @param \Twig_Node tag
     * @param \Twig_Node $class
     * @param \Twig_Node $language
     * @param bool $isGlobal
     * @param int $lineNumber
     * @param string $tag2
     * @internal param \Twig_Node $areaName
     */
    public function __construct(
        \Twig_Node $content,
        $name,
        \Twig_Node $tag = null,
        \Twig_Node $class = null,
        \Twig_Node $language = null,
        $isGlobal = false,
        $lineNumber = 0,
        $tag2 = null
    ) {
        parent::__construct(
            [
                'content' => $content,
                'class' => $class,
                'tag' => $tag,
                'language' => $language
            ],
            [
                'name' => $name,
                'isGlobal' => $isGlobal
            ],
            $lineNumber,
            $tag2
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
        $tagNode = $this->getNode("tag");
        $classNode = $this->getNode("class");

        $compiler->write(
            'echo($this->env->getExtension(\'content_area_extension\')->get(\'' . $this->getAttribute('name') . '\', '
        );

        if ($tagNode instanceof \Twig_Node) {
            $compiler->subcompile($tagNode);
        } else {
            $compiler->write("'div'");
        }

        $compiler->write(", ");

        if ($classNode instanceof \Twig_Node) {
            $compiler->subcompile($classNode);
        } else {
            $compiler->write("''");
        }

        $compiler->write(", ");
        $compiler->subcompile($this->compileString($this->getNode("content")));

        $compiler->write(", ");
        $compiler->write($this->getAttribute("isGlobal") ? 'true' : 'false');

        if ($languageNode instanceof \Twig_Node) {
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
