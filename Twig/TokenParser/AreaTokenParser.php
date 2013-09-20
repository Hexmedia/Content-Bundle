<?php

namespace Hexmedia\ContentBundle\Twig\TokenParser;

use Hexmedia\ContentBundle\Twig\Node\AreaNode;

/**
 * Token Parser for the 'area' tag.
 *
 * @author Krystian Kuczek <krystian@hexmedia.pl>
 */
class AreaTokenParser extends \Twig_TokenParser
{

    /**
     * {@inheritdoc}
     */
    public function parse(\Twig_Token $token)
    {
        $lineNumber = $token->getLine();
        $stream = $this->parser->getStream();

        $isGlobal = false;
        $language = null;
        $tag = null;
        $class = null;

        $name = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();

        if ($stream->test("tag")) {
            $stream->next();
            $stream->expect(\Twig_Token::OPERATOR_TYPE, '=');
            $tag = $this->parser->getExpressionParser()->parseExpression();
        }

        if ($stream->test("class")) {
            $stream->next();
            $stream->expect(\Twig_Token::OPERATOR_TYPE, "=");

            $class = $this->parser->getExpressionParser()->parseExpression();
        }

        if ($stream->test('global')) {
            $stream->next();
            $isGlobal = true;
        }

        if ($stream->test('language')) {
            $stream->next();
            $stream->expect(\Twig_Token::OPERATOR_TYPE, '=');
            $language = $this->parser->getExpressionParser()->parseExpression();
        }

        if (!$stream->test(\Twig_Token::BLOCK_END_TYPE)) {
            throw new \Twig_Error_Syntax('Unexpected token. Twig was looking for the "tag", "class", "global" or/and "language" keyword.');
        }

        // {% area name 'name' global%} default conntent {% endarea %}
        $stream->expect(\Twig_Token::BLOCK_END_TYPE);
        $body = $this->parser->subparse(array($this, 'decideAreaFork'), true);

        if (!$body instanceof \Twig_Node_Text && !$body instanceof \Twig_Node_Expression) {
            throw new \Twig_Error_Syntax('A message inside a area tag must be a simple text');
        }

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new AreaNode($body, $name, $tag, $class, $language, $isGlobal, $lineNumber, $this->getTag());
    }

    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        return 'area';
    }

    public function decideAreaFork($token)
    {
        return $token->test(array('endarea'));
    }

}
