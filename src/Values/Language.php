<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Values;

/**
 * Represents standardized language codes for the HTML `lang` global attribute.
 *
 * Provides a type-safe, standards-compliant set of language identifiers for use in element rendering, attributes,
 * and view helpers, ensuring technical consistency with the HTML specification and IETF BCP 47 standard.
 *
 * Key features.
 * - Designed for use in tags, components, and helpers requiring language code assignment.
 * - Strict mapping of language codes for semantic markup generation and accessibility.
 * - Integration-ready for tag rendering and element generation APIs.
 * - Values follow IETF BCP 47, primarily ISO 639-1 two-letter codes and region variants.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/lang
 * @link https://tools.ietf.org/html/bcp47
 *
 * @copyright Copyright (C) 2025 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Language: string
{
    /**
     * Arabic language code (`ar`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=ar
     */
    case ARABIC = 'ar';

    /**
     * Bengali language code (`bn`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=bn
     */
    case BENGALI = 'bn';

    /**
     * Bulgarian language code (`bg`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=bg
     */
    case BULGARIAN = 'bg';

    /**
     * Catalan language code (`ca`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=ca
     */
    case CATALAN = 'ca';

    /**
     * Chinese language code (`zh`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=zh
     */
    case CHINESE = 'zh';

    /**
     * Chinese Simplified language code (`zh-CN`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=zh
     */
    case CHINESE_SIMPLIFIED = 'zh-CN';

    /**
     * Chinese Traditional language code (`zh-TW`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=zh
     */
    case CHINESE_TRADITIONAL = 'zh-TW';

    /**
     * Croatian language code (`hr`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=hr
     */
    case CROATIAN = 'hr';

    /**
     * Czech language code (`cs`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=cs
     */
    case CZECH = 'cs';

    /**
     * Danish language code (`da`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=da
     */
    case DANISH = 'da';

    /**
     * Dutch language code (`nl`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=nl
     */
    case DUTCH = 'nl';

    /**
     * English language code (`en`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=en
     */
    case ENGLISH = 'en';

    /**
     * English (UK) language code (`en-GB`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=en
     */
    case ENGLISH_UK = 'en-GB';

    /**
     * English (US) language code (`en-US`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=en
     */
    case ENGLISH_US = 'en-US';

    /**
     * Estonian language code (`et`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=et
     */
    case ESTONIAN = 'et';

    /**
     * Finnish language code (`fi`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=fi
     */
    case FINNISH = 'fi';

    /**
     * French language code (`fr`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=fr
     */
    case FRENCH = 'fr';

    /**
     * German language code (`de`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=de
     */
    case GERMAN = 'de';

    /**
     * Greek language code (`el`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=el
     */
    case GREEK = 'el';

    /**
     * Hebrew language code (`he`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=he
     */
    case HEBREW = 'he';

    /**
     * Hindi language code (`hi`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=hi
     */
    case HINDI = 'hi';

    /**
     * Hungarian language code (`hu`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=hu
     */
    case HUNGARIAN = 'hu';

    /**
     * Indonesian language code (`id`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=id
     */
    case INDONESIAN = 'id';

    /**
     * Italian language code (`it`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=it
     */
    case ITALIAN = 'it';

    /**
     * Japanese language code (`ja`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=ja
     */
    case JAPANESE = 'ja';

    /**
     * Korean language code (`ko`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=ko
     */
    case KOREAN = 'ko';

    /**
     * Latvian language code (`lv`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=lv
     */
    case LATVIAN = 'lv';

    /**
     * Lithuanian language code (`lt`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=lt
     */
    case LITHUANIAN = 'lt';

    /**
     * Norwegian language code (`no`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=no
     */
    case NORWEGIAN = 'no';

    /**
     * Polish language code (`pl`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=pl
     */
    case POLISH = 'pl';

    /**
     * Portuguese language code (`pt`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=pt
     */
    case PORTUGUESE = 'pt';

    /**
     * Portuguese (Brazil) language code (`pt-BR`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=pt
     */
    case PORTUGUESE_BRAZIL = 'pt-BR';

    /**
     * Romanian language code (`ro`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=ro
     */
    case ROMANIAN = 'ro';

    /**
     * Russian language code (`ru`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=ru
     */
    case RUSSIAN = 'ru';

    /**
     * Serbian language code (`sr`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=sr
     */
    case SERBIAN = 'sr';

    /**
     * Slovak language code (`sk`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=sk
     */
    case SLOVAK = 'sk';

    /**
     * Slovenian language code (`sl`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=sl
     */
    case SLOVENIAN = 'sl';

    /**
     * Spanish language code (`es`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=es
     */
    case SPANISH = 'es';

    /**
     * Spanish (Latin America/Caribbean) language code (`es-419`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=es
     */
    case SPANISH_LATIN_AMERICA = 'es-419';

    /**
     * Spanish (Spain) language code (`es-ES`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=es
     */
    case SPANISH_SPAIN = 'es-ES';

    /**
     * Swedish language code (`sv`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=sv
     */
    case SWEDISH = 'sv';

    /**
     * Thai language code (`th`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=th
     */
    case THAI = 'th';

    /**
     * Turkish language code (`tr`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=tr
     */
    case TURKISH = 'tr';

    /**
     * Ukrainian language code (`uk`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=uk
     */
    case UKRAINIAN = 'uk';

    /**
     * Vietnamese language code (`vi`).
     *
     * @link https://www.loc.gov/standards/iso639-2/php/langcodes_name.php?lang_code=vi
     */
    case VIETNAMESE = 'vi';
}
