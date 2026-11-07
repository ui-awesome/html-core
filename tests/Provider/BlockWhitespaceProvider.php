<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Provider;

/**
 * Data provider for {@see \UIAwesome\Html\Core\Tests\Element\BlockWhitespaceTest} test cases.
 */
final class BlockWhitespaceProvider
{
    /**
     * @phpstan-return array<string, array{string, string}>
     */
    public static function preContent(): array
    {
        return [
            'empty' => [
                '',
                "<pre>\n</pre>",
            ],
            'encoded text after CR' => [
                "\rÅ & <b> &amp;",
                "<pre>\n\rÅ &amp; &lt;b&gt; &amp;amp;</pre>",
            ],
            'leading CR' => [
                "\ralpha",
                "<pre>\n\ralpha</pre>",
            ],
            'leading CRLF' => [
                "\r\nalpha",
                "<pre>\n\r\nalpha</pre>",
            ],
            'leading line break' => [
                "\nalpha",
                "<pre>\n\nalpha</pre>",
            ],
            'only CR' => [
                "\r",
                "<pre>\n\r</pre>",
            ],
            'only CRLF' => [
                "\r\n",
                "<pre>\n\r\n</pre>",
            ],
            'only LF' => [
                "\n",
                "<pre>\n\n</pre>",
            ],
            'ordinary' => [
                'alpha',
                '<pre>alpha</pre>',
            ],
            'repeated boundary CR' => [
                "\r\ralpha\r\r",
                "<pre>\n\r\ralpha\r\r</pre>",
            ],
            'repeated boundary CRLF' => [
                "\r\n\r\nalpha\r\n",
                "<pre>\n\r\n\r\nalpha\r\n</pre>",
            ],
            'repeated boundary LF' => [
                "\n\nalpha\n\n",
                "<pre>\n\n\nalpha\n\n</pre>",
            ],
            'repeated line breaks' => [
                "alpha\n\nbeta",
                "<pre>alpha\n\nbeta</pre>",
            ],
            'trailing CR' => [
                "alpha\r",
                "<pre>alpha\r</pre>",
            ],
            'trailing CRLF' => [
                "alpha\r\n",
                "<pre>alpha\r\n</pre>",
            ],
            'trailing line break' => [
                "alpha\n",
                "<pre>alpha\n</pre>",
            ],
        ];
    }

    /**
     * @phpstan-return array<string, array{string, string}>
     */
    public static function preStream(): array
    {
        return [
            'empty' => [
                '',
                '<pre></pre>',
            ],
            'leading CR' => [
                "\ralpha",
                "<pre>\ralpha</pre>",
            ],
            'leading CRLF' => [
                "\r\nalpha",
                "<pre>\r\nalpha</pre>",
            ],
            'leading LF' => [
                "\nalpha",
                "<pre>\nalpha</pre>",
            ],
            'only CR' => [
                "\r",
                "<pre>\r</pre>",
            ],
            'only CRLF' => [
                "\r\n",
                "<pre>\r\n</pre>",
            ],
            'only LF' => [
                "\n",
                "<pre>\n</pre>",
            ],
            'ordinary' => [
                'alpha',
                '<pre>alpha</pre>',
            ],
            'repeated boundary CR' => [
                "\r\ralpha\r\r",
                "<pre>\r\ralpha\r\r</pre>",
            ],
            'repeated boundary CRLF' => [
                "\r\n\r\nalpha\r\n",
                "<pre>\r\n\r\nalpha\r\n</pre>",
            ],
            'repeated boundary LF' => [
                "\n\nalpha\n\n",
                "<pre>\n\nalpha\n\n</pre>",
            ],
            'trailing CR' => [
                "alpha\r",
                "<pre>alpha\r</pre>",
            ],
            'trailing CRLF' => [
                "alpha\r\n",
                "<pre>alpha\r\n</pre>",
            ],
            'trailing LF' => [
                "alpha\n",
                "<pre>alpha\n</pre>",
            ],
        ];
    }

