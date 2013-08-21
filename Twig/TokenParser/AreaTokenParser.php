<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <krystian@hexmedia.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
		$lineno = $token->getLine();
		$stream = $this->parser->getStream();

		$vars = new \Twig_Node_Expression_Array(array(), $lineno);
		$areaName = null;
		$isGlobal = false;

		if (!$stream->test(\Twig_Token::BLOCK_END_TYPE)) {
			if ($stream->test('name')) {
				// {% trans with vars %}
				$stream->next();
				$areaName = $this->parser->getExpressionParser()->parseExpression();
			} else {
				throw new \Twig_Error_Syntax('Expecting "name" parameter!');
			}

			if ($stream->test('global')) {
				$stream->next();
				$global = $this->parser->getExpressionParser()->parseExpression();
			}

			if (!$stream->test(\Twig_Token::BLOCK_END_TYPE)) {
				throw new \Twig_Error_Syntax('Unexpected token. Twig was looking for the "with" or "from" keyword.');
			}
		}

		// {% area %}message{% endarea %}
		$stream->expect(\Twig_Token::BLOCK_END_TYPE);
		$body = $this->parser->subparse(array($this, 'decideAreaFork'), true);

		if (!$body instanceof \Twig_Node_Text && !$body instanceof \Twig_Node_Expression) {
			throw new \Twig_Error_Syntax('A message inside a area tag must be a simple text');
		}

		$stream->expect(\Twig_Token::BLOCK_END_TYPE);

//		return new AreaNode($body, $domain, null, $vars, $locale, $lineno, $this->getTag());
	}

	public function decideAreaFork($token)
	{
		return $token->test(array('endarea'));
	}

	/**
	 * Gets the tag name associated with this token parser.
	 *
	 * @return string The tag name
	 */
	public function getTag()
	{
		return 'area';
	}

}
