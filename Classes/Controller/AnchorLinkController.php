<?php
namespace DIU\Neos\AnchorLink\Controller;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\View\JsonView;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\ContentRepository\Domain\Model\NodeInterface;

class AnchorLinkController extends ActionController
{
    /**
     * @var \DIU\Neos\AnchorLink\AnchorLinkResolverInterface
     * @Flow\Inject
     */
    protected $resolver;

    /**
     * @var array
     */
    protected $viewFormatToObjectNameMap = array(
        'json' => JsonView::class
    );

    /**
     * @param NodeInterface $node
     * @return void
     */
    public function resolveAnchorsAction(NodeInterface $node)
    {
        $options = $this->resolver->resolve($node);
        $this->view->assign('value', $options);
    }
}
