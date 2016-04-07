/**
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
(function (global, doc) {
    var eZ = global.eZ = global.eZ || {};
    
    'use strict';

    /**
     * Contains logic needed to display website switcher banner.
     *
     * @namespace eZ
     * @class WebsiteSwitcherBanner
     * @constructor
     */
    eZ.WebsiteSwitcherBanner = function (config) {
        var browserLanguages;

        this.preferredLanguage = false;
        this.bannerElement = document.getElementById(config.bannerId || 'website-switcher-banner');
        this.languageElement = document.getElementsByClassName(config.languageClass || 'website-switcher-banner__user-language');
        this.flagElement = document.getElementById(config.flagId || 'website-switcher-banner__flag');
        this.closeElement = document.getElementById(config.closeId || 'website-switcher-banner__close');
        this.switchElement = document.getElementById(config.switchId || 'website-switcher-banner__switch');
        this.hideElement = document.getElementById(config.hideId || 'website-switcher-banner__hide');
        this.cookieName = config.cookieName || 'websiteSwitcherStatus';
        this.days = config.days || 365;
        this.languageLookup = config.languageLookup;
        this.currentSiteaccessLanguage = config.currentSiteaccessLanguage;

        // prepare array of languages preferred by the web browser
        browserLanguages = navigator.languages.map(function (language) {
            var dashIndex = language.indexOf('-');

            return (dashIndex !== -1) ? language.substr(0, dashIndex) : language;
        });

        // match first preferred language from the list of supported languages
        this.preferredLanguage = browserLanguages.filter(function (language) {
            return this.languageLookup.hasOwnProperty(language);
        }.bind(this))[0];
    };

    /**
     * Hides website switcher banner.
     */
    eZ.WebsiteSwitcherBanner.prototype.hideBanner = function () {
        this.bannerElement.classList.remove('website-switcher-banner--fade-in');
        this.bannerElement.classList.add('website-switcher-banner--fade-out');
    };

    /**
     * Show website switcher banner.
     */
    eZ.WebsiteSwitcherBanner.prototype.showBanner = function () {
        this.bannerElement.classList.remove('website-switcher-banner--fade-out');
        this.bannerElement.classList.add('website-switcher-banner--fade-in');
    };

    /**
     * Gets cookie value by name.
     *
     * @param {string} name
     *
     * @return {string}
     */
    eZ.WebsiteSwitcherBanner.prototype.getCookie = function (name) {
        var cookieName = name + '=';
        var ca = document.cookie.split(';');

        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];

            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }

            if (c.indexOf(cookieName) === 0) {
                return c.substring(cookieName.length, c.length);
            }
        }

        return '';
    };

    /**
     * Sets cookie value.
     *
     * @param {string} name
     * @param {string} value
     * @param {int} days
     */
    eZ.WebsiteSwitcherBanner.prototype.setCookie = function (name, value, days) {
        var d = new Date();
        d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));

        var expires = 'expires=' + d.toUTCString();
        document.cookie = name + '=' + value + '; ' + expires;
    };

    /**
     * Hides banner if user is not interested.
     */
    eZ.WebsiteSwitcherBanner.prototype.keepHidden = function () {
        this.setCookie(this.cookieName, '0', this.days);
        this.hideBanner();
    };

    /**
     * Redirects user to the destination language.
     */
    eZ.WebsiteSwitcherBanner.prototype.redirectUser = function () {
        this.setCookie(this.cookieName, this.preferredLanguage, this.days);
        window.location = this.languageLookup[this.preferredLanguage].url;
    };

    /**
     * Displays website switcher banner depending on the cookie status.
     */
    eZ.WebsiteSwitcherBanner.prototype.show = function () {
        if (!this.preferredLanguage || this.preferredLanguage === this.currentSiteaccessLanguage) {
            return;
        }

        var cookieValue = this.getCookie(this.cookieName);

        if (cookieValue === '' || (cookieValue !== this.preferredLanguage && cookieValue !== '0')) {
            var preferredLanguageSettings = this.languageLookup[this.preferredLanguage];

            this.flagElement.classList.add('flag-icon-' + preferredLanguageSettings.flag);

            for (var i = 0; i < this.languageElement.length; i++) {
                this.languageElement[i].textContent = preferredLanguageSettings.language;
            }

            this.hideElement.addEventListener('click', function () {
                this.keepHidden();
            }.bind(this), false);

            this.switchElement.addEventListener('click', function () {
                this.redirectUser();
            }.bind(this), false);

            this.closeElement.addEventListener('click', function () {
                this.hideBanner();
            }.bind(this), false);

            this.showBanner();
        }
    };

})(window, document);
