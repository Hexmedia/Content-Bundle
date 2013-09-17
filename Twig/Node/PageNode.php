<?php

namespace Hexmedia\ContentBundle\Twig\Node;

/**
 * @author Krystian Kuczek <krystian@hexmedia.pl>
 */
class PageNode extends \Twig_Node
{
    /**
     * @param string $name
     * @param \Twig_Node $class
     * @param int $lineno
     * @param string $tag
     */
    public function __construct($name, $field, \Twig_Node $class = null, $lineno = 0, $tag = null)
    {
        parent::__construct(['class' => $class], ['name' => $name, 'field' => $field], $lineno, $tag);
    }

    /**
     * Compiles the node to PHP.
     *
     * @param \Twig_Compiler $compiler A Twig_Compiler instance
     */
    public function compile(\Twig_Compiler $compiler)
    {
        $classNode = $this->getNode("class");

        $compiler->write('echo($this->env->getExtension(\'content_page_extension\')->get(
                $context[\'' . $this->getAttribute('name') . '\'],
                \'' . $this->getAttribute('field') . '\''
        );

        if ($classNode instanceof \Twig_Node) {
            $compiler->write(",");
            $compiler->subcompile($classNode);
        }

        $compiler->write('
        ));');
    }
}
