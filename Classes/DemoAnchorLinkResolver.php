<?php
namespace DIU\Neos\AnchorLink;

use Neos\ContentRepository\Domain\Model\NodeInterface;

class DemoAnchorLinkResolver implements AnchorLinkResolverInterface
{
  /**
   * @param NodeInterface $node Currently focused node
   * @return array
   */
  public function resolve(NodeInterface $node)
  {
    return [
      [
        'group' => 'first',
        'value' => $node->getIdentifier(),
        'label' => $node->getName(),
      ],
      [
        'group' => 'first',
        'value' => 'bar',
        'label' => 'Bar',
      ],
      [
        'group' => 'second',
        'value' => 'baz',
        'label' => 'Baz',
      ]
    ];
  }
}
