<?php
/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace OmniProject\EzPlatformWebsiteSwitcherBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;
use Twig_Environment;
use eZ\Publish\Core\Helper\TranslationHelper;
use eZ\Publish\Core\MVC\Symfony\Locale\LocaleConverter;

/**
 * WebsiteSwitcher Twig helper which renders necessary snippet code.
 */
class WebsiteSwitcherTwigExtension extends Twig_Extension
{
    /** @var array */
    private $supportedLanguages = array();

    /** @var array */
    private $options = array();

    /** @var array */
    private $languages = array();

    /** @var \eZ\Publish\Core\MVC\Symfony\Locale\LocaleConverter */
    private $localeConverter;

    /**
     * @param \eZ\Publish\Core\Helper\TranslationHelper $translationHelper
     * @param \eZ\Publish\Core\MVC\Symfony\Locale\LocaleConverter $localeConverter
     * @param array $options
     */
    public function __construct(
        TranslationHelper $translationHelper,
        LocaleConverter $localeConverter,
        $options = array()
    ) {
        $installedLanguages = $translationHelper->getAvailableLanguages();

        $supportedLanguages = array();
        foreach ($installedLanguages as $language) {
            $localeLanguageName = $localeConverter->convertToPOSIX($language);

            $displayName = locale_get_display_language($localeLanguageName, 'en');
            $supportedLanguages[$displayName] = array(
                'country' => locale_get_display_region($localeLanguageName, 'en'),
                'siteaccess' => $translationHelper->getTranslationSiteAccess($language),
                'code' => substr($localeLanguageName, 0, strpos($localeLanguageName, '_')),
                'flag' => strtolower(substr($language, strpos($language, '-')+1, strlen($language)))
            );
        }

        $this->options = $options;
        $this->supportedLanguages = $supportedLanguages;
        $this->localeConverter = $localeConverter;
    }

    /**
     * Sets prioritized array of languages.
     *
     * @param array $value
     */
    public function setLanguages($value)
    {
        $this->languages = $value;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string
     */
    public function getName()
    {
        return 'ez_website_switcher_extension';
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('show_website_switcher_banner', array($this, 'showWebsiteSwitcherBanner'), array(
                'is_safe' => array('html'),
                'needs_environment' => true,
            )),
        );
    }

    /**
     * Renders website switcher banner snippet code.
     *
     * @param \Twig_Environment $twigEnvironment
     * @param array $options
     *
     * @return string
     */
    public function showWebsiteSwitcherBanner(Twig_Environment $twigEnvironment, $options = array())
    {
        foreach ($this->options as $name => $value) {
            if (!isset($options[$name])) {
                $options[$name] = $value;
            }
        }

        $currentSiteaccessLanguage = $this->localeConverter->convertToPOSIX($this->languages[0]);
        $currentSiteaccessLanguage = substr($currentSiteaccessLanguage, 0, strpos($currentSiteaccessLanguage, '_'));

        return $twigEnvironment->render(
            'OmniProjectEzPlatformWebsiteSwitcherBundle::website_switcher.html.twig', array(
                'supportedLanguages' => $this->supportedLanguages,
                'cookieName' => $options['cookieName'],
                'cookieValidityDays' => $options['days'],
                'currentSiteaccessLanguage' => $currentSiteaccessLanguage,
            )
        );
    }
}
