<?php

namespace Claroline\FacebookBundle\Listener;

use Claroline\CoreBundle\Event\RenderAuthenticationButtonEvent;
use Claroline\CoreBundle\Event\InjectJavascriptEvent;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service()
 */
class ExternalAuthenticationListener
{
    private $templating;
    private $facebookManager;

    /**
     * @DI\InjectParams({
     *     "templating"      = @DI\Inject("templating"),
     *     "facebookManager" = @Di\Inject("claroline.manager.facebook_manager")
     * })
     */
    public function __construct($templating, $facebookManager)
    {
        $this->templating = $templating;
        $this->facebookManager = $facebookManager;
    }

    /**
     * @DI\Observe("render_external_authentication_button")
     *
     * @param RenderAuthenticationButtonEvent $event
     * @return string
     */
    public function onRenderButton(RenderAuthenticationButtonEvent $event)
    {
        if ($this->facebookManager->isActive()) {
            $content = $this->templating->render(
                'ClarolineFacebookBundle:Facebook:button.html.twig',
                array()
            );

            $event->addContent($content);
        }
    }

    /**
     * @DI\Observe("inject_javascript_layout")
     *
     * @param InjectJavascriptEvent $event
     * @return string
     */
    public function onInjectJs(InjectJavascriptEvent $event)
    {
        if ($this->facebookManager->isActive()) {
            $content = $this->templating->render(
                'ClarolineFacebookBundle:Facebook:javascript_layout.html.twig',
                array()
            );

            $event->addContent($content);
        }
    }
}
