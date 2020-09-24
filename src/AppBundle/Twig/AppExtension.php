<?php

namespace AppBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('ucwords_custom', array($this, 'ucWordsCustom')),
        );
    }

    public function ucWordsCustom($frase)
    {
        return \AppBundle\Util\Texto::ucWordsCustom($frase);
    }
}