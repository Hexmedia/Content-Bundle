<?php

namespace Hexmedia\ContentBundle\Twig\TokenParser;

use Hexmedia\ContentBundle\Twig\Node\PageNode;

/**
 * Token Parser for the 'area' tag.
 *
 * @author Krystian Kuczek <krystian@hexmedia.pl>
 */
class PageTokenParser extends \Twig_TokenParser
{

	/**
	 * Parses a token and returns a node.
	 *
	 * @param \Twig_Token $token A Twig_Token instance
	 *
	 * @return \Twig_NodeInterface A Twig_NodeInterface instance
	 *
	 * @throws \Twig_Error_Syntax
	 */
	public function parse(\Twig_Token $token)
	{
        $field = "content";
        $class = null;

		$lineno = $token->getLine();
		$stream = $this->parser->getStream();

        if ($stream->test("title")) { //Show title
            $field = "title";
        } else if ($stream->test("content")) { //Show content
            $field = "content";
        }

        $stream->next();

        if ($stream->test("class")) {
            $stream->next();
            $class =  $this->parser->getExpressionParser()->parseExpression();
        }

        $name = $stream->expect(\Twig_Token::NAME_TYPE)->getValue();

		// {% page field class 'class' entity %}

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new PageNode($name, $field, $class, $lineno, $this->getTag());
	}

	/**
	 * Gets the tag name associated with this token parser.
	 *
	 * @return string The tag name
	 */
	public function getTag()
	{
		return 'page';
	}

}
