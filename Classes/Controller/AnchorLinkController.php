<?php

namespace DIU\Neos\AnchorLink\Controller;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\View\JsonView;
use Neos\Flow\Mvc\Controller\ActionController;

class AnchorLinkController extends ActionController
{
    /**
     * @var array
     */
    protected $viewFormatToObjectNameMap = array(
        'json' => JsonView::class
    );
    /**
     * @param string $node
     * @return void
     */
    public function resolveAnchorsAction($node)
    {
        $options = [
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
        $this->view->assign('value', $options);
    }
}
