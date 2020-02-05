<?php

namespace DIU\Neos\AnchorLink;

use Neos\ContentRepository\Domain\Model\NodeInterface;

interface AnchorLinkResolverInterface
{
  /**
   * Return an array of options for the anchor link selectbox:
   *
   * [
   *      [
   *           'group' => 'first', // optional
   *           'value' => 'bar',
   *           'label' => 'Bar',
   *      ],
   *      [
   *           'group' => 'second',
   *           'value' => 'baz',
   *           'label' => 'Baz',
   *      ]
   * ];
   *
   * @param NodeInterface $node Currently focused node
   * @param string $link Current link value
   * @param string $searchTerm Search term
   * @return array
   */
  public function resolve(NodeInterface $node, string $link, string $searchTerm);
}
