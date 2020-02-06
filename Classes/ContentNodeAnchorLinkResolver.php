<?php

namespace DIU\Neos\AnchorLink;

use Neos\Flow\Annotations as Flow;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Neos\Service\LinkingService;
use Neos\Eel\EelEvaluatorInterface;
use Neos\Eel\Utility;
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
   * @Flow\Inject
   * @var EelEvaluatorInterface
   */
  protected $eelEvaluator;

  /**
   * @Flow\InjectConfiguration("eelContext")
   * @var array
   */
  protected $contextConfiguration;

  /**
   * @Flow\InjectConfiguration(path="contentNodeType")
   * @var string
   */
  protected $contentNodeType;

  /**
   * @Flow\InjectConfiguration(path="anchor")
   * @var string
   */
  protected $anchor;

  /**
   * @Flow\InjectConfiguration(path="label")
   * @var string
   */
  protected $label;

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
      $nodes = $this->nodeSearchService->findByProperties($searchTerm, [$this->contentNodeType], $context, $targetNode);
    } else {
      $q = new FlowQuery([$targetNode]);
      $nodes = $nodes = $q->find('[instanceof ' . $this->contentNodeType . ']')->get();
    }
    return array_values(array_map(function ($node) {
      $anchor = (string) Utility::evaluateEelExpression($this->anchor, $this->eelEvaluator, ['node' => $node], $this->contextConfiguration);
      $label = (string) Utility::evaluateEelExpression($this->label, $this->eelEvaluator, ['node' => $node], $this->contextConfiguration);
      return [
        'value' => $anchor,
        'label' => $label,
      ];
    }, $nodes));
  }
}
