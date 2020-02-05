<?php

namespace DIU\Neos\AnchorLink;

use Neos\Flow\Annotations as Flow;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Neos\Service\LinkingService;
use Neos\Eel\FlowQuery\FlowQuery;
use Neos\Neos\Domain\Service\NodeSearchService;

/**
 * Create link anchors based on all content nodes within the target link node
 * Uses node name as an anchor
 */
class ContentNodeAnchorLinkResolver implements AnchorLinkResolverInterface
{
  /**
   * @Flow\Inject
   * @var NodeSearchService
   */
  protected $nodeSearchService;

  /**
   * @param NodeInterface $node Currently focused node
   * @param string $link Current link value
   * @param string $searchTerm Search term
   * @return array
   */
  public function resolve(NodeInterface $node, string $link, string $searchTerm)
  {
    $context = $node->getContext();
    $targetNode = null;
    $nodes = [];

    if (preg_match(LinkingService::PATTERN_SUPPORTED_URIS, $link, $matches) === 1) {
      if ($matches[1] === 'node') {
        $targetNode = $context->getNodeByIdentifier($matches[2]) ?? $node;
      }
    }
    if (!$targetNode) {
      return [];
    }

    if ($searchTerm) {
      $nodes = $this->nodeSearchService->findByProperties($searchTerm, ['Neos.Neos:Content'], $context, $targetNode);
    } else {
      $q = new FlowQuery([$targetNode]);
      $nodes = $nodes = $q->find('[instanceof Neos.Neos:Content]')->get();
    }
    return array_values(array_map(function ($node) {
      return [
        'value' => $node->getName(),
        'label' => $node->getLabel(),
      ];
    }, $nodes));
  }
}
