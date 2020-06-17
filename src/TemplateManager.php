<?php

class TemplateManager
{
    /**
     * @var PlaceholderRenderInteface[]
     */
    private $placeholderRenders = [];

    public function getTemplateComputed(Template $tpl, array $data)
    {
        if (!$tpl) {
            throw new \RuntimeException('no tpl given');
        }

        $replaced = clone($tpl);
        $replaced->subject = $this->computeText($replaced->subject, $data);
        $replaced->content = $this->computeText($replaced->content, $data);

        return $replaced;
    }

    public function registerPlaceholderRender(PlaceholderRenderInterface $placeholderRender)
    {
        $this->placeholderRenders[] = $placeholderRender;
    }

    private function computeText($text, array $data)
    {   
        foreach ($this->placeholderRenders as $placeholderRender) {
            $context = $placeholderRender->buildContext($data);

            foreach ($placeholderRender->getPlaceholders() as $placeholder => $renderMethodName) {
                if (strpos($text, $placeholder) !== false) {
                    $text = str_replace(
                        $placeholder,
                        call_user_func([$placeholderRender, $renderMethodName], $context),
                        $text
                    );
                }
            }
        }

        $APPLICATION_CONTEXT = ApplicationContext::getInstance();
        /*
         * USER
         * [user:*]
         */
        $_user  = (isset($data['user'])  and ($data['user']  instanceof User))  ? $data['user']  : $APPLICATION_CONTEXT->getCurrentUser();
        if($_user) {
            (strpos($text, '[user:first_name]') !== false) and $text = str_replace('[user:first_name]'       , ucfirst(mb_strtolower($_user->firstname)), $text);
        }

        return $text;
    }
}