    /**
     * @phpstan-return array<string, array{string, string}>
     */
    public static function textareaContent(): array
    {
        return [
            'empty' => [
                '',
                "<textarea>\n</textarea>",
            ],
            'encoded text after CRLF' => [
                "\r\nÅ & <b> &amp; </textarea>",
                "<textarea>\n\r\nÅ &amp; &lt;b&gt; &amp;amp; &lt;/textarea&gt;</textarea>",
            ],
            'encoded text' => [
                'A & <b>',
                '<textarea>A &amp; &lt;b&gt;</textarea>',
            ],
            'leading CR' => [
                "\ralpha",
                "<textarea>\n\ralpha</textarea>",
            ],
            'leading CRLF' => [
                "\r\nalpha",
                "<textarea>\n\r\nalpha</textarea>",
            ],
            'leading line break' => [
                "\nalpha",
                "<textarea>\n\nalpha</textarea>",
            ],
            'only CR' => [
                "\r",
                "<textarea>\n\r</textarea>",
            ],
            'only CRLF' => [
                "\r\n",
                "<textarea>\n\r\n</textarea>",
            ],
            'only LF' => [
                "\n",
                "<textarea>\n\n</textarea>",
            ],
            'ordinary' => [
                'alpha',
                '<textarea>alpha</textarea>',
            ],
            'repeated boundary CR' => [
                "\r\ralpha\r\r",
                "<textarea>\n\r\ralpha\r\r</textarea>",
            ],
            'repeated boundary CRLF' => [
                "\r\n\r\nalpha\r\n",
                "<textarea>\n\r\n\r\nalpha\r\n</textarea>",
            ],
            'repeated boundary LF' => [
                "\n\nalpha\n\n",
                "<textarea>\n\n\nalpha\n\n</textarea>",
            ],
            'repeated line breaks' => [
                "alpha\n\nbeta",
                "<textarea>alpha\n\nbeta</textarea>",
            ],
            'trailing CR' => [
                "alpha\r",
                "<textarea>alpha\r</textarea>",
            ],
            'trailing CRLF' => [
                "alpha\r\n",
                "<textarea>alpha\r\n</textarea>",
            ],
            'trailing line break' => [
                "alpha\n",
                "<textarea>alpha\n</textarea>",
            ],
        ];
    }

    /**
     * @phpstan-return array<string, array{string, string}>
     */
    public static function textareaStream(): array
    {
        return [
            'empty' => [
                '',
                '<textarea></textarea>',
            ],
            'ordinary' => [
                'alpha',
                '<textarea>alpha</textarea>',
            ],
            'leading LF' => [
                "\nalpha",
                "<textarea>\nalpha</textarea>",
            ],
            'leading CR' => [
                "\ralpha",
                "<textarea>\ralpha</textarea>",
            ],
            'leading CRLF' => [
                "\r\nalpha",
                "<textarea>\r\nalpha</textarea>",
            ],
            'only LF' => [
                "\n",
                "<textarea>\n</textarea>",
            ],
            'only CR' => [
                "\r",
                "<textarea>\r</textarea>",
            ],
            'only CRLF' => [
                "\r\n",
                "<textarea>\r\n</textarea>",
            ],
            'repeated boundary LF' => [
                "\n\nalpha\n\n",
                "<textarea>\n\nalpha\n\n</textarea>",
            ],
            'repeated boundary CR' => [
                "\r\ralpha\r\r",
                "<textarea>\r\ralpha\r\r</textarea>",
            ],
            'repeated boundary CRLF' => [
                "\r\n\r\nalpha\r\n",
                "<textarea>\r\n\r\nalpha\r\n</textarea>",
            ],
            'trailing LF' => [
                "alpha\n",
                "<textarea>alpha\n</textarea>",
            ],
            'trailing CR' => [
                "alpha\r",
                "<textarea>alpha\r</textarea>",
            ],
            'trailing CRLF' => [
                "alpha\r\n",
                "<textarea>alpha\r\n</textarea>",
            ],
        ];
    }
}
