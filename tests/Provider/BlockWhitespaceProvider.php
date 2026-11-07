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
            'empty' => ['', "<pre>\n</pre>"],
            'ordinary' => ['alpha', '<pre>alpha</pre>'],
            'leading line break' => ["\nalpha", "<pre>\n\nalpha</pre>"],
            'trailing line break' => ["alpha\n", "<pre>alpha\n</pre>"],
            'repeated line breaks' => ["alpha\n\nbeta", "<pre>alpha\n\nbeta</pre>"],
        ];
    }

    /**
     * @phpstan-return array<string, array{string, string}>
     */
    public static function textareaContent(): array
    {
        return [
            'empty' => ['', "<textarea>\n</textarea>"],
            'ordinary' => ['alpha', '<textarea>alpha</textarea>'],
            'leading line break' => ["\nalpha", "<textarea>\n\nalpha</textarea>"],
            'trailing line break' => ["alpha\n", "<textarea>alpha\n</textarea>"],
            'repeated line breaks' => ["alpha\n\nbeta", "<textarea>alpha\n\nbeta</textarea>"],
            'encoded text' => ['A & <b>', '<textarea>A &amp; &lt;b&gt;</textarea>'],
        ];
    }
}
